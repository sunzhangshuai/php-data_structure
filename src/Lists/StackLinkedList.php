<?php
/**
 * StackLinkedList.php :
 *
 * PHP version 7.1
 *
 * @category StackLinkedList
 * @package  DataStructure\Lists\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists;


use DataStructure\Lists\Interfaces\SequenceListInterface;
use DataStructure\Lists\Model\StackNode;
use Closure;
use Exception;

class StackLinkedList implements SequenceListInterface
{
    const MAX_SIZE = 1000;

    /**
     * @var StackNode[] 元素
     */
    protected $elem;

    /**
     * @var int 最后一个节点
     */
    protected $tail;

    /**
     * @var int 未使用的
     */
    protected $unused;

    /**
     * @var int 长度
     */
    protected $length;

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->length       = 0;
        $this->elem[0]->cur = 0;
        for ($i = 1; $i < self::MAX_SIZE; $i++) {
            $this->elem[$i]      = new StackNode();
            $this->elem[$i]->cur = $i + 1;
        }

        $this->elem[self::MAX_SIZE]->cur = 0;
        $this->unused                    = 1;
        $this->tail                      = 0;
    }

    /**
     * @inheritDoc
     */
    public function clearList()
    {
        $this->length       = 0;
        $this->elem[0]->cur = 0;
        for ($i = 1; $i < self::MAX_SIZE; $i++) {
            $this->elem[$i]->cur = $i + 1;
        }
        $this->elem[self::MAX_SIZE]->cur = 0;
        $this->unused                    = 1;
        $this->tail                      = 0;
    }

    /**
     * @inheritDoc
     */
    public function listEmpty()
    {
        return $this->listLength() === 0;
    }

    /**
     * @inheritDoc
     */
    public function listLength()
    {
        return $this->length;
    }

    /**
     * @inheritDoc
     */
    public function getElem($pos)
    {
        if ($pos < 1 || $pos > $this->listLength()) {
            throw new Exception('参数有误');
        }
        $index = 0;
        while ($pos) {
            $index = $this->elem[$index]->cur;
            $pos--;
        }
        return $this->elem[$index]->data;
    }

    /**
     * @inheritDoc
     */
    public function locateElem($elem, Closure $compare)
    {
        $index = $this->elem[0]->cur;
        while ($index && !$compare($this->elem[$index]->data, $elem)) {
            $index = $this->elem[$index]->cur;
        }
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function priorElem($elem)
    {
        $index = $this->elem[0]->cur;
        $pre   = 0;
        while ($index && $this->elem[$index]->data != $elem) {
            $pre   = $index;
            $index = $this->elem[$index]->cur;
        }
        if (!$index) throw new Exception('没有找到' . $elem . '节点');
        if (!$pre) throw new Exception($elem . '没有前驱节点');
        return $this->elem[$pre]->data;
    }

    /**
     * @inheritDoc
     */
    public function nextElem($elem)
    {
        $index = $this->elem[0]->cur;
        while ($index && $this->elem[$index]->data != $elem) {
            $index = $this->elem[$index]->cur;
        }
        if (!$index) throw new Exception('没有找到' . $elem . '节点');
        $next = $this->elem[$index]->cur;
        if (!$next) throw new Exception($elem . '没有后继节点');
        return $this->elem[$next]->data;
    }

    /**
     * @inheritDoc
     */
    public function listInsert($pos, $elem)
    {
        if ($pos < 1 || $pos > $this->listLength() + 1) {
            throw new Exception($pos . '的取值有误');
        }
        // 申请空间
        $new_index = $this->malloc();

        // 获取上一个元素
        $index = 0;
        while ($pos > 1) {
            $index = $this->elem[$index]->cur;
            $pos--;
        }

        // 赋值
        $this->elem[$new_index]->cur  = $this->elem[$index]->cur;
        $this->elem[$new_index]->data = $elem;
        $this->elem[$index]->cur      = $new_index;

        if ($this->elem[$new_index]->cur === 0) {
            $this->tail = $new_index;
        }
        $this->length++;
    }

    /**
     * 申请空间
     *
     * @return int
     */
    private function malloc()
    {
        $i = $this->unused;
        if ($i) {
            $this->unused = $this->elem[$i]->cur;
        }
        return $i;
    }

    /**
     * @inheritDoc
     */
    public function listDelete($pos)
    {
        if ($pos < 1 || $pos > $this->listLength()) {
            throw new Exception($pos . '的取值有误');
        }

        // 获取上一个元素
        $index = 0;
        while ($pos > 1) {
            $index = $this->elem[$index]->cur;
            $pos--;
        }

        $free_index = $this->elem[$index]->cur;

        // 赋值
        $this->elem[$index]->cur = $this->elem[$free_index]->cur;

        // 释放元素
        $this->free($free_index);
        $this->length--;
    }

    /**
     * 释放元素
     *
     * @param $index
     */
    private function free($index)
    {
        $this->elem[$index]->cur = $this->unused;
        $this->unused            = $index;
    }

    /**
     * @inheritDoc
     */
    public function listTraverse(Closure $visit)
    {
        $index = $this->elem[0]->cur;
        while ($index) {
            $visit($this->elem[$index]->data);
            $index = $this->elem[$index]->cur;
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $result = [];
        $visit  = function ($elem) use ($result) {
            $result[] = $elem;
        };
        $this->listTraverse($visit);
        return $result;
    }
}
