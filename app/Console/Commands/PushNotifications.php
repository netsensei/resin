<?php

namespace Resin\Console\Commands;

use Illuminate\Console\Command;
use React\ZMQ\Context;
use React\EventLoop\Factory;
use React\Socket\Server;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Wamp\WampServer;
use Resin\Services\MergeNotification;

class PushNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wamp:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifications server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $loop   = Factory::create();
        $mergeNotification = new MergeNotification();

        // Listen for the web server to make a ZeroMQ push after an ajax request
        $context = new Context($loop);
        $pull = $context->getSocket(\ZMQ::SOCKET_PULL);
        $pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself

        $pull->on('message', array($mergeNotification, 'onMergeComplete'));
        $pull->on('message', array($mergeNotification, 'onUploadComplete'));

        // Set up our WebSocket server for clients wanting real-time updates
        $webSock = new Server($loop);
        $webSock->listen(8080, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect
        $webServer = new IoServer(
            new HttpServer(
                new WsServer(
                    new WampServer(
                        $mergeNotification
                    )
                )
            ),
            $webSock
        );

        $loop->run();
    }
}
