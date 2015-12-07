<?php

namespace Resin\Services;

use Resin\Models\Document;
use Resin\Models\Merger;
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

    public function count()
    {
        return $this->baseQuery->count();
    }

    public function fetchAll()
    {
        return $this->baseQuery->get();
    }

    public function mergeInfo()
    {
        $data = [
            'merge_count' => $this->baseQuery->count(),
            'documents' => $this->baseQuery->simplePaginate(50),
            'latest' => $this->fetchLatestMergers(1)->pop()
        ];

        return $data;
    }

    public function fetchLatestMergers($limit = 5)
    {
        return Merger::orderBy('created_at', 'desc')->take($limit)->get();
    }

    public function doMerge()
    {
        $this->dispatch(new Merge());
    }
}
