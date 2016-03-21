<?php
error_reporting(E_ALL);

use NoahBuscher\Macaw\Macaw;
use Service\Config\Config;
use Service\Prototype\Canvas;
use Service\Event\Event;
use Service\Event\ObserverDemo;
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
    foreach(Macaw::$routes as $route) {
        echo "<a href='{$route}'>{$route}</a><br/>";
    }
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

Macaw::get('/event', function() {
    $event = new Event();

    $event->addObserver(new ObserverDemo('Observer No.1'));

    $event->addObserver(new ObserverDemo('Observer No.2'));

    $event->trigger();
});

Macaw::get('/prototype', function() {
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

Macaw::get('/decorator', function() {
    $canvas = new Canvas();
    $canvas->init();
    // 装饰器模式
    $canvas->addDecorator(new ColorDecorator('green'));
    $canvas->addDecorator(new SizeDecorator(30));
    $canvas->rect(3, 6, 4, 12);
    $canvas->draw();
});

Macaw::get('/config', function() {
    $config = new Config(BASE_PATH . '/config/config.php');
    var_dump($config['database']);

    unset($config['database']);

    var_dump(isset($config['database']));
    var_dump($config);

});

Macaw::get('/yaml', function() {
    $config = new Service\Config\Yaml(BASE_PATH . '/config/config.yaml');
    var_dump($config['database']);

});

Macaw::dispatch();
