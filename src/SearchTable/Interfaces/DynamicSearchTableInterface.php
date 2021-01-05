<?php
/**
 * DynamicSearchTableInterface.php :
 *
 * PHP version 7.1
 *
 * @category DynamicSearchTableInterface
 * @package  DataStructure\SearchTable\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\Interfaces;

use DataStructure\SearchTable\Model\Element;
use DataStructure\SearchTable\Model\SkipNode;
use Closure;

/**
 * 动态查找表
 *
 * Interface DynamicSearchTableInterface
 *
 * @package DataStructure\SearchTable\Interfaces
 */
interface DynamicSearchTableInterface
{
    /**
     * 根据关键字key查找
     *
     * @param SkipNode|string $key
     *
     * @return Element
     */
    public function search($key);

    /**
     * 插入
     *
     * @param Element $element
     *
     * @return boolean
     */
    public function insert($element);

    /**
     * 删除
     *
     * @param string|int $key
     *
     * @return boolean
     */
    public function delete($key);

    /**
     * 遍历
     *
     * @param Closure $visit
     */
    public function traverse(Closure $visit);
}
