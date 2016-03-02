<?php
/**
 * 观察者接口
 * Created by PhpStorm.
 * User: fyibmsd
 * Date: 16/3/1
 * Time: 下午10:42
 */
namespace Service\Event;

interface IObserver
{
    public function update($event_info = null);
}