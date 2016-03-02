<?php
/**
 * 事件
 * Created by PhpStorm.
 * User: fyibmsd
 * Date: 16/3/1
 * Time: 下午10:07
 */
namespace Service\Event;

class Event extends EventGenerator
{
    public function trigger()
    {
        echo 'Event happened!<br/>';

        $this->notify();
        // 更新逻辑
        // echo 'Update 1';
        // echo 'Update 2';
    }
}

