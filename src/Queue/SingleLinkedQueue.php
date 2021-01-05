<?php
/**
 * SingleLinkedQueue.php :
 *
 * PHP version 7.1
 *
 * @category SingleLinkedQueue
 * @package  DataStructure\QueueInterface
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Queue;


use DataStructure\Queue\Interfaces\QueueInterface;
use DataStructure\Queue\Model\QueueNode;
use Closure;
use Exception;

class SingleLinkedQueue implements QueueInterface
{
    /**
     * @var QueueNode 队头
     */
    protected $front;

    /**
     * @var QueueNode 队尾
     */
    protected $rear;

    /**
     * 初始化
     * SingleLinkedQueue constructor.
     */
    public function __construct()
    {
        $this->rear = $this->front = null;
    }

    /**
     * @inheritDoc
     */
    public function clearQueue()
    {
        $this->rear = $this->front = null;
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
        $visit = function ($node) use (&$result) {
            $result++;
        };
        $this->queueTraverse($visit);
        return $result;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getHead()
    {
        if ($this->queueEmpty()) {
            throw new Exception('没有头结点');
        }
        return $this->front->data;
    }

    /**
     * @inheritDoc
     */
    public function enQueue($elem)
    {
        $node = new QueueNode($elem);
        if ($this->queueEmpty()) {
            $this->front = $this->rear = $node;
            return;
        }
        $this->rear->next = $node;
        $this->rear = $node;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deQueue()
    {
        if ($this->queueEmpty()) {
            throw new Exception('空队列无法出队');
        }
        $result = $this->front->data;
        if ($this->front === $this->rear) {
            $this->front = $this->rear = null;
        } else {
            $this->front = $this->front->next;
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function queueTraverse(Closure $visit)
    {
        $node = $this->front;
        while ($node) {
            $visit($node->data);
            $node = $node->next;
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $result = [];
        $visit = function ($elem) use (&$result) {
            $result[] = $elem;
        };
        $this->queueTraverse($visit);
        return $result;
    }
}
