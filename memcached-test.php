<?php

$mem = new Memcached;
$mem->addServer('localhost', 11211);

$mem->set('nascenia', 'foobar');

var_dump($mem->get('nascenia'));
