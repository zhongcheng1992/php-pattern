<?php
$debug = new debug();

require '../vendor/autoload.php';

use Service\Pattern\Factory;

$params = $_SERVER['argv'];
define('BASE_PATH', realpath('..'));

switch($params[1]) {
    case 'book':
    case 'movie':
        search($params[1], $params[2]);
        $debug->runtime();
}


function search($type, $name)
{
    $resource = Factory::getResource($type);
    $resource->search($name);
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