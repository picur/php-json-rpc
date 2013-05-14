<?php
require_once "Loader.php";

$loader = new \JustAddicted\Loader\Loader();
$loader->registerNamespace("SectorNord", __DIR__ . "/../src/SectorNord");
$loader->registerLoader();

$client2 = new \SectorNord\Transport\ZMQ\Client("tcp://10.10.10.40:8080");

$a = microtime(true);

$c = $client2->getObject("00C1");

$b = microtime(true) - $a;

print_r($c);

echo "Time used: " . $b * 1000 . " ms\n";

echo "\n";
