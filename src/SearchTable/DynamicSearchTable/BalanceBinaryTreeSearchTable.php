<?php
/**
 * BalanceBinaryTreeSearchTable.php :
 *
 * PHP version 7.1
 *
 * @category BalanceBinaryTreeSearchTable
 * @package  DataStructure\SearchTable\DynamicSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable;

use DataStructure\Tree\BinaryTree\BalanceBinaryTree;
use DataStructure\Tree\BinaryTree\Model\BalanceBinaryTreeNode;
use Closure;
use Exception;

/**
 * BalanceBinaryTreeSearchTable : 平衡二插查找表
 *
 * @category BalanceBinaryTreeSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class BalanceBinaryTreeSearchTable extends DynamicSearchTable
{
    /**
     * 查找树
     *
     * @var BalanceBinaryTree
     */
    public $tree;

    /**
     * 初始化
     * BalanceBinaryTreeSearchTable constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->tree = new BalanceBinaryTree();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function search($key)
    {
        $this->tree->stack->clearStack();
        return $this->searchByNode($this->tree->root(), $key);
    }

    /**
     * @param BalanceBinaryTreeNode $node
     * @param string|int            $key
     *
     * @return bool
     * @throws Exception
     */
    public function searchByNode($node, $key)
    {
        if ($node === null) {
            return null;
        } elseif ($node->data->key === $key) {
            return $node->data;
        } elseif ($node->data->key > $key) {
            $this->tree->stack->push($node);
            return $this->searchByNode($node->l_child, $key);
        } else {
            $this->tree->stack->push($node);
            return $this->searchByNode($node->r_child, $key);
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function insert($element)
    {
        if ($this->search($element->key)) {
            $this->tree->external_search = false;
            $this->tree->stack->clearStack();
            return false;
        }
        $this->tree->external_search = true;
        $new_node                    = new BalanceBinaryTreeNode($element);
        if (!$this->tree->root) {
            $this->tree->setRoot($new_node);
        } else {
            $parent     = $this->tree->stack->getTop();
            $child_type = $parent->data->key > $element->key ? 0 : 1;
            $this->tree->insertChild($parent, $child_type, $new_node);
        }
        $this->tree->external_search = false;
        $this->tree->stack->clearStack();
        return true;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function delete($key)
    {
        if (!$this->search($key)) {
            $this->tree->external_search = false;
            $this->tree->stack->clearStack();
            return false;
        }
        $this->tree->external_search = true;
        if ($this->tree->stack->stackEmpty()) {
            $this->tree->deleteRoot();
        } else {
            $parent     = $this->tree->stack->getTop();
            $child_type = $parent->data->key > $key ? 0 : 1;
            $this->tree->deleteChild($parent, $child_type);
        }
        $this->tree->external_search = false;
        $this->tree->stack->clearStack();
        return true;
    }

    /**
     * @inheritDoc
     */
    public function traverse(Closure $visit)
    {
        $this->tree->inOrderTraverse($visit);
    }
}
