<?php
/**
 * page.class.php  pagination分页类
 *
 * @author      fyibmsd <fyibmsd@gmail.com>
 * @copyright   phplib 2015-7-21
 * @link        https://github.com/fyibmsd/phplib.git
 * @version     1.0
 */


class page
{

	public $rollPage = 5;
	public $listRows = 20;
	public $totalRows = 0;
	public $totalPage = 0;
	public $limit = 0;
	private $url = [];

	private $config = [
		'header' => '<span class="rows">共 %TOTAL_ROW% 条记录</span>',
		'prev'   => '上一页',
		'next'   => '下一页',
		'first'  => '1...',
		'last'   => '...%TOTAL_PAGE%',
		'theme'  => '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%',
	];

	public function __construct($total, $list)
	{
		$this->url = explode('/p/', $_SERVER['REQUEST_URI']);
		$url = $this->url;

		$this->totalRows = $total;
		$this->listRows = $list;

		$this->limit = $url[1] ? $this->listRows * ($url[1] - 1) : 0;


	}

	public function setConfig($arr)
	{
		foreach($arr as $key => $val) {
			$this->$key = $val;
		}
	}

	private function getPage()
	{
		$url = $this->url;

		$this->totalPage = ceil($this->totalRows / $this->listRows);var_dump($this->totalRows);

		$next = '<a href=" ' . $url[0] . '/p/' . ($url[1] + 1) . '">下一页</a>';
		$page = [
			'header' => "共[$this->totalRows]条记录  $url[1] / $this->totalPage 页",
			'prev' => '<a href="' . $url[0] . '/p/' . ($url[1] - 1) . '">' . $this->config['prev'] . '</a>',
			'next' => '<a href="' . $url[0] . '/p/' . ($url[1] + 1) . '">' . $this->config['next'] . '</a>'
		];

		switch($url[1]) {
			case null :
				$page['prev'] = '';
				$page['next'] = '<a href="' . $url[0] . '/p/' . ($url[1] + 2) . '">' . $this->config['next'] . '</a>';
				break;
			case 1 :
				$page['prev'] = '';
				break;
			case $this->totalPage :
				$page['next'] = '';
				break;
		}

		return $page;
	}

	public function show()
	{
		$page = $this->getPage();
		echo $page['header'], $page['prev'], $page['next'];
	}


}
