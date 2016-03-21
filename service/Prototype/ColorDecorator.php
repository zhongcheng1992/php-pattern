<?php

use Service\Prototype\IDrawDecorator;

class ColorDecorator implements IDrawDecorator
{
    public $color;

    public function __construct($color)
    {
        $this->color = $color;
    }

    public function beforeDraw()
    {
        echo '<div style="color:' . $this->color . '">';
    }

    public function afterDraw()
    {
        echo '</div>';
    }
}