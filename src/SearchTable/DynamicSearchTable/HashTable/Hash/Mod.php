<?php
/**
 * Mod.php :
 *
 * PHP version 7.1
 *
 * @category Mod
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTableTest\Hash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;

/**
 * Mod : 除留余数法
 *
 * @category Mod
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class Mod extends Hash implements HashInterface
{
    /**
     * @var Mod
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
     * @return Mod
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Mod();
        }
        return self::$instance;
    }

    /**
     * @inheritDoc
     *
     * @param int $key
     */
    public function handle(AbstractHashTable $hashTable, $key)
    {
        $key = substr($this->hashCode($key), -5);
        $max_prime = $this->getMaxPrime($hashTable->getTableLength());
        return $key % $max_prime;
    }

    /**
     * 获取不大于num的最大质数
     *
     * @param int $num
     *
     * @return mixed
     */
    protected function getMaxPrime($num)
    {
        for ($i = $num; $i > 1; $i--) {
            $status = true;
            for ($j = 2; $j <= floor(sqrt($i)); $j++) {
                if ($i % $j == 0) {
                    $status = false;
                    break;
                }
            }
            if ($status) return $i;
        }
        return 1;
    }
}
