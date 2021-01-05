<?php

use DataStructure\GeneralizedList\ExtendGeneralizedList;
use DataStructure\GeneralizedList\GeneralizedList;
use DataStructure\GeneralizedList\Model\GeneralizedNode;
use Exception;
use PHPUnit\Framework\TestCase;

class GeneralizedListTest extends TestCase
{
    /**
     * @group generalized_list
     * @throws Exception
     */
    public function testGeneralizedList()
    {
        $string = '(a,(b,c),d,(4,(5,f)))';
        // 初始化
        $generalized_list = new GeneralizedList($string);
        $this->assertEquals($generalized_list->__toString(), $string);

        // 复制
        $copy_generalized_list = clone $generalized_list;
        $this->assertEquals($copy_generalized_list->__toString(), $string);

        // 长度和深度
        $this->assertEquals(4, $generalized_list->gListLength());
        $this->assertEquals(3, $generalized_list->gListDepth());

        // 插入删除
        $generalized_list->insertFirst('laosun');
        $this->assertEquals('(laosun,a,(b,c),d,(4,(5,f)))', $generalized_list->__toString());
        $next_generalized_list = $generalized_list->getTail();
        $next_generalized_list->insertFirst('maomao');
        $this->assertEquals('(laosun,maomao,a,(b,c),d,(4,(5,f)))', $generalized_list->__toString());
        $generalized_list->deleteFirst();
        $generalized_list->deleteFirst();
        $this->assertEquals($string, $generalized_list->__toString());

        $next_generalized_list = $generalized_list->getTail()->getHead();
        $next_generalized_list->insertFirst('laozhang');
        $this->assertEquals('(a,(laozhang,b,c),d,(4,(5,f)))', $generalized_list->__toString());

    }

    /**
     * @group generalized_list
     * @throws Exception
     */
    public function testExtendGeneralizedList()
    {
        $string = '(a,(b,c),d,(4,(5,f)))';
        // 初始化
        $generalized_list = new ExtendGeneralizedList($string);
        $this->assertEquals($generalized_list->__toString(), $string);

        // 复制
        $copy_generalized_list = clone $generalized_list;
        $this->assertEquals($copy_generalized_list->__toString(), $string);

        // 长度和深度
        $this->assertEquals(4, $generalized_list->gListLength());
        $this->assertEquals(3, $generalized_list->gListDepth());

        // 插入删除
        $generalized_list->insertFirst('laosun');
        $this->assertEquals('(laosun,a,(b,c),d,(4,(5,f)))', $generalized_list->__toString());
        $next_generalized_list = $generalized_list->getTail();
        $next_generalized_list->insertFirst('maomao');
        $this->assertEquals('(laosun,maomao,a,(b,c),d,(4,(5,f)))', $generalized_list->__toString());

        $next_generalized_list = $generalized_list->getTail();
        $next_generalized_list->deleteFirst();
        $this->assertEquals('(laosun,a,(b,c),d,(4,(5,f)))', $generalized_list->__toString());

        $generalized_list->deleteFirst();
        $this->assertEquals($string, $generalized_list->__toString());

        $next_generalized_list = $generalized_list->getTail()->getHead();
        $next_generalized_list->insertFirst('laozhang');
        $this->assertEquals('(a,(laozhang,b,c),d,(4,(5,f)))', $generalized_list->__toString());

        $string = '(a,(a,b),((c,d)))';
        // 初始化
        $generalized_list = new ExtendGeneralizedList($string);
        $visit            = function (GeneralizedNode $node) {
//            echo $node->atom . PHP_EOL;
        };
        $generalized_list->traverse($visit);
        $this->assertEquals($generalized_list->__toString(), $string);
    }
}
