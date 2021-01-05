<?php
/**
 * HashInterface.php :
 *
 * PHP version 7.1
 *
 * @category AbstructHash
 * @package  DataStructure\SearchTable\DynamicSearchTable\AbstractHashTable\Hash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;

/**
 * HashInterface : 哈希方法策略
 *
 * @category HashInterface
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
interface HashInterface
{
    /**
     * hash函数
     *
     * @param AbstractHashTable $hashTable
     * @param mixed             $key
     *
     * @return int 位置
     */
    public function handle(AbstractHashTable $hashTable, $key);
}
