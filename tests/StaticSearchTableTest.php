<?php

use DataStructure\SearchTable\StaticSearchTable\IndexStaticSearchTable;
use DataStructure\SearchTable\Model\Element;
use DataStructure\SearchTable\StaticSearchTable\OrderStaticSearchTable;
use DataStructure\SearchTable\StaticSearchTable\SequenceStaticSearchTable;
use DataStructure\SearchTable\StaticSearchTable\TreeStaticSearchTable;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 *
 * Class StaticSearchTableTest
 */
class StaticSearchTableTest extends TestCase
{
    /**
     * @group static_search_table
     * @throws Exception
     */
    public function testSequence()
    {
        $elements = [
            new Element('laozhang1', 1),
            new Element('laozhang2', 2),
            new Element('laozhang3', 3),
            new Element('laozhang5', 5),
            new Element('laozhang4', 4),
        ];
        $table    = new SequenceStaticSearchTable($elements);
        $this->assertEquals(4, $table->search('laozhang4')->value);

        $result = [];
        $visit  = function (Element $element) use (&$result) {
            $result[] = $element->value;
        };
        $table->traverse($visit);
        $this->assertEquals([4, 5, 3, 2, 1], $result);
    }

    /**
     * @group static_search_table
     * @throws Exception
     */
    public function testOrder()
    {
        $elements = [
            new Element(82, 8),
            new Element(11, 1),
            new Element(19, 2),
            new Element(81, 7),
            new Element(99, 9),
            new Element(21, 3),
            new Element(44, 4),
            new Element(80, 6),
            new Element(66, 5),
        ];
        $table    = new OrderStaticSearchTable($elements);
        $this->assertEquals(6, $table->search(80)->value);
        $this->assertEquals(6, $table->fibonacciSearch(80)->value);
        $this->assertEquals(6, $table->interpolationSearch(80)->value);

        $result = [];
        $visit  = function (Element $element) use (&$result) {
            $result[] = $element->value;
        };
        $table->traverse($visit);
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9], $result);
    }

    /**
     * @group static_search_table
     * @throws Exception
     */
    public function testTree()
    {
        $elements = [
            new Element('A', 'A', 1),
            new Element('B', 'B', 1),
            new Element('C', 'C', 2),
            new Element('D', 'D', 5),
            new Element('E', 'E', 3),
            new Element('F', 'F', 4),
            new Element('G', 'G', 4),
            new Element('H', 'H', 3),
            new Element('I', 'I', 5),

        ];
        $table    = new TreeStaticSearchTable($elements);
        $this->assertEquals('D', $table->search('D')->value);

        $result = [];
        $visit  = function (Element $element) use (&$result) {
            $result[] = $element->value;
        };
        $table->traverse($visit);
        $this->assertEquals(['F', 'D', 'C', 'A', 'B', 'E', 'I', 'G', 'H'], $result);
    }

    /**
     * @group static_search_table
     * @throws Exception
     */
    public function testIndex()
    {
        $elements = [
            new Element(86, 1),
            new Element(53, 2),
            new Element(22, 3),
            new Element(12, 4),
            new Element(58, 5),
            new Element(74, 6),
            new Element(49, 7),
            new Element(44, 8),
            new Element(38, 9),
            new Element(24, 10),
            new Element(13, 11),
            new Element(8, 12),
            new Element(48, 13),
            new Element(60, 14),
            new Element(33, 15),
            new Element(42, 16),
            new Element(20, 17),
            new Element(9, 18),
        ];
        $table    = new IndexStaticSearchTable($elements);
        $this->assertEquals(15, $table->search(33)->value);

        $result = [];
        $visit  = function (Element $element) use (&$result) {
            $result[] = $element->value;
        };
        $table->traverse($visit);
        $this->assertEquals([18, 17, 12, 11, 4, 3, 15, 10, 9, 16, 13, 8, 7, 2, 14, 5, 6, 1], $result);
    }

    public function testMonthly()
    {
        $elements = [
            new Element('Jan', 1),
            new Element('Feb', 2),
            new Element('Mar', 3),
            new Element('Apr', 4),
            new Element('May', 5),
            new Element('Jun', 6),
            new Element('Jul', 7),
            new Element('Aug', 8),
            new Element('Sept', 9),
            new Element('Oct', 10),
            new Element('Nov', 11),
            new Element('Dec', 12),
        ];
        $table    = new OrderStaticSearchTable($elements);

        $result = [];
        $visit  = function (Element $element) use (&$result) {
            $result[] = $element->value;
        };
        $table->traverse($visit);
        $this->assertEquals([4, 8, 12, 2, 1, 7, 6, 3, 5, 11, 10, 9], $result);
    }
}
