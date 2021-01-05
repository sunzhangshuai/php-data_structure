<?php
/**
 * RandomNumber.php :
 *
 * PHP version 7.1
 *
 * @category RandomNumber
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;

/**
 * RandomNumber : 随机数法
 *
 * @category RandomNumber
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class RandomNumber extends Hash
{
    /**
     * @var RandomNumber
     */
    private static $instance;

    /**
     * Hash constructor.
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * 单例
     *
     * @return RandomNumber
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new RandomNumber();
        }
        return self::$instance;
    }

    /**
     * @inheritDoc
     */
    public function handle(AbstractHashTable $hashTable, $key)
    {
        return base_convert(md5($key), 16, 10) % $hashTable->hash_size[$hashTable->table_size_index];
    }
}
