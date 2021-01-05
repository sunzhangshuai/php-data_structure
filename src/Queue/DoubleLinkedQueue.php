<?php
/**
 * DoubleLinkedQueue.php :
 *
 * PHP version 7.1
 *
 * @category DoubleLinkedQueue
 * @package  DataStructure\QueueInterface
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Queue;


use DataStructure\Queue\Model\QueueNode;
use Closure;
use Exception;

/**
 * DoubleLinkedQueue : 双向队列
 * i = 0：尾进头出
 * i = 1：头进尾出
 *
 * @category DoubleLinkedQueue
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class DoubleLinkedQueue implements DoubleQueueInterface
{
    /**
     * @var QueueNode | null
     */
    public $front;

    /**
     * @var QueueNode | null
     */
    public $rear;

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->front = $this->rear = null;
    }

    /**
     * @inheritDoc
     */
    public function clearQueue()
    {
        $this->front = $this->rear = null;
    }

    /**
     * @inheritDoc
     */
    public function queueEmpty()
    {
        return $this->front === null;
    }

    /**
     * @inheritDoc
     */
    public function queueLength()
    {
        $result = 0;
        $visit  = function ($node) use (&$result) {
            $result++;
        };
        $this->queueTraverse($visit, 0);
        return $result;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getHead($i)
    {
        if ($this->front === null) {
            throw new Exception('没有头结点');
        }
        return $i === 0 ? $this->front->data : $this->rear->data;
    }

    /**
     * @inheritDoc
     */
    public function enQueue($elem, $i)
    {
        $node = new QueueNode($elem);
        if ($this->queueEmpty()) {
            $this->front = $this->rear = $node;
            return;
        }
        if ($i === 0) {
            $node->prev       = $this->rear;
            $this->rear->next = $node;
            $this->rear       = $node;
        } else {
            $node->next        = $this->front;
            $this->front->prev = $node;
            $this->front       = $node;
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deQueue($i)
    {
        if ($this->queueEmpty()) {
            throw new Exception('空队列无法出队');
        }

        if ($this->front === $this->rear) {
            $result      = $this->front->data;
            $this->front = $this->rear = null;
            return $result;
        }
        if ($i === 0) {
            $result            = $this->front->data;
            $this->front       = $this->front->next;
            $this->front->prev = null;
        } else {
            $result           = $this->rear->data;
            $this->rear       = $this->rear->prev;
            $this->rear->next = null;
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function queueTraverse(Closure $visit, $i)
    {
        if ($i === 0) {
            $node = $this->front;
            while ($node) {
                $visit($node->data);
                $node = $node->next;
            }
        } else {
            $node = $this->rear;
            while ($node) {
                $visit($node->data);
                $node = $node->prev;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray($i)
    {
        $result = [];
        $visit = function ($elem) use (&$result) {
            $result[] = $elem;
        };
        $this->queueTraverse($visit, $i);
        return $result;
    }
}
