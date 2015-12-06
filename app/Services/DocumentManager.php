<?php

namespace Resin\Services;

use Input;
use SplFileInfo;

use Resin\Models\Document;
use Resin\Jobs\ImportDocuments;
use Resin\Services\FileManager;

use Illuminate\Foundation\Bus\DispatchesJobs;

class DocumentManager
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
            $this->dispatch(new ImportDocuments($file->getRealPath()));
        } else {
            // Throw exception?
        }
    }
}
