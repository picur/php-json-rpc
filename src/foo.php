<?php
require_once "Loader.php";

class Test {
    public function run($test) {
        return "TEST ".$test;
    }
}

$loader = new \JustAddicted\Loader\Loader();
$loader->registerNamespace("SectorNord", __DIR__."/SectorNord");
$loader->registerLoader();

$client = new \SectorNord\ZMQ\Rpc\Client("tcp://localhost:8888","default");

$value = $client->run("ggg");
echo $value."\n";