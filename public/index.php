<?php
error_reporting(E_ERROR);

use Slim\App;
use Slim\Container;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Service\Pattern\Factory;
use Service\Pattern\Register;
use Service\Database\Mysqli;

require '../vendor/autoload.php';

$container = new Container([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$app = new App($container);

$app->get('/', function($request, $response, $args) {
    d($request);
    d($response);
    d($args);
});

$app->get('/db/mysql', function() {
    $mysql = Factory::createDb();
    $mysql->connect('root', 'fyibmsd', 'test', 'localhost');
    $res = $mysql->query('select version()');
    var_dump($mysql);
    var_dump($res);
});

$app->get('/db/mysqli', function() {
    $mysqli = Factory::createDb('root', 'fyibmsd', 'test', 'localhost', 'mysqli');
    // 增
    $result = $mysqli->table('songs')->data(['name' => 'goodbye', 'singer' => 'beatles'])->save();
    // 查
//    $result = $mysqli->table('songs')->field(['name', 'singer'])->find();
    d($result);
    d($mysqli->getLastSql());

});

$app->get('/db/pdo', function() {
    $pdo = Factory::createDb('root', 'fyibmsd', 'test', 'localhost', 'pdo');
});



$app->run();
