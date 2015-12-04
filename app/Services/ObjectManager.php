<?php

namespace Resin\Services;

use Input;
use SplFileInfo;

use Resin\Object;
use Resin\Jobs\ImportObjects;
use Resin\Services\FileManager;

use Illuminate\Foundation\Bus\DispatchesJobs;
use League\Csv\Reader;

class ObjectManager
{
    use DispatchesJobs;

    protected $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function objectInfo()
    {
    }

    public function import(\SplFileInfo $file)
    {
        $path = $file->getRealPath();

        //if ($this->fileManager->existsFile($path)) {
            $this->dispatch(new ImportObjects($path));
        /* } else {
            // Throw exception?
        } */


                /* $destinationPath = 'uploads'; // upload path
                $extension = Input::file('objects_file')->getClientOriginalExtension();
                $originalName = Input::file('objects_file')->getClientOriginalName();
                Input::file('objects_file')->move($destinationPath, $originalName);
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
                    $this->dispatch(new ImportObjects($rows));
                }


        /* if ($this->fileManager->existsFile($file)) {
            $this->dispatch(new ImportObjects($file));
        } else {
            die('DOES NOT EXIST');
        } */
    }
}
