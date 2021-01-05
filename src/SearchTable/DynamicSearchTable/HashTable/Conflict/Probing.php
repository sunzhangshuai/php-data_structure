<?php
/**
 * Probing.php :
 *
 * PHP version 7.1
 *
 * @category Probing
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict;


use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;
use DataStructure\SearchTable\Model\Element;

abstract class Probing implements ConflictInterface
{
    /**
     * @inheritDoc
     */
    public function search(AbstractHashTable $hashTable, $index, $key)
    {
        $conflict_count = 0;
        $new_index      = $index;
        while ($hashTable->data[$new_index] != null && $conflict_count < $this->getMaxConflictNum($hashTable)) {
            if ($hashTable->data[$new_index]->key == $key && $hashTable->data[$new_index]->is_deleted == false) {
                return $hashTable->data[$new_index];
            } elseif ($hashTable->data[$new_index]->key == $key) {
                return null;
            } else {
                $conflict_count++;
                $new_index = $this->getNextIndex($index, $conflict_count, $hashTable, $key);
            }
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function insert(AbstractHashTable $hashTable, $index, $element)
    {
        $new_index      = $index;
        $conflict_count = 0;
        while ($hashTable->data[$new_index] != null && $conflict_count < $this->getMaxConflictNum($hashTable)) {
            if ($hashTable->data[$new_index]->key == $element->key) {
                $hashTable->data[$new_index] = $element;
                return true;
            } else {
                $conflict_count++;
                $new_index = $this->getNextIndex($index, $conflict_count, $hashTable, $element->key);
            }
        }
        if ($conflict_count >= $this->getMaxConflictNum($hashTable)) {
            // 重建hash表
            $hashTable->recreate();
            $index = $hashTable->getHash($element->key);
            return $this->insert($hashTable, $index, $element);
        }
        $hashTable->data[$index] = $element;
        return true;
    }

    /**
     * @inheritDoc
     */
    public function delete(AbstractHashTable $hashTable, $index, $key)
    {
        /** @var Element $element */
        $element = $this->search($hashTable, $index, $key);
        if ($element == null) {
            return false;
        }
        $element->is_deleted = true;
        return true;
    }

    /**
     * 冲突后，获取下一个检测位置
     *
     * @param int               $index
     * @param int               $conflict_count 冲突次数
     * @param AbstractHashTable $hashTable
     * @param mixed             $key            关键字
     *
     * @return int
     */
    abstract public function getNextIndex($index, $conflict_count, $hashTable, $key);

    /**
     * 获取最大冲突次数
     *
     * @param AbstractHashTable $hashTable
     *
     * @return int
     */
    public function getMaxConflictNum($hashTable)
    {
        $table_size = $hashTable->hash_size[$hashTable->table_size_index];
        return ceil($table_size / 2);
    }
}
