<?php

require 'autoload.php';

use Lib\Database\Pdo;

$db = Pdo::getInstance(require 'public/config.php');

$res = $db->query('select version();');

foreach ($res as $row) {
    var_dump($res->fetch());
}
