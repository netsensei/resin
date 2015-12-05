<?php

namespace Resin\Http\Controllers;

use HTML;
use Request;
use Validator;
use Redirect;
use Session;

use Resin\Document;
use Resin\Services\DocumentManager;
use Resin\Http\Controllers\Controller;

class DocumentController extends Controller
{
    protected $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function index()
    {
        $documents = Document::simplePaginate(20);
        return view('document.document', ['documents' => $documents]);
    }

    public function orphans()
    {
        $documents = Document::doesntHave('object')->simplePaginate(50);
        return view('document.orphans', ['documents' => $documents]);
    }

    public function upload()
    {
          $file = array('documents_file' => Request::file('documents_file'));
          $rules = array('documents_file' => 'required',);
          $validator = Validator::make($file, $rules);

          if ($validator->fails()) {
            return Redirect::to('document')->withInput()->withErrors($validator);
          }
          else {
            if (Request::file('documents_file')->isValid()) {
                $destinationPath = 'uploads';
                $originalName = Request::file('documents_file')->getClientOriginalName();
                $file = Request::file('documents_file')->move($destinationPath, $originalName);

                Session::flash('success', 'Upload successfully');

                $this->documentManager->import($file);

                return Redirect::to('document');
            }
            else {
              Session::flash('error', 'uploaded file is not valid');
              return Redirect::to('document');
            }
          }
    }
}
