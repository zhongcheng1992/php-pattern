<?php
namespace Service\Mvc;

class View
{
    const VIEW_PATH = '/mvc/Templates/';

    public $tplFile;
    
    public $data = [];
    
    public $disable = false;

    public function __construct($view)
    {
        $this->tplFile = $view;
    }

    public static function make($tplName = null)
    {
        if (!$tplName) {
            throw new \InvalidArgumentException('视图文件不能为空!');
        } else {
            $tplPath = self::getTplPath($tplName);
            if (file_exists($tplPath)) {

                return new View($tplPath);
            } else {
                throw new \UnexpectedValueException('视图文件不存在!');
            }
        }
    }

    public static function getTplPath($tplName)
    {
        return BASE_PATH . self::VIEW_PATH . $tplName;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }
    
    public function disable()
    {
        $this->disable = true;
    }
}
