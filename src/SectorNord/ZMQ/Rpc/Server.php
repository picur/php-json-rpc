<?php

namespace SectorNord\ZMQ\Rpc;

class Server
{
    /**
     * @var string
     */
    protected $socket;

    /**
     * @var array
     */
    protected $endpoints = array();

    /**
     * @param string $endpoint
     * @param mixed  $class
     *
     * @throws EndpointAlreadyBoundException
     * @return Server
     */
    public function addService($endpoint, $class)
    {
        if (isset($this->endpoints[$endpoint])) {
            throw new EndpointAlreadyBoundException();
        }
        $this->endpoints[$endpoint] = $class;
        return $this;
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
            usleep(10000);
            try {

                $message = '' . $zmq->recv(\ZMQ::MODE_NOBLOCK);

                if (empty($message)) {
                    continue;
                }

                $object = json_decode($message, true);

                $endpoint = $object['endpoint'];
                $method = $object['method'];
                $args = $object['args'];

                echo "Received RPC-Call for: $endpoint => $method \n";
                try {
                    $start = microtime(true);
                    $resultdata = call_user_func_array(array($this->endpoints[$endpoint], $method), $args);
                    $result = array('response' => json_encode($resultdata), 'executiontime' => microtime(true)-$start);
                    $resultString = json_encode($result);
                    $zmq->send($resultString);


                } catch (\Exception $e) {
                    $result = array('exception' => array('message' => $e->getMessage(), 'code' => $e->getCode()));
                    $zmq->send(json_encode($result));
                }

            } catch (\Exception $e) {

            }
        }

    }

}