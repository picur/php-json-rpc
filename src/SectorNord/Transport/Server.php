<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 16:14
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\Transport;


use SectorNord\Rpc\JSON\Request;
use SectorNord\Rpc\JSON\RequestDispacher;

abstract class Server {

    /** @var string */
    protected $socket;

    /** @var mixed */
    protected $service;

    function __construct($zmqSocket, $service)
    {
        $this->socket = $zmqSocket;
        $this->service = $service;
    }

    public function listen()
    {
        $this->initServer();
        while (true) {
            try {

                $message = $this->receiveMessage();
                $object = Request::fromString($message);
                echo time()." - ".$object->getMethod()." ".print_r($object->getParams(),true)."\n";
                $dispatcher = new RequestDispacher($object, $this->service);
                $response = $dispatcher->getResponse();
                $this->postMessage($response->__toString());
            } catch (\Exception $e) {

            }
        }


    }

    abstract protected function initServer();
    abstract protected function receiveMessage();
    abstract protected function postMessage($response);

}