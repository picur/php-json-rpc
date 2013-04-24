<?php
require_once "Loader.php";

$loader = new \JustAddicted\Loader\Loader();
$loader->registerNamespace("SectorNord", __DIR__."/SectorNord");
$loader->registerLoader();

$client = new \SectorNord\ZMQ\Rpc\Client("ipc://2kservice");

$a = microtime(true);

$data = $client->big();

$b = microtime(true) - $a;

echo "Time used 1-time: ".$b. "\n";

$a = microtime(true);

for ($i = 0; $i < 10000; $i++){
    $data = $client->big();

}

$b = microtime(true) - $a;

echo "Time used 10000-times: ".$b." (". $b/10000 ." each)\n";

echo "\n";