<?php
/**
 * 策略模式
 * 资源检索策略类
 */
namespace Service\Pattern;

interface IStrategy
{
    public function search($name);
}