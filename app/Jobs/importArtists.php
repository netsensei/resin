<?php

namespace Resin\Jobs;

use Resin\Models\Artist;
use Resin\Jobs\Job;

use Session;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use League\Csv\Reader;

class ImportArtists extends Job implements SelfHandling, ShouldQueue
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
            $artist = Artist::firstOrNew(['PID' => $row['PID']]);
            $artist->name = $row['name'];
            $artist->PID = $row['PID'];
            $artist->year_birth = $row['year_birth'];
            $artist->year_death = $row['year_death'];
            if ($artist->save()) {
                $saved++;
            }
        }

        $report = [
            'event' => 'artists.imported',
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
