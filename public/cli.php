#!/usr/local/bin/php
<?php
$debug = new debug();

require '../vendor/autoload.php';

use Service\Strategy\bookStrategy;
use Service\Strategy\movieStrategy;
use Service\Strategy\Resource;

$params = $_SERVER['argv'];
define('BASE_PATH', realpath('..'));

if(!isset($params[1])) {
print <<<'EOT'
USEAGE:
    book {$name}  --  search book by book name
    movie {$name}  --  search movie by movie name
EOT;
    exit(PHP_EOL);
}

switch($params[1]) {
    case 'book':
    case 'movie':
        search($params[1], $params[2]);
        $debug->runtime();
}


function search($type, $name)
{
    /**
     * 策略模式实例化资源搜索类
     * 实现依赖注入
    */
    $resource = new Resource();
    if($type == 'book') {
        $strategy = new bookStrategy();
    } elseif ($type == 'movie') {
        $strategy = new movieStrategy();
    }

    $resource->setStrategy($strategy);
    $resource->strategy->search($name);
}


class debug
{
    public $start;

    public function __construct()
    {
        $this->start = $this->get_current_time();
    }

    public function start()
    {
        $this->__construct();
    }

    public function runtime()
    {
        echo 'Runtime: ' . ($this->get_current_time() - $this->start) . 'sec' . PHP_EOL;
    }

    public function get_current_time()
    {
        list ($msec, $sec) = explode(' ', microtime());
        return (float) $msec + (float) $sec;
    }
}
