<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 16:08
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\Transport\ZMQ;

class Server extends \SectorNord\Transport\Server
{
    /** @var \ZMQSocket */
    protected $zmq;

    /**
     * @return mixed
     */
    protected function receiveMessage()
    {
        $message = $this->zmq->recv();
        return $message;
    }

    /**
     * @param $response
     */
    protected function postMessage($response)
    {
        $this->zmq->send($response);
    }

    protected function initServer()
    {
        $context = new \ZMQContext();
        $this->zmq = new \ZMQSocket($context, \ZMQ::SOCKET_REP);
        $this->zmq->bind($this->socket);

    }
}