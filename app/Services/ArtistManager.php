<?php

namespace Resin\Services;

use Input;
use SplFileInfo;

use Resin\Models\Artist;
// use Resin\Jobs\ImportDocuments;
// use Resin\Services\FileManager;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ArtistManager
{
    public function fetchPaginate()
    {
        return Artist::orderBy('name', 'asc')->simplePaginate(25);
    }

    public function count()
    {
        return Artist::orderBy('name', 'asc')->count();
    }
}
