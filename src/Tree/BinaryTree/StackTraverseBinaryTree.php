<?php
/**
 * StackTraverseBinaryTree.php :
 *
 * PHP version 7.1
 *
 * @category StackTraverseBinaryTree
 * @package  DataStructure\Tree\BinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree;

use DataStructure\Tree\BinaryTree\Model\BinaryTreeNode;
use Closure;
use Exception;

/**
 * StackTraverseBinaryTree : 栈式遍历二叉树
 *
 * @category StackTraverseBinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class StackTraverseBinaryTree extends BinaryTree
{
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
     * @throws Exception
     */
    public function preOrderTraverse(Closure $visit)
    {
        $node = $this->root;
        $this->stack->clearStack();
        while ($node) {
            $visit($node->data);
            if ($node->r_child) {
                $this->stack->push($node->r_child);
            }
            if ($node->l_child) {
                $node = $node->l_child;
            } else {
                $node = $this->stack->pop();
            }
        }
    }

    /**
     * @param BinaryTreeNode $node
     * @param Closure        $visit
     */
    protected function preOrder($node, Closure $visit)
    {

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
