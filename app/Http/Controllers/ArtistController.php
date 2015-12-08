<?php

namespace Resin\Http\Controllers;

use DB;
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
            'artists' => $this->artistManager->fetchPaginate(),
            'count_artists' => $this->artistManager->count()
        ];

        return view('artist.artist');
    }

    public function copyPublic()
    {
        $params = [
            'artists' => $this->artistManager->fetchPaginate(),
            'count_artists' => $this->artistManager->count()
        ];

        return view('artist.artist');
    }
}
