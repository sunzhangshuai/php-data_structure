<?php
/**
 * StaticSearchTableInterface.php :
 *
 * PHP version 7.1
 *
 * @category StaticSearchTableInterface
 * @package  DataStructure\SearchTable\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\Interfaces;

use DataStructure\SearchTable\Model\Element;
use Closure;

/**
 * 静态查询表
 *
 * Interface StaticSearchTableInterface
 *
 * @package DataStructure\SearchTable\Interfaces
 */
interface StaticSearchTableInterface
{
    /**
     * 初始化
     * StaticSearchTableInterface constructor.
     *
     * @param Element[] $elements
     */
    public function __construct($elements);

    /**
     * 根据关键字key查找
     *
     * @param string $key
     *
     * @return Element
     */
    public function search($key);

    /**
     * 遍历
     *
     * @param Closure $visit
     */
    public function traverse(Closure $visit);
}
