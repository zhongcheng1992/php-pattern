<?php
namespace Service\Database;

use Service\Traits\Singleton;

interface IDatabase
{
    /**
     * @param $username string 用户名
     * @param $passwd string 密码
     * @param $dbname string 数据库名称
     * @param $host string 数据库地址
     * @param $port string 端口号
     * @return mixed
     */
    public function connect($username, $passwd, $dbname, $host, $port);

    /**
     * @param $sql string 待执行Sql语句
     * @return mixed 查询结果
     */
    public function query($sql);

    /**
     * @param array $arraySql 通过事务处理多条SQL语句
     * @return mixed 查询结果
     */
    public function execTransaction(array $arraySql);

    /**
     * 关闭数据库连接以释放资源
     * @return mixed
     */
    public function close();
}

