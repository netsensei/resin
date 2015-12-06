<?php

namespace Resin\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Resin\Models\Object;
use Resin\Models\Document;
use Resin\Http\Requests;
use Resin\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $params = [
            'count_objects' => Object::count(),
            'count_objects_no_work_pid' => Object::countHasNoWorkPid(),
            'count_objects_has_work_pid' => Object::countHasWorkPid(),
            'count_documents' => Document::count(),
            'count_mergable_documents' => Document::countMergableDocuments(),
            'count_orphan_documents' => Document::countOrphanDocuments()
        ];
        return view('index', $params);
    }
}
