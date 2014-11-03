Skill Development - Caching
===========================

Enhance application performance using caching (Faisal, Rafi)

1. Compare between different caching like memcache, redis, APC - [details](/COMPARISON.md)
2. How caching can be integrated in php CMS and frameworks - [details](/IMPLEMENTATION.md)
3. How caching can be integrated in other platforms (rails, python)
4. provides docs on findings and show an demo application with cache integration 

## Redis

Run the following to install redis:

```
sudo apt-get install redis-server
```

## APCu

Run the following to install apcu:

```
sudo apt-get install php5-apcu
```

Then enable apcu by including the following in your `php.ini`:

```
[apc]
apc.enabled=true
apc.enable_cli=true
```

## Memcached

Run the following to install memcached:

```
sudo apt-get install memcached
sudo apt-get install php5-memcached
```
