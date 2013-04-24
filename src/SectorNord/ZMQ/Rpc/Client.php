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
     * @var string
     */
    protected $endpoint;

    /**
     * @param string $socket
     * @param string $endpoint
     */
    function __construct($socket, $endpoint)
    {
        $this->socket = $socket;
        $this->endpoint = $endpoint;
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

    /**
     * @param $endpoint
     *
     * @return void
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    function __call($name, $arguments)
    {
        $context = new \ZMQContext();
        $zmq = new \ZMQSocket($context, \ZMQ::SOCKET_REQ);
        $zmq->connect($this->socket);

        $message = array(
            'endpoint' => $this->endpoint,
            'method' => $name,
            'args' => $arguments
        );

        /** @var \ZMQSocket $resultSocket  */
        $zmq->send(json_encode($message));
        $result = json_decode($zmq->recv(),true);

        if (isset($result['exception'])) {
            throw new RpcException($result['exception']['message'],$result['exception']['code']);
        }

        return json_decode($result['response'], true);
    }

}