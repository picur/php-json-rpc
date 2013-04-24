<?php
require_once "Loader.php";

class TestService {
    public function run($test) {
        return "TEST ".$test;
    }
    public function calc($a,$b)
    {
        return $a*$b;
    }
}

$loader = new \JustAddicted\Loader\Loader();
$loader->registerNamespace("SectorNord", __DIR__."/SectorNord");
$loader->registerLoader();

$server = new \SectorNord\ZMQ\Rpc\Server();
$server->setZMQSocket("tcp://0.0.0.0:8888");
$server->setService(new TestService());
$server->start();