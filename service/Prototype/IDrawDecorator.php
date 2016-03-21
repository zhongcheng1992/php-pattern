<?php
/**
 * Created by PhpStorm.
 * User: fyibmsd
 * Date: 16/3/1
 * Time: 下午11:37
 */
namespace Service\Prototype;

interface IDrawDecorator
{
    public function beforeDraw();

    public function afterDraw();
}