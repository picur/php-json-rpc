<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 17:12
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\Transport\ZMQ;


class Client extends \SectorNord\Transport\Client {
    function __construct($socket)
    {
        parent::__construct($socket);

        $context = new \ZMQContext();
        $this->zmq = new \ZMQSocket($context, \ZMQ::SOCKET_REQ);
        $this->zmq->connect($this->socket);
    }

    /**
     * @param $message
     *
     * @return void
     */
    protected  function sendMessage($message)
    {
        /** @var \ZMQSocket $resultSocket */
        $this->zmq->send($message);
    }

    /**
     * @return mixed
     */
    protected function awaitResponse()
    {
        return json_decode($this->zmq->recv(), true);
    }
}