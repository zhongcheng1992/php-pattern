<?php

class Tree
{
    const PRE = '|--';

    protected static $flag = 0;
    private $prefix;

    public function listDir($path)
    {
        if(is_dir($path)) {
            $contents = scandir($path);
            foreach ($contents as $item) {
                $subpath = $path . '/' . $item;
                if (is_dir($subpath) && substr($item, 0, 1) != '.') {
                    // 递归
                    echo  $item . PHP_EOL;
                    $this->listDir($subpath);
                } else{
                    echo  $item . PHP_EOL;
                }
            }
        } else {
            echo $path;
        }
    }

    public function setPrefix()
    {

        $this->prefix = '' . self::PRE;
    }

}

$path = '/Users/fyibmsd/code/php/phplib/service/';
$tree = new Tree();

$tree->listDir($path);

