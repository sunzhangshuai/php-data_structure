<?php

use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\Mod;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\LinkedHashTable;
use DataStructure\SearchTable\DynamicSearchTable\SkipListSearchTable;
use DataStructure\SearchTable\Model\Element;
use DataStructure\SearchTable\Model\SkipNode;
use PHPUnit\Framework\TestCase;

/**
 *
 * Class HashTableTest
 * @package Tests\Feature\DataStructure
 */
class HashTableTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLinkedHashTable()
    {
        $hash_table = new LinkedHashTable(Mod::getInstance());
        $hash_table->insert(new Element(1, 15));
        $hash_table->insert(new Element(98, 16));
        $hash_table->search(98);
        $hash_table->delete(1);
        $this->assertTrue(true);
    }

    public function testSkipListTable()
    {
        $hash_table = new SkipListSearchTable();
        $items = [
            new SkipNode(8, 'A'),
            new SkipNode(4, 'B'),
            new SkipNode(1, 'C'),
            new SkipNode(2, 'D'),
            new SkipNode(5, 'E'),
            new SkipNode(3, 'F'),
            new SkipNode(9, 'G'),
            new SkipNode(7, 'H'),
            new SkipNode(6, 'I'),
            new SkipNode(10, 'A')
        ];
        foreach ($items as $item) {
            $hash_table->insert($item);
        }

        // todo 查询有点问题
        $skip_node = new SkipNode(6);
        $skip_node->request_type = SkipNode::SCORE;
        $skip_node->response_type = SkipNode::ELEMENT;
        $this->assertEquals($hash_table->search($skip_node), 'I');

        $skip_node = new SkipNode(6);
        $skip_node->request_type = SkipNode::SCORE;
        $skip_node->response_type = SkipNode::RANK;
        $this->assertEquals($hash_table->search($skip_node), 5);

        /**==============================================================================================*/

        $skip_node = new SkipNode(0, 'D');
        $skip_node->request_type = SkipNode::ELEMENT;
        $skip_node->response_type = SkipNode::SCORE;
        $this->assertEquals($hash_table->search($skip_node), 2);

        $skip_node = new SkipNode(0, 'D');
        $skip_node->request_type = SkipNode::ELEMENT;
        $skip_node->response_type = SkipNode::RANK;
        $this->assertEquals($hash_table->search($skip_node), 1);

        /**==============================================================================================*/

        $skip_node = new SkipNode();
        $skip_node->rank = 4;
        $skip_node->request_type = SkipNode::RANK;
        $skip_node->response_type = SkipNode::SCORE;
        $this->assertEquals($hash_table->search($skip_node), 5);

        $skip_node = new SkipNode();
        $skip_node->rank = 8;
        $skip_node->request_type = SkipNode::RANK;
        $skip_node->response_type = SkipNode::ELEMENT;
        $this->assertEquals($hash_table->search($skip_node), 'A');
    }
}
