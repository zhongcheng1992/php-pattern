<?php
/**
 * 使用yaml作为配置文件 配置类
*/
namespace Service\Config;

use ArrayAccess;

class Yaml implements ArrayAccess
{
    protected $path;
    protected $configs;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Whether a offset exists
     */
    public function offsetExists($offset)
    {
        return isset($this->configs[$offset]);
    }

    /**
     * Offset to retrieve
     */
    public function offsetGet($offset)
    {
        if(empty($this->configs[$offset])) {
            $this->configs = yaml_parse_file($this->path);
        }
        return $this->configs;
    }

    /**
     * Offset to set
     */
    public function offsetSet($offset, $value)
    {
        $this->configs[$offset] = $value;
        yaml_emit_file($this->path, $this->configs);
    }

    /**
     * Offset to unset
     */
    public function offsetUnset($offset)
    {
        unset($this->configs[$offset]);
        yaml_emit_file($this->path, $this->configs);
    }
}
