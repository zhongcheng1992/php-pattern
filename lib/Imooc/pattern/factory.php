<?php
///**
// * 工厂类
// * 利于代码维护
// */
//namespace Imooc\pattern;
//
//use Imooc\database;
//use Imooc\pattern\register;
//
//class factory
//{
//    public static function createDatabase()
//    {
//        $db = database::getInstance();
//        register::set('db1', $db);
//        return $db;
//    }
//}