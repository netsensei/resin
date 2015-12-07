<?php

namespace Resin\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;

use Resin\Http\Requests;
use Resin\Http\Controllers\Controller;
use Resin\Services\MergeManager;
use Resin\Services\FileManager;

class MergeController extends Controller
{
    protected $manager;

    public function __construct(MergeManager $mergeManager, FileManager $fileManager)
    {
        $this->mergeManager = $mergeManager;
        $this->fileManager = $fileManager;
    }

    public function getIndex()
    {
        $data = $this->mergeManager->mergeInfo();
        return view('merge.overview', $data);
    }

    public function postIndex()
    {
        $this->mergeManager->doMerge();
        $data = $this->mergeManager->mergeInfo();
        return view('merge.overview', $data);
    }

    public function getLatest()
    {
        // @todo
        //  * move file manager to merger model
        //  * fix path
        //  * Make sure download uses original name
        //  * Should return 404 if file or merger not found.
        //  * Move fetch logic to mergeManager

        $merger = $this->mergeManager->fetchLatestMergers(1)->pop();
        $contents = $this->fileManager->getContents($merger->filename);

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => sprintf('attachement;filename:"%s"', $merger->filename)
        ];

        return response($contents, 200, $headers);
    }
}
