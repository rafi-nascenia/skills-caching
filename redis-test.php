<?php

require 'vendor/autoload.php';

$client = new Predis\Client;

$client->set('nascenia', 'foobar');

var_dump($client->get('nascenia'));
