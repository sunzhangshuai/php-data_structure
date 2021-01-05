<?php
/**
 * AbstractBinaryTree.php :
 *
 * PHP version 7.1
 *
 * @category AbstractBinaryTree
 * @package  DataStructure\Tree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree;

use DataStructure\Queue\SingleLinkedQueue;
use DataStructure\Tree\Interfaces\BinaryTreeInterface;
use Closure;

/**
 * AbstractBinaryTree : 二叉树基类
 *
 * @category AbstractBinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class AbstractBinaryTree implements BinaryTreeInterface
{
    const LEFT = 0;
    const RIGHT = 1;

    /**
     * @var SingleLinkedQueue
     */
    public $queue;

    /**
     * @inheritDoc
     */
    public function __construct($array = [])
    {
        $this->queue = new SingleLinkedQueue();
    }

    /**
     * @inheritDoc
     */
    abstract public function clearBiTree();

    /**
     * @inheritDoc
     */
    public function BiTreeEmpty()
    {
        return $this->root() === null;
    }

    /**
     * @inheritDoc
     */
    abstract public function biTreeDepth();

    /**
     * @inheritDoc
     */
    abstract public function root();

    /**
     * @inheritDoc
     */
    public function value($node)
    {
        return $node->data;
    }

    /**
     * @inheritDoc
     */
    public function assign($node, $value)
    {
        $node->data = $value;
    }

    /**
     * @inheritDoc
     */
    abstract public function parent($node);

    /**
     * @inheritDoc
     */
    abstract public function leftChild($node);

    /**
     * @inheritDoc
     */
    abstract public function rightChild($node);

    /**
     * @inheritDoc
     */
    abstract public function leftSibling($node);

    /**
     * @inheritDoc
     */
    abstract public function rightSibling($node);

    /**
     * @inheritDoc
     */
    abstract public function insertChild($node, $child_type, $new_node);

    /**
     * @inheritDoc
     */
    abstract public function deleteChild($node, $child_type);

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
     */
    abstract public function levelOrderTraverse(Closure $visit);
}
