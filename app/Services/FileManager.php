<?php

namespace Resin\Services;

use Storage;

class FileManager
{
    protected $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('local');
    }

    public function getDiskPath()
    {
        return config('local');
    }

    /**
     * Sanitize the folder name
     */
    protected function cleanFolder($folder)
    {
        return '/' . trim(str_replace('..', '', $folder), '/');
    }

    public function existsFile($path)
    {
        $path = $this->cleanFolder($path);
        return $this->disk->exists($path);
    }

    /**
    * Delete a file
    */
    public function deleteFile($path)
    {
        $path = $this->cleanFolder($path);

        if (! $this->disk->exists($path)) {
            return "File does not exist.";
        }

        return $this->disk->delete($path);
    }

    /**
     * Save a file
     */
    public function saveFile($path, $content)
    {
        $path = $this->cleanFolder($path);

        if ($this->disk->exists($path)) {
          return "File already exists.";
        }

        return $this->disk->put($path, $content);
    }

    public function getContents($path)
    {
        return $this->disk->get($path);
    }
}
