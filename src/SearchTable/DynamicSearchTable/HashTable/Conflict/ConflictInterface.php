<?php
/**
 * ConflictInterface.php :
 *
 * PHP version 7.1
 *
 * @category ConflictInterface
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTableTest\Conflict
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;
use DataStructure\SearchTable\Model\Element;

/**
 * hash表冲突解决策略
 * Interface ConflictInterface
 *
 * @package DataStructure\SearchTable\DynamicSearchTable\HashTableTest\Conflict
 */
interface ConflictInterface
{
    /**
     * 返回下标
     *
     * @param AbstractHashTable $hashTable
     *
     * @param int               $index
     * @param mixed             $key
     *
     * @return int
     */
    public function search(AbstractHashTable $hashTable, $index, $key);

    /**
     * 插入元素
     *
     * @param AbstractHashTable $hashTable
     * @param int               $index
     * @param Element           $element
     */
    public function insert(AbstractHashTable $hashTable, $index, $element);

    /**
     * 删除元素
     *
     * @param AbstractHashTable $hashTable
     *
     * @param int               $index
     * @param mixed             $key
     *
     * @return bool
     */
    public function delete(AbstractHashTable $hashTable, $index, $key);
}
