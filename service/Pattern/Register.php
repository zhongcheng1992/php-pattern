<?php
/**
 * 注册树模式 - 注册树类
 */
namespace Service\Pattern;

class Register
{
    protected static $object = [];

    public static function set($alias, $object)
    {
        self::$object[$alias] = $object;
    }

    public static function get($alias)
    {
        return self::$object[$alias];
    }

    public static function _unset($alias)
    {
        unset(self::$object[$alias]);
    }

    public static function show()
    {
        return array_keys(self::$object);
    }

}
