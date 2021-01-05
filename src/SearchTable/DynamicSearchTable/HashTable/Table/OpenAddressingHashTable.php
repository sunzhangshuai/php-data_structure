<?php
/**
 * OpenAddressingHashTable.php :
 *
 * PHP version 7.1
 *
 * @category OpenAddressingHashTable
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Table
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Table;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict\ConflictInterface;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict\LinearProbing;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict\QuadraticProbing;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict\RandomProbing;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\HashInterface;
use Closure;
use Exception;

class OpenAddressingHashTable extends AbstractHashTable
{
    /**
     * @var array
     */
    protected $hash_size = [];

    /**
     * 初始化
     *
     * OpenAddressingHashTable constructor.
     *
     * @param HashInterface     $hash
     * @param ConflictInterface $conflict
     *
     * @throws Exception
     */
    public function __construct(HashInterface $hash, ConflictInterface $conflict)
    {
        if ($conflict instanceof LinearProbing || $conflict instanceof QuadraticProbing || $conflict instanceof RandomProbing) {
            parent::__construct($hash, $conflict);
        }
        throw new Exception('开放寻址hash表暂不支持其他的冲突办法');
    }


    /**
     * @inheritDoc
     */
    public function traverse(Closure $visit)
    {
        // TODO: Implement traverse() method.
    }
}
