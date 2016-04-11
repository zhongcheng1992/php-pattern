<?php

class Singleton
{
    protected static $_instance = null;

    protected function __construct() {}

    public static function getInstance()
    {
        if(self::$_instance == null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    private function __clone() {}

    private function __wakeup() {}
}
