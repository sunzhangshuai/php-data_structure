<?php
/**
 * SequenceListInterface.php :
 *
 * PHP version 7.1
 *
 * @category SequenceListInterface
 * @package  DataStructure\Listss
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists\Interfaces;


use Closure;
use Exception;

interface SequenceListInterface
{
    /**
     * 初始化顺序链
     * SequenceListInterface constructor.
     */
    public function __construct();

    /**
     * 清空线性表
     */
    public function clearList();

    /**
     * 若线性表为空，返回true，否则返回false
     *
     * @return bool
     */
    public function listEmpty();

    /**
     * 返回表中数据元素的个数
     *
     * @return int
     */
    public function listLength();

    /**
     * 返回表中第i个元素的值
     *
     * @param $index
     *
     * @return mixed
     * @throws Exception
     */
    public function getElem($index);

    /**
     * 返回第一个与elem满足compare关系的数据元素的位序
     *
     * @param         $elem
     * @param Closure $compare
     *
     * @return int
     */
    public function locateElem($elem, Closure $compare);

    /**
     * 找到elem的前驱元素
     *
     * @param $elem
     *
     * @return mixed
     * @throws Exception
     */
    public function priorElem($elem);

    /**
     * 找到elem的后继元素
     *
     * @param $elem
     *
     * @return mixed
     * @throws Exception
     */
    public function nextElem($elem);

    /**
     * 在第index个位置插入元素
     *
     * @param $index
     * @param $elem
     *
     * @throws Exception
     */
    public function listInsert($index, $elem);

    /**
     * 删除第index个位置的元素
     * @param $index
     *
     * @return mixed
     * @throws Exception
     */
    public function listDelete($index);

    /**
     * 遍历数序表
     *
     * @param Closure $visit
     *
     * @return array
     */
    public function listTraverse(Closure $visit);

    /**
     * @return array
     */
    public function toArray();
}
