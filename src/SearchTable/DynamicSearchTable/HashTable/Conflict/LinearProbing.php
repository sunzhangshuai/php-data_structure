<?php
/**
 * LinearProbing.php :
 *
 * PHP version 7.1
 *
 * @category LinearProbing
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict;


use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;
use DataStructure\SearchTable\Model\Element;

/**
 * LinearProbing :
 *
 * @category LinearProbing
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class LinearProbing extends Probing
{
    /**
     * @inheritDoc
     */
    function getNextIndex($index, $conflict_count, $hashTable, $key)
    {
        return ($index + $conflict_count) % $hashTable->getTableLength();
    }
}
