<?php

namespace Resin\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use Resin\Models\Object;
use Resin\Models\Document;
use Resin\Http\Requests;
use Resin\Http\Controllers\Controller;
use Resin\Services\MergeManager;
use Resin\Services\ArtistManager;

class HomeController extends Controller
{
    protected $mergeManager;

    public function __construct(MergeManager $mergeManager, ArtistManager $artistManager)
    {
        $this->mergeManager = $mergeManager;
        $this->artistManager = $artistManager;
    }

    public function index()
    {
        // @todo
        //  * Use managers/repositories instead of fat models.
        //  * Add the id as parameter to merge/latest
        $params = [
            'count_objects' => Object::count(),
            'count_objects_no_work_pid' => Object::countHasNoWorkPid(),
            'count_objects_has_work_pid' => Object::countHasWorkPid(),
            'count_documents' => Document::count(),
            'count_mergable_documents' => Document::countMergableDocuments(),
            'count_orphan_documents' => Document::countOrphanDocuments(),
            'count_artists' => $this->artistManager->count(),
            'mergers' => $this->mergeManager->fetchLatestMergers(5)
        ];

        return view('index', $params);
    }
}
