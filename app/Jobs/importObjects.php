<?php

namespace Resin\Jobs;

use Resin\Object;
use Resin\Jobs\Job;

use Session;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use League\Csv\Reader;


class ImportObjects extends Job implements SelfHandling, ShouldQueue
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
            $object = Object::firstOrNew(['object_number' => $row['object_number']]);
            $object->title = $row['title'];
            $object->work_pid = $row['work_pid'];
            if ($object->save()) {
                $saved++;
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
