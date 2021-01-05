<?php
/**
 * ExtendGeneralizedList.php :
 *
 * PHP version 7.1
 *
 * @category ExtendGeneralizedList
 * @package  DataStructure\GeneralizedList
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\GeneralizedList;


use DataStructure\GeneralizedList\Interfaces\GeneralizedListInterface;
use DataStructure\GeneralizedList\Model\GeneralizedNode;
use DataStructure\Stack\SequenceStack;
use DataStructure\String\HeapString;
use Closure;
use Exception;

/**
 * 扩展链式存储
 * ExtendGeneralizedList :
 *
 * @category ExtendGeneralizedList
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class ExtendGeneralizedList implements GeneralizedListInterface
{
    const NODE_ATOM = 0;
    const NODE_LIST = 1;

    /**
     * @var GeneralizedNode 表结点
     */
    public $node;

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function __construct(string $string = '')
    {
        if (!$string) return;

        $string = new HeapString($string);
        // 去掉空格
        $string->replace(new HeapString(' '), new HeapString(''));

        $temp_string1 = new HeapString('()');
        $temp_string2 = new HeapString('(');

        // 空表
        if ($string->strCompare($temp_string1) === 0) {
            $this->node = null;
            return;
        }

        $this->node = new GeneralizedNode();
        // 原子节点
        if ($string->index($temp_string2, 1) !== 1) {
            $this->node->tag  = self::NODE_ATOM;
            $this->node->atom = $string->__toString();
            return;
        }

        $this->node->tag = self::NODE_LIST;
        $string          = $string->subString(2, $string->length - 2);

        $index     = $this->division($string);
        $hp_string = $string->subString(1, $index - 1);
        if ($index > $string->length) {
            $tp_string = new HeapString('()');
        } else {
            $tp_string = $string->subString($index + 1, $string->length - $index);
        }
        $this->node->hp = new ExtendGeneralizedList($hp_string->__toString());

        $index_list = $this->node->hp;
        while ($index_list->node) {
            if ($tp_string->strCompare($temp_string1) === 0) {
                $index_list->node->tp = new ExtendGeneralizedList($tp_string);
            } else {
                $index     = $this->division($tp_string);
                $hp_string = $tp_string->subString(1, $index - 1);
                if ($index > $tp_string->length) {
                    $tp_string = new HeapString('()');
                } else {
                    $tp_string = $tp_string->subString($index + 1, $tp_string->length - $index);
                }
                $index_list->node->tp = new ExtendGeneralizedList($hp_string);
            }
            $index_list = $index_list->node->tp;
        }
    }

    /**
     * 获取分割点
     *
     * @param HeapString $string
     *
     * @return int
     * @throws Exception
     */
    private function division(HeapString $string)
    {
        $stack = new SequenceStack();
        for ($i = 0; $i < $string->length; $i++) {
            if ($string->chars[$i] === '(') {
                $stack->push('(');
            } elseif ($string->chars[$i] === ')') {
                $stack->pop();
            } elseif ($string->chars[$i] === ',' && $stack->stackEmpty()) {
                return $i + 1;
            }
        }
        return $stack ? $string->length + 1 : 0;
    }

    /**
     * @inheritDoc
     */
    public function __clone()
    {
        $result = new ExtendGeneralizedList();
        if (!$this->node) {
            return $result;
        }
        $result->node      = new GeneralizedNode();
        $result->node->tag = $this->node->tag;
        if ($result->node->tag === self::NODE_ATOM) {
            $result->node->atom = $this->node->atom;
        } else {
            $result->node->hp = clone $this->node->hp;
        }
        if ($this->node->tp) {
            $result->node->tp = clone $this->node->tp;
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function gListLength()
    {
        if (!$this->node) return 0;
        if ($this->node->tag === self::NODE_ATOM) {
            return 0;
        }
        $node   = $this->node->hp;
        $result = 0;
        while ($node->node) {
            $result++;
            $node = $node->node->tp;
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function gListDepth()
    {
        if (!$this->node) return 1;
        if ($this->node->tag === self::NODE_ATOM) {
            return 0;
        }
        $index_list = $this->node->hp;
        $max        = 0;
        while ($index_list->node) {
            $depth = $index_list->gListDepth();
            if ($max < $depth) $max = $depth;
            $index_list = $index_list->node->tp;
        }
        return $max + 1;
    }

    /**
     * @inheritDoc
     */
    public function gListEmpty()
    {
        return $this->gListLength() === 0;
    }

    /**
     * @inheritDoc
     */
    public function getHead()
    {
        return $this->node->hp;
    }

    /**
     * @inheritDoc
     */
    public function getTail()
    {
        $list            = new ExtendGeneralizedList();
        $list->node      = new GeneralizedNode();
        $list->node->tag = self::NODE_LIST;
        $list->node->hp  = $this->node->hp->node->tp;
        return $list;
    }

    /**
     * @inheritDoc
     */
    public function insertFirst($e)
    {
        // 1. 生成新的表尾节点，复制当前的表头结点节点
        $tp_list       = new ExtendGeneralizedList();
        $tp_list->node = $this->node->hp->node;

        $this->node->hp->node       = new GeneralizedNode();
        $this->node->hp->node->tag  = self::NODE_ATOM;
        $this->node->hp->node->atom = $e;
        $this->node->hp->node->tp   = $tp_list;
    }

    /**
     * @inheritDoc
     */
    public function deleteFirst()
    {
        $this->node->hp->node = $this->node->hp->node->tp->node;
    }

    /**
     * @inheritDoc
     */
    public function traverse(Closure $visit)
    {
        if (!$this->node) return;
        if ($this->node->tag === self::NODE_ATOM) {
            $visit($this->node);
        } else {
            $index_list = $this->node->hp;
            while ($index_list->node) {
                $index_list->traverse($visit);
                $index_list = $index_list->node->tp;
            }
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function __toString()
    {
        if (!$this->node) return '()';
        if ($this->node->tag === self::NODE_ATOM) {
            return $this->node->atom;
        }
        $temp_string1 = new HeapString('(');
        $temp_string2 = new HeapString(')');
        $temp_string3 = new HeapString(',');

        $index_list = $this->node->hp;

        $result = $temp_string1;
        while ($index_list->node) {
            $tp_str     = new HeapString($index_list->__toString());
            $result     = $result->concat($tp_str)->concat($temp_string3);
            $index_list = $index_list->node->tp;
        }
        if ($result->strLength() >= 1) {
            $result = $result->subString(1, $result->strLength() - 1);
        }
        return $result->concat($temp_string2)->__toString();
    }
}
