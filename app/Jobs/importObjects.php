<?php

namespace Resin\Jobs;

use Resin\Object;
use Resin\Jobs\Job;
use Resin\Jobs\ChecksHTTPStatus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use League\Csv\Reader;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Session;

class ImportObjects extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $rows;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->rows as $row) {
            $object = Object::firstOrNew(['object_number' => $row['object_number']]);
            $object->title = $row['title'];
            $object->work_pid = $row['work_pid'];
            $object->save();
        }
    }
}
