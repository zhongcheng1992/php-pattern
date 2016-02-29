<?php
/**
 * 工厂模式
 * 工厂类
*/
namespace Service\Pattern;

use Service\Cache\File;
use Service\Cache\Redis;
use Service\Database\Mysql;
use Service\Database\Mysqli;
use Service\Database\Pdo;
use Service\Strategy\bookStrategy;
use Service\Strategy\movieStrategy;

class Factory
{
    public static function createDb($username, $passwd, $dbname, $host = "localhost",  $driver = 'mysqli', $port = "3306")
    {
        switch($driver) {
            case 'mysqli':
                $obj = Mysqli::getInstance();
                break;
            case 'pdo':
                $obj = Pdo::getInstance();
                break;
            default:
                $obj = Mysql::getInstance();
                break;
        }

        $obj->connect($username, $passwd, $dbname, $host , $port);
        self::register($driver, $obj);
        return $obj;
    }

    /**
     * 工厂模式 实例化资源搜索类
     * @param $type string 要搜索的资源类型
     * @return bookStrategy|movieStrategy
     */
    public static function getResource($type)
    {
        switch($type) {
            case 'book':
                $obj = new bookStrategy();
                break;

            case 'movie':
            default:
                $obj = new movieStrategy();
                break;
        }

        self::register($type, $obj);
        return $obj;
    }

    public static function setCache($type = 'redis')
    {
        $config = self::getenv($type);

        switch($type) {
            case 'redis':
                $cache = new Redis();
                $cache::init($config['host'], $config['port']);
                break;
            case 'file':
            default:
                $cache = new File();
                break;
        }
        self::register($type, $cache);
        return $cache;
    }

    private static function register($type, $obj)
    {
        Register::set($type, $obj);
    }

    private static function getenv($type)
    {
        $config = require BASE_PATH . '/config/config.php';
        return $config[$type];
    }


}