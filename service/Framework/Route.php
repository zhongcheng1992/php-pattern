<?php
namespace Service\Framework;

use NoahBuscher\Macaw\Macaw;

class Route extends Macaw
{
    public static $desc = [];
    public static $options = [];

    public static function get($route, $desc, $callback)
    {
        self::$desc[$route] = $desc;
        self::$options['defaultNamespace'] = 'Mvc\\Controller\\';

        if (!is_object($callback)) {
            $callback = self::$options['defaultNamespace'] . $callback;
        }

        return parent::get($route, $callback);
    }
    
    public static function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        echo "<h1 style='text-align:center'>" . self::$desc[$uri] . "</h1><hr/>";


        parent::dispatch();
    }

}