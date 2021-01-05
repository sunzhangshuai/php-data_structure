<?php

use DataStructure\SearchTable\DynamicSearchTable\BalanceBinaryTreeSearchTable;
use DataStructure\SearchTable\DynamicSearchTable\BinarySortTreeSearchTable;
use DataStructure\SearchTable\Model\Element;
use Exception;
use PHPUnit\Framework\TestCase;

class DynamicSearchTableTest extends TestCase
{
    /**
     * 二叉排序树
     *
     * @group dynamic_search_table
     */
    public function testBinarySortTree()
    {
        $search_table = new BinarySortTreeSearchTable();
        $search_table->insert(new Element(45, 45));
        $search_table->insert(new Element(93, 93));
        $search_table->insert(new Element(37, 37));
        $search_table->insert(new Element(12, 12));
        $search_table->insert(new Element(53, 53));
        $result = [];
        $visit  = function (Element $element) use (&$result) {
            $result[] = $element->value;
        };
        $search_table->traverse($visit);
        $this->assertEquals([12, 37, 45, 53, 93], $result);

        $search_table->delete(12);
        $result = [];
        $search_table->traverse($visit);
        $this->assertEquals([37, 45, 53, 93], $result);

        $search_table->delete(45);
        $result = [];
        $search_table->traverse($visit);
        $this->assertEquals([37, 53, 93], $result);
    }

    /**
     * 平衡二叉树
     *
     * @group dynamic_search_table
     * @throws Exception
     */
    public function testBalanceBinaryTree()
    {
        $search_table = new BalanceBinaryTreeSearchTable();
        $search_table->insert(new Element('Jan', 1));
        $search_table->insert(new Element('Feb', 2));
        $search_table->insert(new Element('Mar', 3));
        $search_table->insert(new Element('Apr', 4));
        $search_table->insert(new Element('May', 5));
        $search_table->insert(new Element('Jun', 6));
        $search_table->insert(new Element('Jul', 7));
        $search_table->insert(new Element('Aug', 8));
        $search_table->insert(new Element('Sept', 9));
        $search_table->insert(new Element('Oct', 10));
        $search_table->insert(new Element('Nov', 11));
        $search_table->insert(new Element('Dec', 12));
        $result = [];
        $visit  = function (Element $element) use (&$result) {
            $result[] = $element->value;
        };
        $search_table->traverse($visit);
        $this->assertEquals([4, 8, 12, 2, 1, 7, 6, 3, 5, 11, 10, 9], $result);

        $search_table->delete('Oct');
        $result = [];
        $search_table->traverse($visit);
        $this->assertEquals([4, 8, 12, 2, 1, 7, 6, 3, 5, 11, 9], $result);
    }
}
