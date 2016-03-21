<?php
/**
 * 配置文件类
*/
namespace Service\Config;

use ArrayAccess;

class Config implements ArrayAccess
{

    /**
     * 配置文件的绝对路径
     */
    protected $path;
    /**
     * 配置项
     */
    protected $configs;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * 判断配置项是否存在时的操作
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->configs[$offset]);
    }

    /**
     * 读取配置项的操作
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        if(empty($this->configs[$offset])) {
            $this->configs = require $this->path;
        }

        return $this->configs;
    }

    /**
     * 设置配置项的操作
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->configs[$offset] = $value;
    }

    /**
     * 删除配置项的操作
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->configs[$offset]);
    }
}