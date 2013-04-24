<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 12:41
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\ZMQ\Rpc;

class Client
{
    /**
     * @var string
     */
    protected $socket;

    /**
     * @param string $socket
     */
    function __construct($socket)
    {
        $this->socket = $socket;
    }

    /**
     * @param $socket
     *
     * @return void
     */
    public function setZMQSocket($socket)
    {
        $this->socket = $socket;
    }

    function __call($name, $arguments)
    {
        $context = new \ZMQContext();
        $zmq = new \ZMQSocket($context, \ZMQ::SOCKET_REQ);
        $zmq->connect($this->socket);

        $message = array(
            'jsonrpc' => '2.0',
            'method' => $name,
            'params' => $arguments,
            'id' => round(microtime(true)*100000)
        );

        /** @var \ZMQSocket $resultSocket  */
        $zmq->send(json_encode($message));
        $result = json_decode($zmq->recv(),true);

        if (isset($result['error'])) {
            throw new RpcException($result['exception']['message'],$result['exception']['code']);
        }

        return $result['result'];
    }

}