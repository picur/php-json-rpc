<?php
require_once "Loader.php";

$loader = new \JustAddicted\Loader\Loader();
$loader->registerNamespace("SectorNord", __DIR__."/SectorNord");
$loader->registerLoader();

$client = new \SectorNord\Transport\ActiveMQ\Client("tcp://localhost","test");

$client2 = new \SectorNord\Transport\ZMQ\Client("tcp://localhost:8888");

$a = microtime(true);

$data = $client2->big();

$b = microtime(true) - $a;

echo "Time used 1-time: ".$b. "\n";

echo "\n";