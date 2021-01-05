<?php
/**
 * DoubleSequenceStack.php :
 *
 * PHP version 7.1
 *
 * @category DoubleSequenceStack
 * @package  DataStructure\Stack
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Stack;

use DataStructure\Stack\Interfaces\DoubleStackInterface;
use Closure;
use Exception;

/**
 * DoubleSequenceStack : 双向顺序栈
 * 顺序表中有两个栈，栈底分别为基址(i=0)和最大值(i=1)
 *
 * @category DoubleSequenceStack
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class DoubleSequenceStack implements DoubleStackInterface
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
     * @var int[] 栈底
     */
    protected $base;

    /**
     * @var int[] 栈顶
     */
    protected $top;

    /**
     * @var array 栈内元素
     */
    protected $elem;

    /**
     * @var int[] 栈的空间
     */
    protected $stack_size;

    /**
     * 初始化
     * SequenceStack constructor.
     */
    public function __construct()
    {
        $this->base       = [0, self::STACK_INIT_SIZE - 1];
        $this->top        = [0, self::STACK_INIT_SIZE - 1];
        $this->stack_size = [self::STACK_INIT_SIZE, self::STACK_INIT_SIZE];
        $this->elem       = [];
    }

    /**
     * @inheritDoc
     */
    public function clearStack($i)
    {
        while ($this->stackLength($i)) {
            $this->pop($i);
        }
    }

    /**
     * @inheritDoc
     */
    public function stackEmpty($i)
    {
        return $this->stackLength($i) === 0;
    }

    /**
     * @inheritDoc
     */
    public function stackLength($i)
    {
        return abs($this->top[$i] - $this->base[$i]);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getTop($i)
    {
        if ($this->stackEmpty($i)) {
            throw new Exception('栈是空的');
        }
        return $this->elem[$this->top[$i - 1]];
    }

    /**
     * @inheritDoc
     */
    public function push($elem, $i)
    {
        if ($this->stackLength($i) === $this->stack_size[$i]) {
            // todo 扩容
            return;
        }
        $this->elem[$this->top[$i]] = $elem;
        $i                          = 0 ? $this->top[$i]++ : $this->top[$i]--;
        $other_index                = ($i == 0 ? 1 : 0);
        $this->stack_size[$other_index]--;
    }

    /**
     * @inheritDoc
     */
    public function pop($i)
    {
        $i                          = 0 ? $this->top[$i]++ : $this->top[$i]--;
        $other_index                = ($i == 0 ? 1 : 0);
        $this->stack_size[$other_index]++;
        return $this->elem[$this->top[$i]];
    }

    /**
     * @inheritDoc
     */
    public function stackTraverse(Closure $visit, $i)
    {
        if ($i == 0) {
            for ($index = $this->base[$i]; $index < $this->top[$i]; $index++) {
                $visit($this->elem[$index]);
            }
        } else {
            for ($index = $this->base[$i]; $index > $this->top[$i]; $index--) {
                $visit($this->elem[$index]);
            }
        }
    }
}
