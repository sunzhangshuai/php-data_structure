<?php
/**
 * StackInterface.php :
 *
 * PHP version 7.1
 *
 * @category StackInterface
 * @package  DataStructure\StackInterface
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Stack\Interfaces;


use Closure;

interface StackInterface
{
    /**
     * 清空栈
     *
     */
    public function clearStack();

    /**
     * 栈是否为空
     *
     *
     * @return boolean
     */
    public function stackEmpty();

    /**
     * 栈长
     *
     *
     * @return mixed
     */
    public function stackLength();

    /**
     * 获取栈顶元素
     *
     *
     * @return mixed
     */
    public function getTop();

    /**
     * 入栈
     *
     * @param     $elem
     */
    public function push($elem);

    /**
     * 出栈
     *
     *
     * @return mixed
     */
    public function pop();

    /**
     * 遍历栈
     *
     * @param Closure $visit 访问函数
     *
     * @return mixed
     */
    public function stackTraverse(Closure $visit);
}
