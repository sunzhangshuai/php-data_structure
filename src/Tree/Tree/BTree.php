<?php
/**
 * BTree.php :
 *
 * PHP version 7.1
 *
 * @category BTree
 * @package  DataStructure\Tree\Tree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\Tree;

use Closure;

class BTree extends AbstractTree
{

    /**
     * @inheritDoc
     */
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function treeDepth()
    {
        // TODO: Implement treeDepth() method.
    }

    /**
     * @inheritDoc
     */
    public function root()
    {
        // TODO: Implement root() method.
    }

    /**
     * @inheritDoc
     */
    public function parent($node)
    {
        // TODO: Implement parent() method.
    }

    /**
     * @inheritDoc
     */
    public function leftChild($node)
    {
        // TODO: Implement leftChild() method.
    }

    /**
     * @inheritDoc
     */
    public function rightSibling($node)
    {
        // TODO: Implement rightSibling() method.
    }

    /**
     * @inheritDoc
     */
    public function insertChild($node, $index, $new_node)
    {
        // TODO: Implement insertChild() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteChild($node, $index)
    {
        // TODO: Implement deleteChild() method.
    }

    /**
     * @inheritDoc
     */
    public function preTraverseTree(Closure $visit)
    {
        // TODO: Implement preTraverseTree() method.
    }

    /**
     * @inheritDoc
     */
    public function postTraverseTree(Closure $visit)
    {
        // TODO: Implement postTraverseTree() method.
    }
}
