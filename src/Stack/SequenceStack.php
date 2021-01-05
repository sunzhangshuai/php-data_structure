<?php
/**
 * SequenceStack.php :
 *
 * PHP version 7.1
 *
 * @category SequenceStack
 * @package  ${NAMESPACE}
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Stack;

use DataStructure\Stack\Interfaces\StackInterface;
use Closure;
use Exception;

class SequenceStack implements StackInterface
{
    /**
     * 初始分配量
     */
    const STACK_INIT_SIZE = 100;

    /**
     * 增量
     */
    const STACK_INCREMENT = 10;

    /**
     * @var int 栈底
     */
    protected $base;

    /**
     * @var int 栈顶
     */
    protected $top;

    /**
     * @var array 栈内元素
     */
    protected $elem;

    /**
     * @var int 栈的空间
     */
    protected $stack_size;

    /**
     * 初始化
     * SequenceStack constructor.
     */
    public function __construct()
    {
        $this->base       = $this->top = 0;
        $this->stack_size = self::STACK_INIT_SIZE;
        $this->elem       = [];
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function clearStack($i = 0)
    {
        while ($this->stackLength()) {
            $this->pop();
        }
        $this->elem = [];
    }

    /**
     * @inheritDoc
     */
    public function stackEmpty($i = 0)
    {
        return $this->stackLength() === 0;
    }

    /**
     * @inheritDoc
     */
    public function stackLength($i = 0)
    {
        return $this->top - $this->base;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getTop($i = 0)
    {
        if ($this->stackEmpty()) {
            throw new Exception('栈是空的');
        }
        return $this->elem[$this->top - 1];
    }

    /**
     * @inheritDoc
     */
    public function push($elem, $i = 0)
    {
        // 扩容
        if ($this->stackLength() === $this->stack_size) {
            $this->expand($this->stack_size + self::STACK_INCREMENT);
        }
        $this->elem[$this->top] = $elem;
        $this->top++;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function pop($i = 0)
    {
        if ($this->stackEmpty()) {
            throw new Exception('栈是空的');
        }
        $this->top--;
        return $this->elem[$this->top];
    }

    /**
     * @inheritDoc
     */
    public function stackTraverse(Closure $visit, $i = 0)
    {
        for ($i = $this->base; $i < $this->top; $i++) {
            $visit($this->elem[$i]);
        }
    }

    /**
     * 扩容
     *
     * @param $length
     */
    public function expand($length)
    {
        // 判断顺序表是否已满，如果满了需要扩容
        if ($this->stackLength() < $length) {
            $new_length       = $this->stack_size + self::STACK_INCREMENT;
            $this->stack_size = $length > $new_length ? $length : $new_length;
        }
    }

    /**
     * 输出数组
     *
     * @return array
     */
    public function toArray()
    {
        $result = [];
        $visit  = function ($data) use (&$result) {
            $result[] = $data;
        };
        $this->stackTraverse($visit);
        return $result;
    }
}
