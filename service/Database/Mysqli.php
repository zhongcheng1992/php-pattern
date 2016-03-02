<?php
/**
 * Mysql.class.php  MySQL 操作类
 *
 * @author      fyibmsd <fyibmsd@gmail.com>
 * @copyright   phplib 2015-7-17
 * @link        https://github.com/fyibmsd/phplib.git
 * @version     1.2
 */
namespace Service\Database;

use Service\Pattern\IDatabase;

class Mysqli implements IDatabase
{
    protected static $instance = null;
    protected $dbh;
    protected $queryList = [];
    protected $queryId;
    protected $querySql = '';

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

    public function connect($username, $passwd, $dbname, $host = "localhost", $port = "3306")
    {
        $this->dbh = new \mysqli($host, $username, $passwd, $dbname, $port);
        if($this->dbh->connect_errno) {
            printf("连接数据库失败 : %s\n", $this->dbh->connect_error);
        }
    }

    public function __call($name, $args)
    {
        $func  = ['table', 'where', 'order', 'limit', 'data', 'field', 'join', 'group', 'having'];

        !empty($args) ? : die('参数错误');

        if(in_array($name, $func)) {
            switch($name) {
                case 'field':
                    $this->queryList['field'] = implode($args[0], ',');
                    break;
                case 'table':
                    $this->queryList['table'] = $args[0];
                    break;
                case 'data':
                    $field = $value = '';
                    foreach ($args[0] as $key => $val) {
                        $field .= '`' . $key . '`,';
                        $value .= '\'' . $val . '\',';
                    }
                    $this->queryList['data'] = ' (' . rtrim($field, ',') . ')' . ' values ' . '(' . rtrim($value, ',') . ')';
                    break;
                case 'where':
                    if(is_array($args[0])) {
                        $condition = '';
                        foreach ($args[0] as $key => $val) {
                            $condition .= '`' . $key . '` = \'' . $val . '\' and ';
                        }
                    } else {
                        $condition = $args[0] == null ? '' : ' where ' . $args[0];
                    }
                    $this->queryList['where'] = is_string($condition) ? $condition : ' where ' . rtrim($condition, ' and ');
                    break;
                case 'limit':
					if(!$args[1]) {
                        $args[1] = $args[0];
                        $args[0] = 0;
                    }
					$this->queryList['limit'] = ' limit ' . $args[0] . ',' . $args[1];
            }
            return $this;
        } else {
            die('调用函数出错');
        }
    }

    /**
     * 数据库操作
    */
    public function save()
    {
        /**
         * @var string $table
         * @var string $data
         */
        extract($this->queryList);
        $sql = 'insert into ' . $table . $data;
        return $this->query($sql);
    }

    /**
     * @return mixed
     */
    public function find()
    {
        /**
         * @var string $field
         * @var string $table
         */
        extract($this->queryList);

        $sql = 'select ' . $field . ' from ' . $table;
        return $this->query($sql);
    }

    public function count()
    {}

    public function query($sql)
    {
        $this->querySql = $sql;
        $result = $this->dbh->query($sql);
        return $result;
    }

    public function getLastSql()
    {
        printf("查询语句: %s", $this->querySql);
    }

    /**
     * @param array $arraySql 通过事务处理多条SQL语句
     * @return mixed 查询结果
     */
    public function execTransaction(array $arraySql)
    {
        // TODO: Implement execTransaction() method.
    }

    public function close()
    {
        return mysqli_close($this->dbh);
    }

}
