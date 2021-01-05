<?php
/**
 * MedianSquare.php :
 *
 * PHP version 7.1
 *
 * @category MedianSquare
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;

/**
 * MedianSquare : 平法取中法
 *
 * @category MedianSquare
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class MedianSquare extends Hash
{
    /**
     * @var MedianSquare
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
     * @return MedianSquare
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new MedianSquare();
        }
        return self::$instance;
    }

    /**
     * @inheritDoc
     */
    public function handle(AbstractHashTable $hashTable, $key)
    {
        $key          = $this->hashCode($key);
        $table_length = $hashTable->getTableLength();
        $digit        = strlen($table_length);
        $key = substr($key, 0, $digit);

        $key = $key * $key;
        $key_digit = strlen($table_length);
        if ($key_digit > $digit) {
            $key = substr($key, (int)(($digit + $key_digit) / 2) - $key_digit, $key_digit);
        }
        return (int)$key % $table_length;
    }
}
