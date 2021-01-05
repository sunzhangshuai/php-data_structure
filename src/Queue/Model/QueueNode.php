<?php
/**
 * QueueNode.php :
 *
 * PHP version 7.1
 *
 * @category QueueNode
 * @package  DataStructure\QueueInterface\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Queue\Model;


use DataStructure\Lists\Model\LinkedListNode;

class QueueNode extends LinkedListNode
{
    /**
     * @var QueueNode 后继指针
     */
    public $next;

    public $prev;

}
