<?php

require 'vendor/autoload.php';

if (file_exists('tmp/doctrine.sqlite')) {
    unlink('tmp/doctrine.sqlite');
}

/*
 * Doctrine configuration
 */

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * @param Cache $cache
 * @return EntityManager
 */
function createEntityManager(Cache $cache)
{
    $paths = array(
        'src/Nascenia/Entity',
    );

    $dbParams = array(
        'driver' => 'pdo_sqlite',
        'path'   => 'tmp/doctrine.sqlite',
    );

    $isDevMode = false;

    $proxyDir = 'tmp/proxies';

    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, false);
    return EntityManager::create($dbParams, $config);
}

function updateDatabaseSchema(EntityManager $manager)
{
    $tool = new Doctrine\ORM\Tools\SchemaTool($manager);
    $metadata = $manager->getMetadataFactory()->getAllMetadata();
    $tool->updateSchema($metadata, true);

}

function generateEntities(EntityManager $manager, $runs)
{
    for ($i = 0; $i < $runs; $i++) {
        $entity = new Nascenia\Entity\Sample;
        $manager->persist($entity);
    }
    $manager->flush();
}

$runs = 1000;

/*
 * In-memory
 */

$cache = new Doctrine\Common\Cache\ArrayCache;
$manager = createEntityManager($cache);

updateDatabaseSchema($manager);

generateEntities($manager, $runs);

$timer = microtime(true);
$repo = $manager->getRepository('Nascenia\Entity\Sample');
for ($i = 0; $i < $runs; $i++) {
    $repo->find($i + 1);
}
$inMemoryTime = microtime(true) - $timer;
echo 'In-memory: '. round(1000 * $inMemoryTime, 2) ." ms\n";

/*
 * Redis
 */

$redis = new Redis;
$redis->connect('127.0.0.1');
$cache = new Doctrine\Common\Cache\RedisCache;
$cache->setRedis($redis);

$manager = createEntityManager($cache);

$timer = microtime(true);
$repo = $manager->getRepository('Nascenia\Entity\Sample');
for ($i = 0; $i < $runs; $i++) {
    $repo->find($i + 1);
}
$redisTime = microtime(true) - $timer;
echo 'Redis: '. round(1000 * $redisTime, 2) ." ms\n";

/*
 * APCu
 */

$cache = new Doctrine\Common\Cache\ApcCache;
$manager = createEntityManager($cache);

$timer = microtime(true);
$repo = $manager->getRepository('Nascenia\Entity\Sample');
for ($i = 0; $i < $runs; $i++) {
    $repo->find($i + 1);
}
$apcuTime = microtime(true) - $timer;
echo 'APCu: '. round(1000 * $apcuTime, 2) ." ms\n";
