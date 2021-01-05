<?php
/**
 * LinkedListNode.php :
 *
 * PHP version 7.1
 *
 * @category LinkedListNode
 * @package  DataStructure\Listss\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists\Model;


class LinkedListNode
{
    /**
     * @var mixed 数据域
     */
    public $data;

    /**
     * @var LinkedListNode 前驱指针
     */
    public $prev;

    /**
     * @var LinkedListNode 后继指针
     */
    public $next;

    /**
     * SingleLinkedListNode constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * 深拷贝
     */
    public function __clone()
    {
        $this->data = clone $this->data;
        if ($this->prev) {
            $this->prev = clone $this->prev;
        }
        if ($this->next) {
            $this->next = clone $this->next;
        }
    }
}
