<?php

namespace Resin\Services;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

class PushNotificationManager implements WampServerInterface {
    /**
     * A lookup of all the topics clients have subscribed to
     */
    protected $subscribedTopics = array();

    public function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
    }

    public function onOpen(ConnectionInterface $conn)
    {
    }

    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        // In this application if clients send data it's because the user hacked around in console
        $conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }

    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        // In this application if clients send data it's because the user hacked around in console
        $conn->close();
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

    public function onSubscribe(ConnectionInterface $conn, $topic)
    {
        $this->subscribedTopics[$topic->getId()] = $topic;
    }

    // Turn this into an event emitter of sorts, register handlers as separate
    // classes.
    public function onMessage($message)
    {
        $data = json_decode($message, true);

        if (isset($data['event'])) {
            switch ($data['event']) {
                case 'artists.imported':
                case 'objects.imported':
                case 'documents.imported':
                    $this->onUploadComplete($data['data']);
                    break;
                case 'merge':
                    $this->onMergeComplete($data['data']);
                    break;
            }
        }
    }

    public function onUploadComplete($uploadJob)
    {
        if (!array_key_exists('uploadJob', $this->subscribedTopics)) {
            return;
        }
        $topic = $this->subscribedTopics['uploadJob'];

        $topic->broadcast($uploadJob);
    }

    /**
     * @param string JSON'ified string we'll receive from ZeroMQ
     */
    public function onMergeComplete($mergeJob)
    {
        if (!array_key_exists('mergeJob', $this->subscribedTopics)) {
            return;
        }

        $topic = $this->subscribedTopics['mergeJob'];

        $topic->broadcast($mergeJob);
    }
}
