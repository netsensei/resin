<?php

namespace Resin\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;
use Resin\Http\Requests;
use Resin\Http\Controllers\Controller;
use Resin\Services\MergeManager;

class MergeController extends Controller
{
    protected $manager;

    public function __construct(MergeManager $manager)
    {
        $this->manager = $manager;
    }

    public function getIndex()
    {
        $data = $this->manager->mergeInfo();
        return view('merge.overview', $data);
    }

    public function postIndex()
    {
        $this->manager->doMerge();
        $data = $this->manager->mergeInfo();
        return view('merge.overview', $data);
    }
}
