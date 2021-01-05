<?php
/**
 * GeneralizedList.php :
 *
 * PHP version 7.1
 *
 * @category GeneralizedList
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
 * 头尾链表存储的广义表
 * GeneralizedList :
 *
 * @category GeneralizedList
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class GeneralizedList implements GeneralizedListInterface
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
        if (!$string) {
            return;
        }
        $string = new HeapString($string);
        // 去掉空格
        $string->replace(new HeapString(' '), new HeapString(''));

        $temp_string1 = new HeapString('()');
        $temp_string2 = new HeapString('(');
        $temp_string3 = new HeapString(')');

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

        // 列表节点
        $this->node->tag = self::NODE_LIST;
        // 获取分隔位置
        $string = $string->subString(2, $string->length - 2);
        $index  = $this->division($string);

        $hp_string = $string->subString(1, $index - 1);
        if ($index > $string->length) {
            $tp_string = $temp_string1;
        } else {
            $tp_string = $temp_string2->concat($string->subString($index + 1, $string->length - $index))->concat($temp_string3);

        }
        $this->node->hp = new GeneralizedList($hp_string->__toString());
        $this->node->tp = new GeneralizedList($tp_string->__toString());
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
        $result = new GeneralizedList();
        if (!$this->node) {
            return $result;
        }
        $result->node      = new GeneralizedNode();
        $result->node->tag = $this->node->tag;
        if ($result->node->tag === self::NODE_ATOM) {
            $result->node->atom = $this->node->atom;
            return $result;
        }
        $result->node->hp = clone $this->node->hp;
        $result->node->tp = clone $this->node->tp;
        return $result;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function gListLength()
    {
        if ($this->node->tag === self::NODE_ATOM) throw new Exception('非广义表');
        $node   = $this->node;
        $result = 0;
        while ($node) {
            $result++;
            $node = $node->tp->node;
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function gListDepth()
    {
        if (!$this->node) return 1;
        if ($this->node->tag === self::NODE_ATOM) return 0;
        $max  = 0;
        $node = $this->node;
        while ($node) {
            $depth = $node->hp->gListDepth();
            if ($max < $depth) $max = $depth;
            $node = $node->tp->node;
        }
        return $max + 1;
    }

    /**
     * @inheritDoc
     */
    public function gListEmpty()
    {
        return $this->node === null;
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
        return $this->node->tp;
    }

    /**
     * @inheritDoc
     */
    public function insertFirst($e)
    {
        // 1. 生成新的表尾节点。
        // 表尾节点需要复制当前的表头结点
        $tp_list       = new GeneralizedList();
        $tp_list->node = $this->node;

        // 2. 生成新的表头结点，值为要查入的节点。
        $hp_list             = new GeneralizedList();
        $hp_list->node       = new GeneralizedNode();
        $hp_list->node->tag  = self::NODE_ATOM;
        $hp_list->node->atom = $e;

        // 3. 让当前节点hp指向新生成的表头结点，tp指向新生成的表尾节点。
        $this->node      = new GeneralizedNode();
        $this->node->tag = self::NODE_LIST;
        $this->node->hp  = $hp_list;
        $this->node->tp  = $tp_list;
    }

    /**
     * @inheritDoc
     */
    public function deleteFirst()
    {
        $this->node = $this->node->tp->node;
    }

    /**
     * @inheritDoc
     */
    public function traverse(Closure $visit)
    {
        if ($this->node == null) {
            return;
        }
        if ($this->node->tag == self::NODE_ATOM) {
            $visit($this->node);
        } else {
            $this->node->hp->traverse($visit);
            $this->node->tp->traverse($visit);
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

        $hp_str = new HeapString($this->node->hp->__toString());
        $tp_str = new HeapString($this->node->tp->__toString());
        $tp_str = $tp_str->subString(2, $tp_str->strLength() - 2);
        $string = new HeapString();

        if ($tp_str->length > 0) {
            return $string->concat($temp_string1)
                ->concat($hp_str)
                ->concat($temp_string3)
                ->concat($tp_str)
                ->concat($temp_string2)
                ->__toString();
        }
        return $string->concat($temp_string1)
            ->concat($hp_str)
            ->concat($temp_string2)
            ->__toString();
    }
}
