<?php
/**
 * LinkedListInterface.php :
 *
 * PHP version 7.1
 *
 * @category LinkedListInterface
 * @package  DataStructure\Listss\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists\Interfaces;


use DataStructure\Lists\Model\LinkedListNode;
use Closure;

interface LinkedListInterface
{
    /**
     * 初始化
     * LinkedListInterface constructor.
     */
    public function __construct();

    /**
     * 将链表重置为空表
     *
     * @return mixed
     */
    public function clearList();

    /**
     * 链表头插
     *
     * @param LinkedListNode $node
     *
     * @return mixed
     */
    public function insFirst(LinkedListNode $node);

    /**
     * 删除链表的第一个节点并返回
     *
     * @return LinkedListNode
     */
    public function delFirst();

    /**
     * 链表尾插
     *
     * @param LinkedListNode $node
     *
     * @return mixed
     */
    public function append(LinkedListNode $node);

    /**
     * 删除链表的尾节点
     *
     * @return LinkedListNode
     */
    public function remove();

    /**
     * 将new_node节点插到node节点之前
     *
     * @param LinkedListNode $node
     * @param LinkedListNode $new_node
     */
    public function insBefore(LinkedListNode $node, LinkedListNode $new_node);

    /**
     * 将new_node节点插到node节点之后
     *
     * @param LinkedListNode $node
     * @param LinkedListNode $new_node
     */
    public function insAfter(LinkedListNode $node, LinkedListNode $new_node);

    /**
     * 更新node节点的值域
     *
     * @param LinkedListNode $node
     * @param                $data
     */
    public function setCurElem(LinkedListNode $node, $data);

    /**
     * 获取node节点的值域
     *
     * @param LinkedListNode $node
     *
     * @return mixed
     */
    public function getCurElem(LinkedListNode $node);

    /**
     * 判断链表是否为空
     *
     * @return boolean
     */
    public function listEmpty();

    /**
     * 获取链表长度
     *
     * @return int
     */
    public function listLength();

    /**
     * 获取链表头节点
     *
     * @return LinkedListNode
     */
    public function getHead();

    /**
     * 获取链表尾节点
     *
     * @return LinkedListNode
     */
    public function getLast();

    /**
     * 获取node节点的直接前驱，无前驱，返回null
     *
     * @param LinkedListNode $node
     *
     * @return LinkedListNode
     */
    public function priorPos(LinkedListNode $node);

    /**
     * 获取node节点的直接后继，无后继，返回null
     *
     * @param LinkedListNode $node
     *
     * @return LinkedListNode
     */
    public function nextPos(LinkedListNode $node);

    /**
     * 获取第index个节点
     *
     * @param $index
     *
     * @return LinkedListNode
     */
    public function locatePos($index);

    /**
     * 返回第一个与elem满足compare关系的数据元素的位序
     *
     * @param         $elem
     * @param Closure $compare
     *
     * @return LinkedListNode
     */
    public function locateElem($elem, Closure $compare);

    /**
     * 遍历数序表
     *
     * @param Closure $visit
     *
     * @return array
     */
    public function listTraverse(Closure $visit);
}
