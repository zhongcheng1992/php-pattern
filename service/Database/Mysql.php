<?php
namespace Service\Database;

class Mysql
{
    /**
     * 保证实例单一性
    */
    protected static $instance = null;

    public $handle;

    private function __construct() {}

    private function __clone() {}

    /**
     * 获取单一实例
     * @return object
     */
    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * 连接到数据库
     * @param string $dbuser 用户名
     * @param string $dbpwd 密码
     * @param string $dbname 数据库名
     * @param string $dbhost 数据库地址
     * @param string $encoding 数据库编码
     */
    public function connect($dbuser, $dbpwd, $dbname, $dbhost = 'localhost', $encoding = 'utf-8')
    {
        $this->handle = @mysql_connect($dbhost, $dbuser, $dbpwd) or die('无法连接数据库:' . mysql_error());
        @mysql_set_charset($encoding);
        @mysql_select_db($dbname);
    }

    public function query($sql)
    {
        $result = @mysql_query($sql);
        return @mysql_fetch_assoc($result);
    }

    public function disconnect()
    {
        @mysql_close($this->link);
    }

}
