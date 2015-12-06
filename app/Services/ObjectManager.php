<?php

namespace Resin\Services;

use Input;
use SplFileInfo;

use Resin\Models\Object;
use Resin\Jobs\ImportObjects;
use Resin\Services\FileManager;

use Illuminate\Foundation\Bus\DispatchesJobs;

class ObjectManager
{
    use DispatchesJobs;

    protected $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function import(SplFileInfo $file)
    {
        $fileName = $file->getFilename();
        if ($this->fileManager->existsFile($fileName)) {
            $this->dispatch(new ImportObjects($file->getRealPath()));
        } else {
            // Throw exception?
        }
    }
}
