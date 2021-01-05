<?php
/**
 * Hash.php :
 *
 * PHP version 7.1
 *
 * @category Hash
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;

/**
 * Hash : hash 单例
 *
 * @category Hash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class Hash implements HashInterface
{
    /**
     * @inheritDoc
     */
    abstract public function handle(AbstractHashTable $hashTable, $key);

    /**
     * 初始化key位数字
     *
     * @param $key
     *
     * @return string
     */
    public function hashCode($key)
    {
        if (is_string($key)) {
            return base_convert(md5($key), 16, 10);
        }
        return $key;
    }
}
