<?php
namespace Imooc;

class object
{
    protected $array = [];


    public function __get($key)
    {
        var_dump(__METHOD__);
        return $this->array[$key];
    }

    public function __set($key, $value)
    {
        var_dump(__METHOD__);
        $this->array[$key] = $value;
    }

    public function __call($func, $param)
    {
        var_dump(__METHOD__);
        var_dump($param);
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
        var_dump(__METHOD__);
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return __CLASS__;
    }

    public function __invoke($param)
    {
        // TODO: Implement __invoke() method.
        var_dump(__METHOD__);
        var_dump($param);
    }
}