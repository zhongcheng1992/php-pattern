<?php
/**
 * 事件抽象类
 * Created by PhpStorm.
 * User: fyibmsd
 * Date: 16/3/1
 * Time: 下午10:14
 */
namespace Service\Event;

abstract class EventGenerator
{
    private $observers = [];

    public function addObserver(IObserver $observer) {
        $this->observers[] = $observer;
    }

    /**
     * 逐个通知观察者
    */
    public function notify()
    {
        foreach($this->observers as $observer) {
            $observer->update('执行更新: ');
        }
    }
}