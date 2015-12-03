<?php

namespace Resin\Jobs;

use Resin\Document;
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

class ImportDocuments extends Job implements SelfHandling, ShouldQueue
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
            $object_number = $row['object_number'];
            unset($row['object_number']);
            foreach ($row as $key => $value) {
                $document = Document::firstOrNew(['url' => $value]);
                $document->object_number = $object_number;
                $document->url = $value;

                if ($key == "data") {
                    $document->type = "data";
                    $document->order = "";
                } else {
                    list($type, $order) = explode("_", $key);
                    $document->type = $type;
                    $document->order = (isset($order)) ? $order: "";
                }

                $document->save();
            }
        }
    }
}