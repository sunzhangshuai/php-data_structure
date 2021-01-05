<?php
/**
 * AbstractHashTable.php :
 *
 * PHP version 7.1
 *
 * @category AbstractHashTable
 * @package  DataStructure\SearchTable\DynamicSearchTable\AbstractHashTable\Table
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Table;

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict\ConflictInterface;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\HashInterface;
use DataStructure\SearchTable\Interfaces\DynamicSearchTableInterface;
use Closure;

/**
 * AbstractHashTable : 散列表
 *
 * @category AbstractHashTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class AbstractHashTable implements DynamicSearchTableInterface
{
    /**
     * @var int hash表容量递增表
     */
    public $hash_size;

    /**
     * @var int 哈希表长度取值的索引
     */
    public $table_size_index;

    /**
     * @var ConflictInterface 冲突解决方案
     */
    protected $conflict;

    /**
     * @var HashInterface hash方法
     */
    protected $hash;

    /**
     * @var mixed[]
     */
    public $data;

    /**
     * @var int 基址
     */
    public $base_address = 0;

    /**
     * @inheritDoc
     */
    public function __construct(HashInterface $hash, ConflictInterface $conflict)
    {
        $this->hash     = $hash;
        $this->conflict = $conflict;
        $this->initHashSize();
        $this->data = array_fill(0, $this->hash_size[$this->table_size_index], null);
    }

    /**
     * @inheritDoc
     */
    public function search($key)
    {
        $hash_index = $this->getHash($key);
        return $this->conflict->search($this, $hash_index, $key);
    }

    /**
     * @inheritDoc
     */
    public function insert($element)
    {
        $hash_index = $this->getHash($element->key);
        return $this->conflict->insert($this, $hash_index, $element);
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        $hash_index = $this->getHash($key);
        return $this->conflict->delete($this, $hash_index, $key);
    }

    /**
     * 获取hash值
     *
     * @param $key
     *
     * @return int
     */
    public function getHash($key)
    {
        return $this->hash->handle($this, $key);
    }

    /**
     * hash表重做
     */
    public function recreate()
    {
        $tmp_data = $this->data;
        $this->table_size_index++;
        $this->data = array_fill(0, $this->hash_size[$this->table_size_index], null);
        for ($i = 0; $i < $this->hash_size[$this->table_size_index - 1]; $i++) {
            if ($tmp_data[$i] && $tmp_data[$i]->is_deleted == false) {
                $this->insert($tmp_data[$i]);
            }
        }
    }

    /**
     * @inheritDoc
     */
    abstract public function traverse(Closure $visit);

    /**
     * 初始化 hash表容量递增表
     */
    public function initHashSize()
    {
        $this->table_size_index = 0;
        for ($i = 100; $i < 1000; $i++) {
            $status = true;
            for ($j = 2; $j <= floor(sqrt($i)); $j++) {
                if ($i % $j == 0) {
                    $status = false;
                    break;
                }
            }
            if ($status) $this->hash_size[] = $i;
        }
    }

    /**
     * 获取表长
     *
     * @return int
     */
    public function getTableLength()
    {
        return $this->hash_size[$this->table_size_index];
    }
}
