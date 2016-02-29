<?php
error_reporting(E_ERROR);

use NoahBuscher\Macaw\Macaw;
use Service\Pattern\Factory;

require '../vendor/autoload.php';

Macaw::get('/', function() {
    echo 'phplib';
});

Macaw::get('/db/mysql', function() {
    $mysql = Factory::createDb('root', 'fyibmsd', 'test', 'localhost', 'mysql');
    $res = $mysql->query('select version()');
    var_dump($mysql);
    var_dump(mysql_fetch_assoc($res));
    $mysql->close();
});

Macaw::get('/db/mysqli', function() {
    $mysqli = Factory::createDb('root', 'fyibmsd', 'test', 'localhost', 'mysqli');
    // 增
    $result = $mysqli->table('songs')->data(['name' => 'goodbye', 'singer' => 'beatles'])->save();
    // 查
//    $result = $mysqli->table('songs')->field(['name', 'singer'])->find();
    d($result);
    d($mysqli->getLastSql());

});

Macaw::get('/db/pdo',function() {
    $pdo = Factory::createDb('root', 'fyibmsd', 'test', 'localhost', 'pdo');
    var_dump($pdo);
});

Macaw::dispatch();
