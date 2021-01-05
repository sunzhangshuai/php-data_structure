<?php
/**
 * DynamicSearchTable.php :
 *
 * PHP version 7.1
 *
 * @category DynamicSearchTable
 * @package  DataStructure\SearchTable\DynamicSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable;

use DataStructure\SearchTable\Interfaces\DynamicSearchTableInterface;
use Closure;

/**
 * DynamicSearchTable : 动态查询表
 *
 * @category DynamicSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class DynamicSearchTable implements DynamicSearchTableInterface
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    abstract public function search($key);

    /**
     * @inheritDoc
     */
    abstract public function insert($element);

    /**
     * @inheritDoc
     */
    abstract public function delete($key);

    /**
     * @inheritDoc
     */
    abstract public function traverse(Closure $visit);
}
