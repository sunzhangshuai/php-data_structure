<?php
/**
 * DoubleLinkedList.php :
 *
 * PHP version 7.1
 *
 * @category DoubleLinkedList
 * @package  DataStructure\Listss
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists;


use DataStructure\Lists\Interfaces\LinkedListInterface;
use DataStructure\Lists\Model\LinkedListNode;
use Closure;
use Exception;

class DoubleLinkedList implements LinkedListInterface
{
    /**
     * @var LinkedListNode|null 头结点
     */
    protected $head;

    /**
     * @var LinkedListNode|null 尾节点
     */
    protected $tail;

    /**
     * @var int 单链表长度
     */
    protected $length;

    /**
     * SingleLinkedListExtend constructor.
     */
    public function __construct()
    {
        $this->head   = null;
        $this->length = 0;
    }

    /**
     * @inheritDoc
     */
    public function clearList()
    {
        $node = $this->head;
        while ($node) {
            $next       = $node->next;
            $node->data = null;
            $node->next = null;
            $node->prev  = null;
            $node       = $next;
        }
        $this->head   = null;
        $this->length = 0;
    }

    /**
     * @inheritDoc
     */
    public function insFirst(LinkedListNode $node)
    {
        $node->prev = null;
        $node->next = $this->head;
        if ($this->head) {
            $this->head->prev = $node;
        }
        $this->length++;
        $this->head = $node;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function delFirst()
    {
        if (!$this->listEmpty()) {
            throw new Exception('链表中没有元素');
        }
        $node = $this->head;
        if ($this->listLength() === 1) {
            $this->head = $this->tail = null;
        } else {
            $this->head       = $this->head->next;
            $this->head->prev = null;
        }
        $this->length--;
        return $node;
    }

    /**
     * @inheritDoc
     */
    public function append(LinkedListNode $node)
    {
        if (!$this->getHead()) {
            $this->head = $node;
        } else {
            $this->tail->next = $node;
        }
        $node->prev  = $this->tail;
        $node_length = 1;
        while ($node->next) {
            $node_length++;
            $node = $node->next;
        }
        $this->length += $node_length;
        $this->tail   = $node;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function remove()
    {
        if (!$this->listEmpty()) {
            throw new Exception('链表中没有元素');
        }
        $result = $this->tail;
        if ($this->listLength() === 1) {

            $this->head = $this->tail = null;
        } else {
            $this->tail       = $this->tail->prev;
            $this->tail->next = null;
        }
        $this->length--;
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function insBefore(LinkedListNode $node, LinkedListNode $new_node)
    {
        if ($node === $this->getHead()) {
            $this->insFirst($new_node);
            return;
        }
        $new_node->prev   = $node->prev;
        $new_node->next   = $node;
        $node->prev->next = $new_node;
        $node->prev       = $new_node;
    }

    /**
     * @inheritDoc
     */
    public function insAfter(LinkedListNode $node, LinkedListNode $new_node)
    {
        if ($node === $this->getLast()) {
            $this->append($new_node);
            return;
        }
        $node->next->prev = $new_node;
        $new_node->next   = $node->next;
        $new_node->prev   = $node;
        $node->next       = $new_node;
    }

    /**
     * @inheritDoc
     */
    public function setCurElem(LinkedListNode $node, $data)
    {
        $node->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function getCurElem(LinkedListNode $node)
    {
        return $node->data;
    }

    /**
     * @inheritDoc
     */
    public function listEmpty()
    {
        return $this->length === 0;
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
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @inheritDoc
     */
    public function getLast()
    {
        return $this->tail;
    }

    /**
     * @inheritDoc
     */
    public function priorPos(LinkedListNode $node)
    {
        return $node->prev;
    }

    /**
     * @inheritDoc
     */
    public function nextPos(LinkedListNode $node)
    {
        return $node->next;
    }

    /**
     * @inheritDoc
     */
    public function locatePos($index)
    {
        // 分情况，区分从前遍历或从后遍历
    }

    /**
     * @inheritDoc
     */
    public function locateElem($elem, Closure $compare)
    {
        $node  = $this->head;
        $index = 1;
        while ($node) {
            if ($compare($elem, $node->data)) {
                return $index;
            }
            $index++;
            $node = $node->next;
        }
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function listTraverse(Closure $visit)
    {
        $node = $this->head;
        while ($node) {
            $visit($node->data);
            $node = $node->next;
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $node   = $this->head;
        $result = [];
        while ($node) {
            $result[] = $node->data;
            $node     = $node->next;
        }
        return $result;
    }
}
