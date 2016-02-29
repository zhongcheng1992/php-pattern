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
use Pattern\Database\IDatabase;

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
        return $this->dbh->query($sql);
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

    public function close()
    {
        unset($this->dbh);
    }

    private function printError($errMessage)
    {
        throw new Exception('数据库错误:' . $errMessage);
    }

}
