<?php
/**
 * DigitalAnalysis.php :
 *
 * PHP version 7.1
 *
 * @category DigitalAnalysis
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;

/**
 * DigitalAnalysis : 数字分析法
 *
 * @category DigitalAnalysis
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class DigitalAnalysis extends Hash
{
    /**
     * @var DigitalAnalysis
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
     * @return DigitalAnalysis
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DigitalAnalysis();
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

        $key_digit = strlen($table_length);
        if ($key_digit > $digit) {
            $key = substr($key, (int)(($digit + $key_digit) / 2) - $key_digit, $key_digit);
        }
        return $key % $table_length;
    }
}
