<?php

namespace Resin\Http\Controllers;

use HTML;
use Request;
use Validator;
use Redirect;
use Session;

use Resin\Object;
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

    public function upload()
    {
          $file = array('objects_file' => Request::file('objects_file'));
          $rules = array('objects_file' => 'required',);
          $validator = Validator::make($file, $rules);

          if ($validator->fails()) {
            return Redirect::to('object')->withInput()->withErrors($validator);
          }
          else {
            if (Request::file('objects_file')->isValid()) {
                $destinationPath = 'uploads';
                $originalName = Request::file('objects_file')->getClientOriginalName();
                $file = Request::file('objects_file')->move($destinationPath, $originalName);

                Session::flash('success', 'Upload successfully');

                $this->objectManager->import($file);

                return Redirect::to('object');
            }
            else {
              Session::flash('error', 'uploaded file is not valid');
              return Redirect::to('object');
            }
          }
    }
}
