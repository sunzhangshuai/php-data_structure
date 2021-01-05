<?php
/**
 * LinkedBinaryTree.php :
 *
 * PHP version 7.1
 *
 * @category LinkedBinaryTree
 * @package  DataStructure\Tree\BinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree;

use DataStructure\Stack\SequenceStack;
use DataStructure\Tree\BinaryTree\Model\BalanceBinaryTreeNode;
use DataStructure\Tree\BinaryTree\Model\BinaryTreeNode;
use Closure;
use Exception;

/**
 * LinkedBinaryTree : 链式二叉树
 *
 * @category LinkedBinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class LinkedBinaryTree extends AbstractBinaryTree
{
    /**
     * @var BinaryTreeNode|BalanceBinaryTreeNode 根节点
     */
    public $root;

    /**
     * @var SequenceStack 栈
     */
    public $stack;

    /**
     * @inheritDoc
     */
    public function clearBiTree()
    {
        $this->root = null;
    }

    /**
     * @inheritDoc
     */
    public function root()
    {
        return $this->root;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function parent($node)
    {
        if ($this->root() === $node) {
            throw new Exception('node节点没有父节点');
        }
        $this->stack->clearStack();
        $this->stack->push($this->root());

        while (!$this->stack->stackEmpty()) {
            $cur = $this->stack->pop();
            if ($cur->r_child === $node || $cur->l_child === $node) {
                return $cur;
            }
            if ($cur->r_child != null) $this->stack->push($cur->r_child);
            if ($cur->l_child != null) $this->stack->push($cur->l_child);
        }
        throw new Exception('node节点没有父节点');
    }

    /**
     * @inheritDoc
     */
    public function leftChild($node)
    {
        return $node->l_child;
    }

    /**
     * @inheritDoc
     */
    public function rightChild($node)
    {
        return $node->r_child;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function leftSibling($node)
    {
        try {
            $parent = $this->parent($node);
        } catch (Exception $exception) {
            throw new Exception('没有左兄弟');
        }
        if ($node === $parent->l_child) {
            throw new Exception('没有左兄弟');
        }
        return $parent->l_child;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function rightSibling($node)
    {
        try {
            $parent = $this->parent($node);
        } catch (Exception $exception) {
            throw new Exception('没有右兄弟');
        }
        if ($node === $parent->r_child) {
            throw new Exception('没有右兄弟');
        }
        return $parent->r_child;
    }

    /**
     * @inheritDoc
     */
    public function insertChild($node, $child_type, $new_node)
    {
        $original_node     = $child_type == 0 ? $node->l_child : $node->r_child;
        $new_node->r_child = $original_node;
        $child_type == 0 ? $node->l_child = $new_node : $node->r_child = $new_node;
    }

    /**
     * @inheritDoc
     */
    public function deleteChild($node, $child_type)
    {
    }

    /**
     * @inheritDoc
     */
    abstract public function preOrderTraverse(Closure $visit);

    /**
     * @inheritDoc
     */
    abstract public function inOrderTraverse(Closure $visit);

    /**
     * @inheritDoc
     */
    abstract public function postOrderTraverse(Closure $visit);

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function levelOrderTraverse(Closure $visit)
    {
        if ($this->BiTreeEmpty()) {
            return;
        }
        $this->queue->clearQueue();
        $this->queue->enQueue($this->root());
        while (!$this->queue->queueEmpty()) {
            $node = $this->queue->deQueue();
            $visit($node->data);
            if ($node->l_child) {
                $this->queue->enQueue($node->l_child);
            }
            if ($node->r_child) {
                $this->queue->enQueue($node->r_child);
            }
        }
    }
}
