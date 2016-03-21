<?php
namespace Service\Iterator;

use Iterator;
use Service\Pattern\Factory;

class AllUser implements Iterator
{
    protected $ids;
    protected $data = [];
    protected $index;

    public function __construct()
    {
        $user = Factory::createDb('root', 'fyibmsd', 'test', 'localhost', 'pdo');
        $result = $user->query('select id from user');
        $this->ids = $result->fetch_all();
    }

    /**
     * 返回当前的元素
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        // TODO: Implement current() method.
        $id = $this->ids[$this->index]['id'];
        return Factory::getUser($id);
    }

    /**
     * 移动到下一个元素
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        // TODO: Implement next() method.
        $this->index++;
    }

    /**
     * 返回当前元素的键值
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        // TODO: Implement key() method.
        return $this->index;
    }

    /**
     * 验证是否有下一个元素
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        // TODO: Implement valid() method.
        return $this->index < count($this->ids);
    }

    /**
     * 重置到开始元素
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
        $this->index = 0;
    }
}