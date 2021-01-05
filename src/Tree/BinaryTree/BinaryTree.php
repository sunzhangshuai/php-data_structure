<?php
/**
 * Tree.php :
 *
 * PHP version 7.1
 *
 * @category Tree
 * @package  DataStructure\Tree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree;

use DataStructure\Stack\SequenceStack;
use DataStructure\Tree\BinaryTree\Model\BinaryTreeNode;
use Closure;

/**
 * BinaryTree : 二叉树
 *
 * @category BinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class BinaryTree extends LinkedBinaryTree
{
    /**
     * 初始化
     * BinaryTree constructor.
     *
     * @param array $array
     */
    public function __construct($array = [])
    {
        parent::__construct($array);
        $this->stack = new SequenceStack();
        if (!$array) return;
        $index      = 0;
        $this->root = $this->createTree($index, $array);
    }

    /**
     * 创建二叉树
     *
     * @param $index
     * @param $array
     *
     * @return BinaryTreeNode
     */
    protected function createTree(&$index, $array)
    {
        if ($array[$index] === 0) {
            $index++;
            return null;
        }
        $node = new BinaryTreeNode($array[$index]);
        $index++;
        $node->l_child = $this->createTree($index, $array);
        $node->r_child = $this->createTree($index, $array);
        return $node;
    }

    /**
     * @inheritDoc
     */
    public function biTreeDepth()
    {
        $this->getTreeDepth($this->root());
    }

    /**
     * @param BinaryTreeNode|null $node
     *
     * @return int
     */
    protected function getTreeDepth($node)
    {
        if (!$node) return 0;
        return max($this->getTreeDepth($node->l_child), $this->getTreeDepth($node->r_child)) + 1;
    }

    /**
     * @inheritDoc
     */
    public function preOrderTraverse(Closure $visit)
    {
        $this->preOrder($this->root, $visit);
    }

    /**
     * @param BinaryTreeNode $node
     * @param Closure        $visit
     */
    protected function preOrder($node, Closure $visit)
    {
        if (!$node) return;
        $visit($node->data);
        $this->preOrder($node->l_child, $visit);
        $this->preOrder($node->r_child, $visit);
    }

    /**
     * @inheritDoc
     */
    public function inOrderTraverse(Closure $visit)
    {
        $this->inOrder($this->root, $visit);
    }

    /**
     * @param BinaryTreeNode $node
     * @param Closure        $visit
     */
    protected function inOrder($node, Closure $visit)
    {
        if (!$node) return;
        $this->inOrder($node->l_child, $visit);
        $visit($node->data);
        $this->inOrder($node->r_child, $visit);
    }

    /**
     * @inheritDoc
     */
    public function postOrderTraverse(Closure $visit)
    {
        $this->postOrder($this->root, $visit);
    }

    /**
     * @param BinaryTreeNode $node
     * @param Closure        $visit
     */
    protected function postOrder($node, Closure $visit)
    {
        if (!$node) return;
        $this->postOrder($node->l_child, $visit);
        $this->postOrder($node->r_child, $visit);
        $visit($node->data);
    }
}
