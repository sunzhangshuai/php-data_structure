<?php

use DataStructure\Lists\Model\LinkedListNode;

/**
 * StackNode.php :
 *
 * PHP version 7.1
 *
 * @category StackNode
 * @package  ${NAMESPACE}
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

class StackNode extends LinkedListNode
{
    /**
     * @var StackNode 后继节点
     *
     */
    public $next;

    /**
     * @var StackNode 前驱节点
     */
    public $prev;
}
