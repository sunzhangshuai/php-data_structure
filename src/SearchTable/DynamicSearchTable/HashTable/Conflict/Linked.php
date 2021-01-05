<?php
/**
 * Linked.php :
 *
 * PHP version 7.1
 *
 * @category Linked
 * @package  DataStructure\SearchTable\DynamicSearchTable\HashTableTest\Conflict
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable\HashTable\Conflict;

use DataStructure\Lists\Model\LinkedListNode;
use DataStructure\Lists\SingleLinkedList;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\AbstractHashTable;

class Linked implements ConflictInterface
{
    /**
     * @inheritDoc
     */
    public function search(AbstractHashTable $hashTable, $index, $key)
    {
        /** @var SingleLinkedList $list */
        if (!$hashTable->data[$index]) {
            return null;
        }
        $list = $hashTable->data[$index];
        $node = $list->getHead();
        while ($node && $node->data->key < $key) {
            $node = $node->next;
        }
        if (!$node || $node->data->key !== $key) return null;
        return $node->data;
    }

    /**
     * @inheritDoc
     */
    public function insert(AbstractHashTable $hashTable, $index, $element)
    {
        if (!$hashTable->data[$index]) {
            $hashTable->data[$index] = new SingleLinkedList();
        }
        /** @var SingleLinkedList $list */
        $list     = $hashTable->data[$index];
        $node     = $list->getHead();
        $new_node = new LinkedListNode($element);
        if ($node == null || $element->key < $node->data->key) {
            $list->insFirst($new_node);
            return true;
        }
        if ($node->data->key == $element->key) return false;
        while ($node->next && $node->next->data->key < $element->key) {
            $node = $node->next;
        }
        if ($node->next && $node->next->data->key == $element->key) {
            return false;
        }
        $new_node->next = $node->next;
        $node->next     = $new_node;
        return true;
    }

    /**
     * @inheritDoc
     */
    public function delete(AbstractHashTable $hashTable, $index, $key)
    {
        /** @var SingleLinkedList $list */
        $list = $hashTable->data[$index];
        $node = $list->getHead();
        if ($node->data->key == $key) {
            $list->head = $node->next;
            return true;
        }
        while ($node->next && $node->next->data->key < $key) {
            $node = $node->next;
        }
        if ($node->next->data->key != $key) {
            return false;
        }
        $node->next = $node->next->next;
        return true;
    }
}
