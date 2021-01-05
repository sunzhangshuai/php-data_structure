<?php
/**
 * LinkedHashTable.php :
 *
 * PHP version 7.1
 *
 * @category LinkedHashTable
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTableTest\Table
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Table;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict\Linked;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\HashInterface;
use Closure;

class LinkedHashTable extends AbstractHashTable
{
    const MAX_SIZE = 100;

    /**
     * @var Linked 冲突解决方案
     */
    protected $conflict;

    /**
     * @var HashInterface hash函数
     */
    protected $hash;

    /**
     * 初始化
     * LinkedHashTable constructor.
     *
     * @param HashInterface $hash
     */
    public function __construct(HashInterface $hash)
    {
        parent::__construct($hash, new Linked());
    }

    /**
     * @inheritDoc
     */
    public function traverse(Closure $visit)
    {
        // TODO: Implement traverse() method.
    }
}
