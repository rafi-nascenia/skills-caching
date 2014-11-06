<?php

require 'vendor/autoload.php';

$runs = 1000;

/*
 * Redis
 */

$redis = new Redis;
$redis->connect('127.0.0.1');

$timer = microtime(true);
for ($i = 0; $i < $runs; $i++) {
    $redis->set('i', $i);
    $redis->get('i');
}
$redisTime = microtime(true) - $timer;
echo 'Redis: '. round(1000 * $redisTime, 2) ." ms\n";

/*
 * APCu
 */

$timer = microtime(true);
for ($i = 0; $i < $runs; $i++) {
    apc_store('i', $i);
    apc_fetch('i');
}
$apcuTime = microtime(true) - $timer;
echo 'APCu: '. round(1000 * $apcuTime, 2) ." ms\n";

/*
 * Memcached
 */

$mem = new Memcached;
$mem->addServer('localhost', 11211);

$timer = microtime(true);
for ($i = 0; $i < $runs; $i++) {
    $mem->set('i', $i);
    $mem->get('i');
}
$memTime = microtime(true) - $timer;
echo 'Memcached: '. round(1000 * $memTime, 2) ." ms\n";
