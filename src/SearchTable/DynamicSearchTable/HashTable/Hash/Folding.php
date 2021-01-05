<?php
/**
 * Folding.php :
 *
 * PHP version 7.1
 *
 * @category Folding
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;

/**
 * Folding : 折叠法
 *
 * @category Folding
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class Folding extends Hash
{
    /**
     * @var Folding
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
     * @return Folding
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Folding();
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
        $base         = 1;
        while ($digit > 0) {
            $digit--;
            $base *= 10;
        }
        $numbers = [];
        while ($key > $base) {
            $numbers[] = $key % $base;
            $key       = (int)($key / $base);
        }
        $numbers[] = $key;
        $key       = 0;
        foreach ($numbers as $number) {
            $key += $number;
        }
        return ($key % $base) % $table_length;
    }
}
