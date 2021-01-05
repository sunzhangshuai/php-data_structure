<?php
/**
 * SingleLinkedListExtend.php :
 *
 * PHP version 7.1
 *
 * @category SingleLinkedListExtend
 * @package  DataStructure\Listss
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists;

use DataStructure\Lists\Interfaces\LinkedListInterface;
use DataStructure\Lists\Model\LinkedListNode;
use Closure;
use Exception;

class SingleLinkedList implements LinkedListInterface
{
    /**
     * @var LinkedListNode|null 头结点
     */
    public $head;

    /**
     * @var LinkedListNode|null 尾结点
     */
    public $tail;

    /**
     * @var int 单链表长度
     */
    public $length;

    /**
     * SingleLinkedListExtend constructor.
     */
    public function __construct()
    {
        $this->head   = null;
        $this->tail   = null;
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
            $node       = $next;
        }
        $this->head   = null;
        $this->tail   = null;
        $this->length = 0;
    }

    /**
     * @inheritDoc
     */
    public function insFirst(LinkedListNode $node)
    {
        $node->next = $this->head;
        $this->head = $node;
        $this->length++;
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
            $this->head = $this->head->next;
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
        $node   = $this->priorPos($this->tail);
        if (!$node) {
            $this->head = $this->tail = null;
        } else {
            $this->tail       = $node;
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
        $pre = $this->priorPos($node);
        if (!$pre) {
            $this->insFirst($new_node);
            return;
        }
        $pre->next      = $new_node;
        $new_node->next = $node;
        $this->length++;
    }

    /**
     * @inheritDoc
     */
    public function insAfter(LinkedListNode $node, LinkedListNode $new_node)
    {
        $new_node->next = $node->next;
        $node->next     = $new_node;
        $this->length++;
    }

    /**
     * 删除当前节点
     *
     * @param LinkedListNode $node
     *
     * @throws Exception
     */
    public function delCur(LinkedListNode $node)
    {
        $prior_node = $this->priorPos($node);
        if (!$prior_node) {
            $this->delFirst();
        } else {
            $prior_node->next = $node->next;
            if ($this->tail = $node) {
                $this->tail = $prior_node;
            }
        }
        $this->length--;
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
        if ($node === $this->getHead()) return null;
        $index_node = $this->getHead();
        while ($index_node && $index_node->next !== $node) {
            $index_node = $index_node->next;
        }
        return $index_node;
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
     * @throws Exception
     */
    public function locatePos($index)
    {
        if ($this->listLength() < $index || $index < 1) {
            throw new Exception('index无效');
        }
        $node = $this->head;
        for ($i = 1; $i < $index; $i++) {
            $node = $node->next;
        }
        return $node;
    }

    /**
     * @inheritDoc
     */
    public function locateElem($elem, Closure $compare)
    {
        $node  = $this->head;
        while ($node) {
            if ($compare($elem, $node->data)) {
                return $node;
            }
            $node = $node->next;
        }
        return null;
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
