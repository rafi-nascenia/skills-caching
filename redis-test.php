<?php

require 'vendor/autoload.php';

$client = new Redis;
$client->connect('127.0.0.1');

$client->set('nascenia', 'foobar');

var_dump($client->get('nascenia'));
