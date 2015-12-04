<?php

namespace Resin\Services;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

class MergeNotification implements WampServerInterface {
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

    public function onUploadComplete($uploadJob)
    {
        if (!array_key_exists('uploadJob', $this->subscribedTopics)) {
            return;
        }
        $topic = $this->subscribedTopics['uploadJob'];

        $topic->broadcast(json_decode($uploadJob));
    }

    /**
     * @param string JSON'ified string we'll receive from ZeroMQ
     */
    public function onMergeComplete($mergeJob)
    {
        $entryData = [
            'foo' => 'barrrr',
        ];

        if (!array_key_exists('mergeJob', $this->subscribedTopics)) {
            return;
        }

        $topic = $this->subscribedTopics['mergeJob'];


        $topic->broadcast($entryData);
    }
}
