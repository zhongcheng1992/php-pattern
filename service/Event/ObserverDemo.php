<?php
/**
 * 示例观察者
 * Created by PhpStorm.
 * User: fyibmsd
 * Date: 16/3/1
 * Time: 下午10:52
 */
namespace Service\Event;

class ObserverDemo implements IObserver
{
    private $observer_name;

    public function __construct($name)
    {
        $this->observer_name = $name;
    }

    public function update($event_info = null)
    {
        echo $event_info;
        echo $this->observer_name . '<br/>';
    }
}