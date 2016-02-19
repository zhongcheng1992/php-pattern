<?php
class sqlite extends db
{
	protected static $instance = NULL;

	protected $link;

	private $query_list;

	private $error;

	// 连接数据库操作
	public function connect($file = ':memory:') {
		$this->link = new SQLite3($file, SQLITE3_OPEN_READWRITE);
	}

	public function __call($name, $args)
	{
		$func  = array('table', 'where', 'order', 'limit', 'data', 'field', 'join', 'group', 'having');

		if($name == 'table') {
			$this->query_list = [];
		}

		if(in_array($name, $func)) {
			$this->query_list[$name] = $args[0];
			return $this;
		}
		$this->error = '调用函数出错';
	}

	private function __construct() {}

	private function __clone() {}

	public static function getInstance() {
		if(self::$instance == NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	// 增加记录
	public function save()
	{
		$query = $this->autoCreate();
		$sql = 'insert into ' . $this->query_list['table'] . $query['data'];
		return $this->exec($sql);
	}

	// 查找记录
	public function find()
	{
		$query = $this->autoCreate();
		
		$sql = 'select ' . $query['field'] . ' from ' . $this->query_list['table'] . $query['where'];

		$result = $this->exec($sql);
		
		return $result->fetchArray(SQLITE3_ASSOC);
	}

	public function findAll()
	{
		$query = $this->autoCreate();

		$sql = 'select ' . $query['field'] . ' from ' . $this->query_list['table'] . $query['where'];

		$result = $this->exec($sql);

		while($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$rows[] = $row;
		}
		return $rows;
	}

	// 更新记录
	public function update()
	{
		$query = $this->autoCreate();
		$sql = 'update ' . $this->query_list['table'] . ' set ' . $query['data'] . $query['where'];
		return $this->exec($sql);
	}

	// 删除记录
	public function delete()
	{
		$query = $this->autoCreate();
		$sql = 'delete from ' . $this->query_list['table'] . $query['where'];
		return $this->exec($sql);
	}

	public function exec($sql)
	{
		return $this->link->query($sql);
	}

	// 自动合并sql
	private function autoCreate()
	{
		$query = [];

		if(array_key_exists('field', $this->query_list)) {
			$query['field'] = $this->query_list['field'];
		} else {
			$query['field'] = '*';
		}

		if(array_key_exists('where', $this->query_list)) {
			$where = ['keys' => '', 'vals' => ''];
			foreach ($this->query_list['where'] as $key => $val) {
				$where['keys'] .= $key . ', ';
				$where['vals'] .= $val . ', ';
			}
			$query['where'] = ' where (' . rtrim($where['keys'], ', ') . ') = (' . rtrim($where['vals'], ', ') . ')';
		}

		if(array_key_exists('data', $this->query_list)) {
			foreach ($this->query_list['data'] as $key => $val) {
				$field .= '`' . $key . '`,';
				$value .= '\'' . $val . '\',';
			}
			$query['data'] = ' (' . rtrim($field, ',') . ')' . ' values ' . '(' . rtrim($value, ',') . ')';
		}

		if(array_key_exists('limit', $this->query_list)) {

		}

		return $query;
	}


}
