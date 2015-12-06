<?php

namespace Resin\Http\Controllers;

use HTML;
use Validator;
use Session;

use Illuminate\Http\Request;

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

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'documents_file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return redirect('document')
                        ->withErrors($validator)
                        ->withInput();
        }

        $destinationPath = 'uploads';
        $originalName = $request->file('documents_file')->getClientOriginalName();
        $file = $request->file('documents_file')->move($destinationPath, $originalName);

        Session::flash('success', 'Upload successfully');

        $this->documentManager->import($file);

        return redirect('document');
    }
}
