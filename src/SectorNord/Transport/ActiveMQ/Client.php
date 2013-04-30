<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 17:15
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\Transport\ActiveMQ;


class Client extends \SectorNord\Transport\Client{
    function __construct($socket, $queue)
    {
        $this->queue = $queue;
        parent::__construct($socket);

        $this->amq = new \Stomp($this->socket);
        $this->queueName = '/temp-queue/'.time().round(microtime(true)*10000);

    }

    protected function sendMessage($message)
    {
        $messageObj = json_decode($message);
        $this->id = $messageObj->id;

        $this->amq->subscribe($this->queueName, array('correlation-id' => $this->id));
        $this->amq->send($this->queue, $message, array('reply-to' => $this->queueName, 'correlation-id' => $this->id));
    }

    protected function awaitResponse()
    {
        while (!($queueObject = $this->amq->readFrame())) {
        }

        $msg = $queueObject->body;
        $this->amq->ack($queueObject);
        $this->amq->unsubscribe($this->queueName);
        return json_decode($msg,true);

    }
}