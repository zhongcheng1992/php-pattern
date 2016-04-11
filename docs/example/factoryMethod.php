<?php

class CacheFactory
{
    public static function setCache($driver)
    {
        switch ($driver) {
            case 'file':
                $cache = new fileCache();
                break;
            case 'redis':
                $cache = new redisCache();
                break;
            default:
                $cache = new Cache();
        }
        return $cache;
    }
}

class Cache {}

class fileCache extends Cache {}

class redisCache extends Cache {}

$cache = CacheFactory::setCache('redis');
