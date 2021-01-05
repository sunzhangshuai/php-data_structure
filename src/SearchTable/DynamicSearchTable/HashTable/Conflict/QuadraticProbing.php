<?php
/**
 * QuadraticProbing.php :
 *
 * PHP version 7.1
 *
 * @category QuadraticProbing
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict;


use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;
use DataStructure\SearchTable\Model\Element;

/**
 * QuadraticProbing : 二次线性探测
 *
 * @category QuadraticProbing
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class QuadraticProbing extends Probing
{

    /**
     * @inheritDoc
     */
    public function getNextIndex($index, $conflict_count, $hashTable, $key)
    {
        $table_size = $hashTable->getTableLength();
        $base       = $conflict_count % 2 == 0 ? -1 : 1;
        $index      += $base * pow(ceil($conflict_count / 2), 2);
        if ($index < 0) {
            return ($table_size - (abs($index) % $table_size)) % $table_size;
        } else {
            return $index % $table_size;
        }
    }
}
