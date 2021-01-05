<?php
/**
 * QueueInterface.php :
 *
 * PHP version 7.1
 *
 * @category QueueInterface
 * @package  DataStructure\QueueInterface
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Queue\Interfaces;

use Closure;

interface QueueInterface
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
     * @return mixed
     */
    public function getHead();

    /**
     * 入队
     *
     * @param $elem
     */
    public function enQueue($elem);

    /**
     * 出队
     *
     * @return mixed
     */
    public function deQueue();

    /**
     * 队列遍历
     *
     * @param Closure $visit
     *
     * @return mixed
     */
    public function queueTraverse(Closure $visit);

    /**
     * 变成数组输出
     * @return array
     */
    public function toArray();
}
