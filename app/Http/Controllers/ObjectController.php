<?php

namespace Resin\Http\Controllers;

use HTML;
use Validator;
use Session;

use Illuminate\Http\Request;

use Resin\Models\Object;
use Resin\Services\ObjectManager;
use Resin\Http\Controllers\Controller;


class ObjectController extends Controller
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function index()
    {
        $objects = Object::simplePaginate(20);
        return view('object.object', ['objects' => $objects]);
    }

    public function withoutPid()
    {
        $base_query = Object::where('work_pid', '=', '');
        $objects = $base_query->simplePaginate(20);

        return view('object.object', ['objects' => $objects]);
    }

    public function withPid()
    {
        $base_query = Object::where('work_pid', '<>', '');
        $objects = $base_query->simplePaginate(20);
        return view('object.object', ['objects' => $objects]);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'objects_file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return redirect('object')
                        ->withErrors($validator)
                        ->withInput();
        }

        $destinationPath = 'uploads';
        $originalName = $request->file('objects_file')->getClientOriginalName();
        $file = $request->file('objects_file')->move($destinationPath, $originalName);

        Session::flash('success', 'Upload successfully');

        $this->objectManager->import($file);

        return redirect('object');
    }
}
