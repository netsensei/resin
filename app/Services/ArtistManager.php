<?php

namespace Resin\Services;

use Input;
use SplFileInfo;

use Resin\Models\Artist;
use Resin\Jobs\ImportArtists;
use Resin\Services\FileManager;
use Carbon\Carbon;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ArtistManager
{
    use DispatchesJobs;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function fetchPaginate()
    {
        return Artist::orderBy('name', 'asc')->simplePaginate(25);
    }

    public function fetchPublic()
    {
        $now = Carbon::now()->subYears(71)->year;
        return Artist::where('year_death', '<', $now)
            ->orderBy('name', 'asc')
            ->simplePaginate(25);
    }

    public function fetchProtected()
    {
        $now = Carbon::now()->subYears(71)->year;
        return Artist::where('year_death', '>', $now)
            ->orderBy('name', 'asc')
            ->simplePaginate(25);
    }

    public function count()
    {
        return Artist::orderBy('name', 'asc')->count();
    }

    public function import(SplFileInfo $file)
    {
        $fileName = $file->getFilename();
        if ($this->fileManager->existsFile($fileName)) {
            $this->dispatch(new ImportArtists($file->getRealPath()));
        } else {
            // Throw exception?
        }
    }
}
