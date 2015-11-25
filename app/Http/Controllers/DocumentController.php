<?php

namespace Resin\Http\Controllers;

use HTML;
use Input;
use Validator;
use Redirect;
use Session;
use Resin\Document;
use Resin\Http\Controllers\Controller;
use Resin\Jobs\ImportDocuments;
use League\Csv\Reader;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::simplePaginate(20);
        return view('document.document', ['documents' => $documents]);
    }

    public function upload()
    {
          $file = array('documents_file' => Input::file('documents_file'));
          $rules = array('documents_file' => 'required',);
          $validator = Validator::make($file, $rules);

          if ($validator->fails()) {
            return Redirect::to('document')->withInput()->withErrors($validator);
          }
          else {
            if (Input::file('documents_file')->isValid()) {
                $destinationPath = 'uploads'; // upload path
                $extension = Input::file('documents_file')->getClientOriginalExtension();
                $originalName = Input::file('documents_file')->getClientOriginalName();
                Input::file('documents_file')->move($destinationPath, $originalName);
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
                    $this->dispatch(new ImportDocuments($rows));
                }

                return Redirect::to('document');
            }
            else {
              Session::flash('error', 'uploaded file is not valid');
              return Redirect::to('document');
            }
          }
    }
}
