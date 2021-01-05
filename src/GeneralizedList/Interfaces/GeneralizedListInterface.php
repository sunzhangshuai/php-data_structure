<?php
/**
 * GeneralizedListInterface.php :
 *
 * PHP version 7.1
 *
 * @category GeneralizedListInterface
 * @package  ${NAMESPACE}
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\GeneralizedList\Interfaces;

use Closure;

interface GeneralizedListInterface
{
    /**
     * 初始化
     * GeneralizedListInterface constructor.
     *
     * @param string $string
     */
    public function __construct(string $string = '');

    /**
     * 克隆方法
     *
     * @return GeneralizedListInterface
     */
    public function __clone();

    /**
     * 获取广义表的长度
     *
     * @return int 长度
     */
    public function gListLength();

    /**
     * 获取广义表的深度
     *
     * @return int 深度
     */
    public function gListDepth();

    /**
     * 判断广义表是否存在
     *
     * @return boolean
     */
    public function gListEmpty();

    /**
     * 获取表头
     *
     * @return GeneralizedListInterface
     */
    public function getHead();

    /**
     * 获取表尾
     *
     * @return GeneralizedListInterface
     */
    public function getTail();

    /**
     * 插入e元素作为广义表的第一个元素
     *
     * @param $e
     */
    public function insertFirst($e);

    /**
     * 删除广义表的第一个元素，并返回
     *
     * @return mixed
     */
    public function deleteFirst();

    /**
     * 遍历广义表
     *
     * @param Closure $visit
     */
    public function traverse(Closure $visit);

    /**
     * 格式化成string类型
     *
     * @return string
     */
    public function __toString();
}
