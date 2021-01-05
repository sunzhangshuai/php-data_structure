<?php
/**
 * RandomProbing.php :
 *
 * PHP version 7.1
 *
 * @category RandomProbing
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;
use DataStructure\SearchTable\Model\Element;
use Exception;

/**
 * RandomProbing : 随机线性探测
 *
 * @category RandomProbing
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class RandomProbing extends Probing
{
    public $random_array = [];

    /**
     * RandomProbing constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        for ($i = 0; $i < 100; $i++) {
            $this->random_array[] = random_int(0, 100);
        }
    }

    /**
     * @param AbstractHashTable $hashTable
     *
     * @return int
     */
    public function getMaxConflictNum($hashTable)
    {
        return min(count($this->random_array), $hashTable->getTableLength());
    }

    /**
     * @inheritDoc
     */
    public function getNextIndex($index, $conflict_count, $hashTable, $key)
    {
        return ($index + $this->random_array[$conflict_count]) % $hashTable->getTableLength();
    }
}
