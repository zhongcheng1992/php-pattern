<?php
namespace Service\Mvc;


class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = View::make(self::getCalledAction());
    }

    public static function getCalledAction()
    {
        $class = explode('\\', get_called_class());
        $ctrl = end($class);
        return explode('Controller', $ctrl)[0] . '/index.phtml';
    }
    
    public function __destruct()
    {
        if ($this->view instanceof View && !$this->view->disable) {
            try {
                extract($this->view->data);
                require $this->view->tplFile;
            } catch (\UnexpectedValueException $e) {
                echo $e->getMessage();
            }
        }
    }
}