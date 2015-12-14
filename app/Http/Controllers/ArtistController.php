<?php

namespace Resin\Http\Controllers;

use HTML;
use Validator;
use Session;

use Illuminate\Http\Request;

use Resin\Http\Requests;
use Resin\Http\Controllers\Controller;
use Resin\Services\ArtistManager;

class ArtistController extends Controller
{
    protected $artistManager;

    public function __construct(ArtistManager $artistManager)
    {
        $this->artistManager = $artistManager;
    }

    public function index()
    {
        $params = [
            'artists' => $this->artistManager->fetchPaginate(),
            'count_artists' => $this->artistManager->count()
        ];

        return view('artist.artist', $params);
    }

    public function copyProtected()
    {
        $params = [
            'artists' => $this->artistManager->fetchProtected(),
            'count_artists' => $this->artistManager->count()
        ];

        return view('artist.artist', $params);
    }

    public function copyPublic()
    {
        $params = [
            'artists' => $this->artistManager->fetchPublic(),
            'count_artists' => $this->artistManager->count()
        ];

        return view('artist.artist', $params);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artists_file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return redirect('artist')
                        ->withErrors($validator)
                        ->withInput();
        }

        $destinationPath = 'uploads';
        $originalName = $request->file('artists_file')->getClientOriginalName();
        $file = $request->file('artists_file')->move($destinationPath, $originalName);

        Session::flash('success', 'Upload successfully');

        $this->artistManager->import($file);

        return redirect('artist');
    }
}
