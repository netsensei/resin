<?php

namespace Resin\Http\Controllers;

use DB;
use Resin\Document;
use Session;
use Illuminate\Http\Request;
use Resin\Http\Requests;
use Resin\Http\Controllers\Controller;

class MergeController extends Controller
{
    public function getIndex()
    {
        $base_query = Document::whereHas('object', function($query) {
            $query->where('work_pid', '<>', '');
        })
        ->with('object');

        $params = [
            'merge_count' => $base_query->count(),
            'documents' => $base_query->simplePaginate(50)
        ];

        return view('merge.overview', $params);
    }
}
