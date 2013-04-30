<?php
require_once "Loader.php";

$loader = new \JustAddicted\Loader\Loader();
$loader->registerNamespace("SectorNord", __DIR__ . "/SectorNord");
$loader->registerLoader();

$client2 = new \SectorNord\Transport\ZMQ\Client("tcp://172.20.2.74:8080");

$a = microtime(true);
//$session = $client2->getSessionFor("_USA");
//
//$client2->_setHeader(array("session" => $session));

$c = $client2->getObjects("sv_host");

//print_r($c);

$b = microtime(true) - $a;

echo "Time used: " . $b * 1000 . " ms\n";

echo "\n";