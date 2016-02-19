<?php
/**
* Mysql.class.php  MySQL 操作类
*
* @author      fyibmsd <fyibmsd@gmail.com>
* @copyright   phplib 2015-7-17
* @link        https://github.com/fyibmsd/phplib.git
* @version     1.1
*/
namespace Lib\Database;

class Mysql extends db
{
	protected $queryList = array();	// 查询条件

	protected $queryId;	// 当前查询ID

	protected $error = '';	// 错误

	protected $querySql = '';
	/**
	* +----------
	* | 单例模式
	* +----------
	*/
	protected static $instance = NULL;	// 静态属性保证单一的实例

	private function __construct() {}	// 私有，防止被实例化

	private function __clone() {}	// 私有，防止被克隆

	public static function getInstance($config)
	{
		isset($config) ?:  die('未找到数据库配置');

		if(self::$instance == NULL) {
			self::$instance = new self();
		}
		self::$instance->connect($config);
		return self::$instance;
	}
	// 连接数据库操作
	public function connect($config)
	{
		mysql_connect(
			$config[ENV]['host'] . ':' . $config[ENV]['port'],
			$config[ENV]['user'],
			$config[ENV]['password']

		) or die('无法连接数据库:' . mysql_error());
		// 设置字符集、选择数据库、表
		mysql_set_charset($config['charset']);
		mysql_select_db($config['db']) or die('数据库 ' . $config['db'] . ' 不存在!');
		$this->queryList['table'] = $config['table'];
	}

	/**
	* +----------
	* | 设置数据对象值
	* | table, where, order, limit, data, field, join, group, having
	* +----------
	*/
	public function __call($name, $args)
	{
		$func  = ['table', 'where', 'order', 'limit', 'data', 'field', 'join', 'group', 'having'];
		!empty($args) ?: die('参数错误');
		if(in_array($name, $func)) {
			switch ($name) {
				case 'limit':
					if(!$args[1]) {
						$args[1] = $args[0];
						$args[0] = 0;
					}
					$this->queryList['limit'] = ' limit ' . $args[0] . ',' . $args[1];
					return $this;
				case 'field':
					if(is_array($args[0])) {
						$this->queryList['field'] = '`' . implode('`,`', $args[0]) . '`';
					}
					return $this;
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
					return $this;
				case 'data':
					// var_dump($args);exit;
					foreach ($args[0] as $key => $val) {
						$field .= '`' . $key . '`,';
						$value .= '\'' . $val . '\',';
					}
					$this->queryList['data'] = ' (' . rtrim($field, ',') . ')' . ' values ' . '(' . rtrim($value, ',') . ')';
					return $this;
				default:
					$this->queryList[$name] = $args[0];
					return $this;
			}
		}
		exit('调用函数出错，请重试！');
	}

	/**
	* +----------
	* | 数据操作
	* | save, delete, update, find, findAll
	* +----------
	*/

	// 执行增加操作
	public function save()
	{
		$sql = 'insert into ' . $this->queryList['table'];
		$sql .= $this->queryList['data'];
		return $this->execute($sql);
	}

	// 执行删除操作
	public function delete()
	{
		$sql = 'delete from ' . $this->queryList['table'];
		$sql .= $this->queryList['where'];
		return $this->execute($sql);
	}

	// 执行更新操作
	public function update($data)
	{
		$sql = 'update ' . $this->queryList['table'] . ' set ';

		if(is_array($data)) {
			foreach ($data as $key => $val) {
				$sql .= ' where ';
				$condition .= '`' . $key . '` = \'' . $val . '\' and ';
			}
		} else {
			$condition = $data;
		}
		$sql .= $condition;
		$sql .= $this->queryList['where'];
		return $this->execute($sql);
	}

	// 查找一条数据
	public function find()
	{
		$fields = empty($this->queryList['field']) ? '*' : $this->queryList['field'];
		$sql = 'select ' . $fields . ' from ' . $this->queryList['table'];
		$sql .= isset($this->queryList['where']) ? $this->queryList['where'] : '';
		return mysql_fetch_assoc($this->execute($sql));
	}

	// 查询多条数据
	public function findAll()
	{
		$fields = empty($this->queryList['field']) ? '*' : $this->queryList['field'];
		$sql = 'select ' . $fields . ' from ' . $this->queryList['table'];

		!isset($this->queryList['limit']) ?: $sql .= $this->queryList['limit'];


		$result = $this->execute($sql);
		while($res = @mysql_fetch_assoc($result)) {
			$data[] = $res;
		}
		return $data;
	}

	// 返回记录数
	public function count()
	{
		$sql = 'select count(1) as count from ' . $this->queryList['table'];
		$res = mysql_fetch_assoc($this->execute($sql));
		return intval($res['count']);
	}

	// 执行查询操作
	public function execute($sql)
	{
		$this->querySql = $sql;
		unset($this->queryList);
		return mysql_query($sql);
	}

	public function getLastSql()
	{
		print '<pre>' . $this->querySql . '</pre>';
	}
}
