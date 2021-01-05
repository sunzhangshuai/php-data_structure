<?php
/**
 * AbstractTree.php :
 *
 * PHP version 7.1
 *
 * @category AbstractTree
 * @package  DataStructure\Tree\Tree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\Tree;

use DataStructure\Tree\Interfaces\TreeInterface;
use Closure;

/**
 * AbstractTree : 树的抽象类
 *
 * @category AbstractTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class AbstractTree implements TreeInterface
{
    /**
     * @inheritDoc
     */
    abstract public function __construct();

    /**
     * @inheritDoc
     */
    public function treeEmpty()
    {
        return $this->root() === null;
    }

    /**
     * @inheritDoc
     */
    abstract public function treeDepth();

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
    public function assign($node, $data)
    {
        $node->data = $data;
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
    abstract public function rightSibling($node);

    /**
     * @inheritDoc
     */
    abstract public function insertChild($node, $index, $new_node);

    /**
     * @inheritDoc
     */
    abstract public function deleteChild($node, $index);

    /**
     * @inheritDoc
     */
    abstract public function preTraverseTree(Closure $visit);

    /**
     * @inheritDoc
     */
    abstract public function postTraverseTree(Closure $visit);
}
