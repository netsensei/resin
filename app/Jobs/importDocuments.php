<?php

namespace Resin\Jobs;

use Resin\Document;
use Resin\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use League\Csv\Reader;
use Session;

class ImportDocuments extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reader = Reader::createFromPath($this->path);

        $read = 0;
        $saved = 0;
        foreach ($reader->fetchAssoc() as $row) {
            $read++;

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

                if ($document->save()) {
                    $saved++;
                }
            }
        }

        $report = [
            'type' => 'upload',
            'data' => [
                'read' => $read,
                'saved' => $saved,
            ]
        ];
        $message = json_encode($report);

        $context = new \ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect("tcp://localhost:5555");
        $socket->send($message);
    }
}
