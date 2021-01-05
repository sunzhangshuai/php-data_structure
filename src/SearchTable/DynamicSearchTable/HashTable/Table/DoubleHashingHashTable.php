<?php
/**
 * DoubleHashingHashTable.php :
 *
 * PHP version 7.1
 *
 * @category DoubleHashingHashTable
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Table
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Table;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict\ConflictInterface;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict\ReHash;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\HashInterface;
use Closure;

/**
 * DoubleHashingHashTable : 再hash法
 *
 * @category DoubleHashingHashTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class DoubleHashingHashTable extends AbstractHashTable
{
    /**
     * 初始化
     * DoubleHashingHashTable constructor.
     *
     * @param HashInterface $hash
     */
    public function __construct(HashInterface $hash)
    {
        parent::__construct($hash, new ReHash());
    }

    /**
     * @inheritDoc
     */
    public function traverse(Closure $visit)
    {
        // TODO: Implement traverse() method.
    }
}
