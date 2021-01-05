<?php
/**
 * DoubleLinkedStack.php :
 *
 * PHP version 7.1
 *
 * @category DoubleLinkedStack
 * @package  DataStructure\Stack
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Stack;

use DataStructure\Stack\Interfaces\DoubleStackInterface;
use Closure;
use Exception;
use StackNode;

/**
 * DoubleLinkedStack : 双向链式栈
 * i=0：从左边进栈
 * i=1：从右边进栈
 *
 * @category DoubleLinkedStack
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class DoubleLinkedStack implements DoubleStackInterface
{
    /**
     * @var StackNode 栈底
     */
    protected $tail;

    /**
     * @var StackNode[] 栈顶
     */
    protected $head;

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $node       = new StackNode(null);
        $this->tail = $node;
        $this->head = [$node, $node];
    }

    /**
     * @inheritDoc
     */
    public function clearStack($i = 0)
    {
        $this->head             = [$this->tail, $this->tail];
        $this->tail->next = null;
        $this->tail->prev = null;
    }

    /**
     * @inheritDoc
     */
    public function stackEmpty($i = 0)
    {
        return $this->head[$i] === $this->tail;
    }

    /**
     * @inheritDoc
     */
    public function stackLength($i = 0)
    {
        $result = 0;
        $visit  = function ($node) use (&$result) {
            $result++;
        };
        $this->stackTraverse($visit, 0);
        return $result;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getTop($i = 0)
    {
        if ($this->stackEmpty($i)) {
            throw new Exception('栈是空的');
        }
        return $this->head[$i]->data;
    }

    /**
     * @inheritDoc
     */
    public function push($elem, $i = 0)
    {
        $node = new StackNode($elem);
        if ($i === 0) {
            $node->next          = $this->head[0];
            $this->head[0]->prev = $elem;
            $this->head[0]       = $node;
        } else {
            $node->prev          = $this->head[1];
            $this->head[1]->next = $elem;
            $this->head[1]       = $node;
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function pop($i = 0)
    {
        if ($this->stackEmpty($i)) {
            throw new Exception('空栈无法出栈');
        }
        $node = $this->head[$i];
        if ($i === 0) {
            $this->head[0]       = $this->head[0]->next;
            $this->head[0]->prev = null;
        } else {
            $this->head[1]       = $this->head[1]->prev;
            $this->head[1]->next = null;
            $this->head[1]       = $node;
        }
        return $node->data;
    }

    /**
     * @inheritDoc
     */
    public function stackTraverse(Closure $visit, $i = 0)
    {
        $node = $this->head[$i];
        if ($i === 0) {
            while ($node !== $this->tail) {
                $visit($node->data);
                $node = $node->next;
            }
        } else {
            while ($node !== $this->tail) {
                $visit($node->data);
                $node = $node->prev;
            }
        }
    }
}
