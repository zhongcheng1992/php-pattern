<?php
namespace Service\Traits;

use \Exception;

trait Singleton
{
    protected static $_instance = null;

    protected function __construct() {}

    public function __clone()
    {
        throw new Exception("Cloning " . __CLASS__ . ' is not allowed!');
    }

    final public static function getInstance()
    {
        if(self::$_instance == null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
}