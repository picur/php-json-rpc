<?php

namespace SectorNord\ZMQ\Rpc;

class Server
{
    /**
     * @var string
     */
    protected $socket;

    /**
     * @var mixed
     */
    protected $service;

    /**
     * @param mixed  $class
     *
     * @throws EndpointAlreadyBoundException
     * @return Server
     */
    public function setService($class)
    {
        $this->service = $class;
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
     * Starts an endless running service
     */
    public function start()
    {
        $context = new \ZMQContext();
        $zmq = new \ZMQSocket($context, \ZMQ::SOCKET_REP);
        $zmq->bind($this->socket);
        while (true) {
            try {

                $message = '' . $zmq->recv();
                $object = json_decode($message, true);

                $method = $object['method'];
                $args = $object['params'];
                $id = $object['id'];

                $response = array('jsonrpc' => '2.0', 'id' => $id);

                try {
                    if (!method_exists($this->service, $method)) throw new \Exception("Method does not exist", 404);
                    $response['result'] = call_user_func_array(array($this->service, $method), $args);
                    $zmq->send(json_encode($response));

                } catch (\Exception $e) {
                    $response['result'] = array('message' => $e->getMessage(), 'code' => $e->getCode());
                    $zmq->send(json_encode($response));
                }

            } catch (\Exception $e) {

            }
        }

    }

}