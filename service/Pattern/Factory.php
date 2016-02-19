<?php
/**
 * 工厂类
*/
namespace Service\Pattern;

use Service\Database\Mysql;
use Service\Database\Mysqli;
use Service\Database\Pdo;

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
        Register::set($driver, $obj);
        return $obj;
    }

}