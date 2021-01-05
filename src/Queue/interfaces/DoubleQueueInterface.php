<?php
/**
 * DoubleQueueInterface.php :
 *
 * PHP version 7.1
 *
 * @category DoubleQueueInterface
 * @package  DataStructure\QueueInterface
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Queue;

use DataStructure\Queue\Model\QueueNode;
use Closure;

/**
 * i = 0/1 分别代表不同的队列
 * Interface DoubleQueueInterface
 *
 * @package DataStructure\Queue
 */
interface DoubleQueueInterface
{
    /**
     * 队列初始化
     * QueueInterface constructor.
     */
    public function __construct();

    /**
     * 清空队列
     */
    public function clearQueue();

    /**
     * 队是否为空
     *
     * @return boolean
     */
    public function queueEmpty();

    /**
     * 队列的长度
     *
     * @return int
     */
    public function queueLength();

    /**
     * 获取队头
     *
     * @param $i int 队的标号
     *
     * @return mixed
     */
    public function getHead($i);

    /**
     * 入队
     *
     * @param $elem
     * @param $i int 队的标号
     */
    public function enQueue($elem, $i);

    /**
     * 出队
     *
     * @param $i int 队的标号
     *
     * @return mixed
     */
    public function deQueue($i);

    /**
     * 队列遍历
     *
     * @param Closure $visit
     *
     * @param         $i int 队的标号
     *
     * @return mixed
     */
    public function queueTraverse(Closure $visit, $i);

    /**
     * 变成数组输出
     *
     * @param $i int 队的标号
     *
     * @return array
     */
    public function toArray($i);
}
