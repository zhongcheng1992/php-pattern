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

use Exception;
use PDOException;
use Service\Traits\Singleton;
use Service\Pattern\IDatabase;

class Pdo implements IDatabase
{
    protected $dbh; //database handle
    protected $queryList = [];
    protected $queryId;
    protected $querySql = '';

    use Singleton;

    public function connect($username, $passwd, $dbname, $host, $port)
    {
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';port=' . $port;
        try {
            $this->dbh = new \PDO($dsn, 'root', 'fyibmsd');
        } catch(PDOException $e) {
            $this->printError($e->getMessage());
        }
    }

    public function query($sql)
    {
        $record = $this->dbh->query($sql);
        $this->getPDOError();

        $record->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $record->fetchAll();

        return $result;
    }

    /**
     * 获取表引擎
     *
     * @param String $dbName 库名
     * @param String $tableName 表名
     * @return String
     */
    public function getTableEngine($dbName, $tableName)
    {
        $strSql = "SHOW TABLE STATUS FROM $dbName WHERE Name='".$tableName."'";
        $arrayTableInfo = $this->query($strSql);
        return $arrayTableInfo->fetchColumn();
    }

    /**
     * beginTransaction 事务开始
     */
    private function beginTransaction()
    {
        $this->dbh->beginTransaction();
    }

    /**
     * commit 事务提交
     */
    private function commit()
    {
        $this->dbh->commit();
    }

    /**
     * rollback 事务回滚
     */
    private function rollback()
    {
        $this->dbh->rollback();
    }

    /**
     * transaction 通过事务处理多条SQL语句
     * 调用前需通过getTableEngine判断表引擎是否支持事务
     *
     * @param array $arraySql
     * @return Boolean
     */
    public function execTransaction(array $arraySql)
    {
        $retval = 1;
        $this->beginTransaction();
        foreach ($arraySql as $strSql) {
            if ($this->query($strSql) == 0) $retval = 0;
        }
        if ($retval == 0) {
            $this->rollback();
            return false;
        } else {
            $this->commit();
            return true;
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
        }

        exit('调用函数出错!');
    }

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



    public function close()
    {
        unset($this->dbh);
    }

    private function getPDOError()
    {
        if ($this->dbh->errorCode() != '00000') {
            $errorInfo = $this->dbh->errorInfo();
            throw new Exception('数据库错误: ' . $errorInfo[2]);
        }
    }
}
