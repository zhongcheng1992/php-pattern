<?php

namespace Lib\Database;

class Pdo extends Db
{

    protected static $ins = null;   // 数据库连接实例
    protected $conn;

    private function __construct() {}	// 私有，防止被实例化

    private function __clone() {}	// 私有，防止被克隆

    /**
     * 获取实例的方法
     */
    public static function getInstance($config)
    {
        if(self::$ins == null) {
            self::$ins = new self();
        }
        self::$ins->connect($config);
        return self::$ins;
    }

    /**
     * 连接方法
     */
    public function connect($config)
    {
        $this->conn = new \PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['user'], $config['password']);
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }
}
