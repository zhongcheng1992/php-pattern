<?php

spl_autoload_register([new phplib(), 'autoload']);

class phplib
{
    public $path;

    public function __construct()
    {

        $this->path = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }

    public function autoload($class)
    {
        $filename = $this->path . str_replace('\\', '/', $class) . '.php';
        if(!file_exists($filename))
        {
            trigger_error($class . '类不存在', E_USER_ERROR);
        }

        require $filename;
    }
}
