<?php
/**
 * DoubleStackInterface.php :
 *
 * PHP version 7.1
 *
 * @category DoubleStackInterface
 * @package  DataStructure\Stack\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Stack\Interfaces;


use Closure;

/**
 * i = 0/1 分别代表不同的栈
 * Interface DoubleStackInterface
 *
 * @package DataStructure\Stack\Interfaces
 */
interface DoubleStackInterface
{
    /**
     * 初始化
     * DoubleStackInterface constructor.
     */
    public function __construct();

    /**
     * 清空栈
     *
     * @param int $i 栈的标号
     */
    public function clearStack($i);

    /**
     * 栈是否为空
     *
     * @param int $i 栈的标号
     *
     * @return boolean
     */
    public function stackEmpty($i);

    /**
     * 栈长
     *
     * @param int $i 栈的标号
     *
     * @return mixed
     */
    public function stackLength($i);

    /**
     * 获取栈顶元素
     *
     * @param int $i 栈的标号
     *
     * @return mixed
     */
    public function getTop($i);

    /**
     * 入栈
     *
     * @param     $elem
     * @param int $i 栈的标号
     */
    public function push($elem, $i);

    /**
     * 出栈
     *
     * @param int $i 栈的标号
     *
     * @return mixed
     */
    public function pop($i);

    /**
     * 遍历栈
     *
     * @param Closure $visit 访问函数
     * @param int     $i     栈的标号
     *
     * @return mixed
     */
    public function stackTraverse(Closure $visit, $i);
}
