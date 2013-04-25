<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 17:08
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\Transport;


use SectorNord\Rpc\JSON\Request;

abstract class Client {

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
    public function setSocket($socket)
    {
        $this->socket = $socket;
    }

    function __call($name, $arguments)
    {
        $request = new Request($name, $arguments);

        $this->sendMessage($request->__toString());
        $result = $this->awaitResponse();

        if (isset($result['error'])) {
            throw new \Exception($result['exception']['message'],$result['exception']['code']);
        }

        return $result['result'];
    }

    abstract protected function sendMessage($message);
    abstract protected function awaitResponse();


}