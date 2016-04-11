<?php
error_reporting(E_ALL);

use Service\Event\Event;
use Service\Config\Config;
use Service\Framework\Route;
use Service\Prototype\Canvas;
use Service\Event\ObserverDemo;
use Whoops\Run as Whoops;
use Whoops\Handler\PrettyPageHandler;
use Service\Pattern\Factory;

require '../vendor/autoload.php';

define('BASE_PATH', realpath('..'));

// whoops 错误提醒
$whoops = new Whoops;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

/**
 * 首页
*/
Route::get('/', $msg = '目录',  function() {
    foreach(Route::$routes as $route) {
        echo <<<EOL
<a href='{$route}' style='font-size: 18px;margin: 5px;display: block;text-decoration: none'>{$route}</a><br/>
EOL;
    }
});

/**
 * 文档
 */
Route::get('/docs', $msg = "文档", "DocsController@index");

/**
 * Mysql类
*/
Route::get('/db/mysql', $msg, function() {
    $mysql = Factory::createDb('root', 'fyibmsd', 'test', 'localhost', 'mysql');
    $res = $mysql->query('select version()');
    var_dump($mysql);
    var_dump(mysql_fetch_assoc($res));
    $mysql->close();
});

Route::get('/db/mysqli', $msg, function() {
    $mysqli = Factory::createDb('root', 'fyibmsd', 'test', 'localhost', 'mysqli');
    // 增
    $result = $mysqli->table('songs')->data(['name' => 'goodbye', 'singer' => 'beatles'])->save();
    // 查
//    $result = $mysqli->table('songs')->field(['name', 'singer'])->find();
    d($result);
    d($mysqli->getLastSql());

});

Route::get('/db/pdo',$msg, function() {
    $pdo = Factory::createDb('root', 'fyibmsd', 'test', 'localhost', 'pdo');
    var_dump($pdo);
});

Route::get('/db/orm', $msg, function() {
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

Route::get('/event', $msg, function() {
    $event = new Event();

    $event->addObserver(new ObserverDemo('Observer No.1'));

    $event->addObserver(new ObserverDemo('Observer No.2'));

    $event->trigger();
});

Route::get('/prototype', $msg, function() {
    $prototype = new Canvas();
    $prototype->init();

    $canvasA = clone $prototype;
    $canvasA->rect(3, 6, 4, 12);
    $canvasA->draw();

    echo '<hr/>';
    $canvasB = clone $prototype;
    $canvasB->rect(1, 3, 2, 6);
    $canvasB->draw();
});

Route::get('/decorator', $msg, function() {
    $canvas = new Canvas();
    $canvas->init();
    // 装饰器模式
    $canvas->addDecorator(new ColorDecorator('green'));
    $canvas->addDecorator(new SizeDecorator(30));
    $canvas->rect(3, 6, 4, 12);
    $canvas->draw();
});

Route::get('/config', $msg, function() {
    $config = new Config(BASE_PATH . '/config/config.php');
    var_dump($config['database']);

    unset($config['database']);

    var_dump(isset($config['database']));
    var_dump($config);

});

Route::get('/yaml', $msg = 'yaml', function() {
    $config = new Service\Config\Yaml(BASE_PATH . '/config/config.yaml');
    var_dump($config['database']);

});

Route::dispatch();
