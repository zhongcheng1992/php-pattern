<?php
/**
 * Redis缓存类
 */
namespace Service\Cache;

class Redis
{
    protected static $redis;

    public static function init($host, $port)
    {
        self::$redis = new \Redis();
        self::$redis->connect($host, $port);
    }

    public static function get($key)
    {
        return self::$redis->get($key);
    }

    public static function set($key, $value)
    {
        return self::$redis->set($key, $value);
    }

    public static function delete($key)
    {

        return self::$redis->del($key);
    }

    private static function _setex($key, $value, $time)
    {
        self::$redis->setex($key, $time, $value);
    }

    private static function _psetex($key, $value, $time)
    {
        self::$redis->psetex($key, $time, $value);
    }
}
