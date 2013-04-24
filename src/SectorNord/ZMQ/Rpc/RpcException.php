<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 12:46
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\ZMQ\Rpc;


class RpcException extends \Exception{
    function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }


}