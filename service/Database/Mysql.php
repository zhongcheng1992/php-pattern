<?php
namespace Service\Database;

use Pattern\Database\IDatabase;

class Mysql implements IDatabase
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
     * @return mixed|void
     */
    public function connect($dbuser, $dbpwd, $dbname, $dbhost = 'localhost', $encoding = 'utf-8')
    {
        $this->handle = mysql_connect($dbhost, $dbuser, $dbpwd) or die('无法连接数据库:' . mysql_error());
        mysql_set_charset($encoding);
        mysql_select_db($dbname);
    }

    /**
     * @param string $sql
     * @return resource
     */
    public function query($sql)
    {
        $result = mysql_query($sql);
        return $result;
    }

    /**
     * @param array $arraySql 通过事务处理多条SQL语句
     * @return mixed 查询结果
     */
    public function execTransaction(array $arraySql)
    {
        // TODO: Implement execTransaction() method.
    }

    /**
     * 关闭数据库连接以释放资源
     * @return mixed
     */
    public function close()
    {
        mysql_close($this->link);
    }
}
