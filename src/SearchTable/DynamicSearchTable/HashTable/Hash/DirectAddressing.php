<?php
/**
 * DirectAddressing.php :
 *
 * PHP version 7.1
 *
 * @category directAddressing
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;

/**
 * DirectAddressing : 直接定址法
 *
 * @category DirectAddressing
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class DirectAddressing extends Hash
{
    /**
     * @var DirectAddressing
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
     * @return DirectAddressing
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DirectAddressing();
        }
        return self::$instance;
    }

    /**
     * @inheritDoc
     */
    public function handle(AbstractHashTable $hashTable, $key)
    {
        $key = $this->hashCode($key);
        return ($key - $hashTable->base_address) % $hashTable->getTableLength();
    }
}
