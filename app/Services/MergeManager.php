<?php

namespace Resin\Services;

use Resin\Document;
use Resin\Jobs\Merge;

use Illuminate\Foundation\Bus\DispatchesJobs;

class MergeManager
{
    use DispatchesJobs;

    protected $baseQuery;

    public function __construct()
    {
        $this->baseQuery = Document::whereHas('object', function($query) {
            $query->where('work_pid', '<>', '');
        })
        ->with('object');
    }

    public function fetchAll()
    {
        return $this->baseQuery->get();
    }

    public function mergeInfo()
    {
        $data = [
            'merge_count' => $this->baseQuery->count(),
            'documents' => $this->baseQuery->simplePaginate(50)
        ];

        return $data;
    }

    public function doMerge()
    {
        $this->dispatch(new Merge());
    }
}
