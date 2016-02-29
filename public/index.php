<?php
error_reporting(E_ALL);

use NoahBuscher\Macaw\Macaw;
use Whoops\Run as Whoops;
use Whoops\Handler\PrettyPageHandler;
use Service\Pattern\Factory;
use Service\Database\UsersModel as Users;

require '../vendor/autoload.php';

define('BASE_PATH', realpath('..'));

// whoops 错误提醒
$whoops = new Whoops;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

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

Macaw::get('/db/orm', function() {
    /** 增
    $users = new Users();
    $users->name = 'admin';
    $users->password = 'fyibmsd';
    $users->email = 'aaa@fyibmsd.com';
    $users->updated_at = time();
    $res = $users->save();
    */

    /** 查
    $users = Users::findById(1);
    var_dump($users);
     */
});

Macaw::dispatch();
