<?php
/**
 * 公共函数类
 */

namespace Service;

class Common
{
    const VERSION = '0.9';

    public static function getUri()
    {

    }

    public static function init()
    {
        spl_autoload_register(['Common', '__autoload']);
    }

    public static function __autoload($className)
    {
        echo $className;
    }
}
