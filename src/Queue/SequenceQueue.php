<?php
/**
 * SequenceQueue.php :
 *
 * PHP version 7.1
 *
 * @category SequenceQueue
 * @package  DataStructure\QueueInterface
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Queue;


use DataStructure\Queue\Interfaces\QueueInterface;
use Closure;
use Exception;

class SequenceQueue implements QueueInterface
{
    /**
     * 队列空间
     */
    const MAX_QUEUE_SIZE = 100;

    /**
     * @var int 队头元素
     */
    protected $front;

    /**
     * @var int 队尾元素
     */
    protected $rear;

    /**
     * @var array 元素
     */
    protected $elem;

    /**
     * 初始化
     * SequenceQueue constructor.
     */
    public function __construct()
    {
        $this->front = $this->rear = 0;
        $this->elem  = [];
    }

    /**
     * @inheritDoc
     */
    public function clearQueue()
    {
        $this->front = $this->rear = 0;
        $this->elem  = [];
    }

    /**
     * @inheritDoc
     */
    public function queueEmpty()
    {
        return $this->rear === $this->front;
    }

    /**
     * @inheritDoc
     */
    public function queueLength()
    {
        return ($this->rear - $this->front + self::MAX_QUEUE_SIZE) % self::MAX_QUEUE_SIZE;
    }

    /**
     * @inheritDoc
     */
    public function getHead()
    {
        if ($this->queueEmpty()) return null;
        return $this->elem[$this->front];
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function enQueue($elem)
    {
        if ($this->getNextPos($this->rear) === $this->front) {
            throw new Exception('队列已满');
        }
        $this->elem[$this->rear] = $elem;
        $this->rear              = $this->getNextPos($this->rear);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deQueue()
    {
        if ($this->queueEmpty()) {
            throw new Exception('空队无法出队');
        }
        $elem        = $this->elem[$this->front];
        $this->front = $this->getNextPos($this->front);
        return $elem;
    }

    /**
     * @inheritDoc
     */
    public function queueTraverse(Closure $visit)
    {
        $pos = $this->front;
        while ($pos !== $this->rear) {
            $visit($this->elem[$pos]);
            $pos = $this->getNextPos($pos);
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $result = [];
        $visit  = function ($elem) use (&$result) {
            $result[] = $elem;
        };
        $this->queueTraverse($visit);
        return $result;
    }

    /**
     * 获取下一个位置
     *
     * @param $pos
     *
     * @return int
     */
    protected function getNextPos($pos)
    {
        return ($pos + 1) % self::MAX_QUEUE_SIZE;
    }
}
