<?php

namespace Resin\Http\Controllers;

use HTML;
use Input;
use Validator;
use Redirect;
use Session;
use Resin\Object;
use Resin\Http\Controllers\Controller;
use Resin\Jobs\ImportObjects;
use League\Csv\Reader;

class ObjectController extends Controller
{
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
          $file = array('objects_file' => Input::file('objects_file'));
          $rules = array('objects_file' => 'required',);
          $validator = Validator::make($file, $rules);

          if ($validator->fails()) {
            return Redirect::to('object')->withInput()->withErrors($validator);
          }
          else {
            if (Input::file('objects_file')->isValid()) {
                $destinationPath = 'uploads'; // upload path
                $extension = Input::file('objects_file')->getClientOriginalExtension();
                $originalName = Input::file('objects_file')->getClientOriginalName();
                Input::file('objects_file')->move($destinationPath, $originalName);
                Session::flash('success', 'Upload successfully');

                $file = public_path() . '/uploads/' . $originalName;
                $csv = Reader::createFromPath($file);
                $count = iterator_count($csv->fetch());

                $limit = 10;
                $iterations = $count / $limit;
                for ($iteration = 0; $iteration <= $iterations; $iteration++)
                {
                    $offset = $iteration * $limit;
                    $rows = $csv->setOffset($offset)->setLimit($limit)->fetchAssoc();
                    $this->dispatch(new ImportObjects($rows));
                }

                return Redirect::to('object');
            }
            else {
              Session::flash('error', 'uploaded file is not valid');
              return Redirect::to('object');
            }
          }
    }
}
