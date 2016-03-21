<?php

use Service\Prototype\IDrawDecorator;

class SizeDecorator implements IDrawDecorator
{

    public $size;

    public function __construct($size = '14')
    {
        $this->size = $size;
    }

    public function beforeDraw()
    {
        echo '<div style="font-size:' . $this->size . 'px">';
    }

    public function afterDraw()
    {
        echo '</div>';
    }
}