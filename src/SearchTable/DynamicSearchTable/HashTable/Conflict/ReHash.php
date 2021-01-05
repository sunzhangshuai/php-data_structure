<?php
/**
 * ReHash.php :
 *
 * PHP version 7.1
 *
 * @category ReHash
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict;


use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\DigitalAnalysis;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\DirectAddressing;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\Folding;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\Hash;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\MedianSquare;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\Mod;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\RandomNumber;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;
use DataStructure\SearchTable\Model\Element;

/**
 * ReHash : 再哈希
 *
 * @category ReHash
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class ReHash extends Probing
{
    /**
     * @var Hash[]
     */
    public $hashs = [];

    /**
     * ReHash constructor.
     */
    public function __construct()
    {
        $this->hashs = [
            DigitalAnalysis::getInstance(),
            DirectAddressing::getInstance(),
            Folding::getInstance(),
            MedianSquare::getInstance(),
            Mod::getInstance(),
            RandomNumber::getInstance()
        ];
    }

    /**
     * @param AbstractHashTable $hashTable
     *
     * @return int
     */
    public function getMaxConflictNum($hashTable)
    {
        return count($this->hashs);
    }

    /**
     * @inheritDoc
     */
    public function getNextIndex($index, $conflict_count, $hashTable, $key)
    {
        return $this->hashs[$conflict_count - 1]->handle($hashTable, $key);
    }
}
