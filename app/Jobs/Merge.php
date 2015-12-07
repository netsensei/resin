<?php

namespace Resin\Jobs;

use Resin\Jobs\Job;
use Resin\Models\Merger;
use Resin\Services\MergeManager;
use Resin\Services\FileManager;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use SplTempFileObject;
use League\Csv\Writer;
use Carbon\Carbon;


class Merge extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MergeManager $mergeManager, FileManager $fileManager)
    {
        $columns = ['PID', 'entity type', 'title', 'document type', 'URL', 'enabled', 'notes', 'format', 'reference', 'order'];
        $items = $mergeManager->fetchAll();

        $writer = Writer::createFromFileObject(new SplTempFileObject);
        $writer->insertOne($columns);

        $count = 0;
        foreach ($items as $item) {
            $row = [
                $item->object_number,
                $item->entity_type,
                $item->object->title,
                $item->url,
                $item->enabled,
                $item->format,
                $item->representation_order,
                $item->reference
            ];

            $writer->insertOne($row);
            $count++;
        }

        $output = (string) $writer;

        $timestamp = Carbon::now();
        $fileName = sprintf("import_%s.csv", $timestamp->format('dmY_His'));

        $fileManager->saveFile($fileName, $output);

        $merger = new Merger();
        $merger->filename = $fileName;
        $merger->documents = $count;
        $merger->save();

        $context = new \ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect("tcp://localhost:5555");
        $socket->send('test');
    }
}
