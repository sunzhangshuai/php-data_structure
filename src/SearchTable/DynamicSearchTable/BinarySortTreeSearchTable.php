<?php
/**
 * BinarySortTreeSearchTable.php :
 *
 * PHP version 7.1
 *
 * @category BinarySortTreeSearchTable
 * @package  DataStructure\SearchTable\DynamicSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable;

use DataStructure\Tree\BinaryTree\BinarySortTree;
use DataStructure\Tree\BinaryTree\Model\BinaryTreeNode;
use Closure;

/**
 * BinarySortTreeSearchTable : 二叉排序树搜索表
 *
 * @category BinarySortTreeSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class BinarySortTreeSearchTable extends DynamicSearchTable
{
    /**
     * @var BinarySortTree
     */
    public $tree;

    /**
     * @var BinaryTreeNode 查询过程中找到的父节点
     */
    public $parent_node;

    /**
     * 初始化
     * BinarySortTreeSearchTable constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->tree = new BinarySortTree();
    }

    /**
     * @inheritDoc
     */
    public function search($key)
    {
        $this->parent_node = null;
        return $this->searchByNode($this->tree->root(), $key);
    }

    /**
     * @param BinaryTreeNode $node
     * @param string|int     $key
     *
     * @return bool
     */
    public function searchByNode($node, $key)
    {
        if ($node === null) {
            return null;
        } elseif ($node->data->key === $key) {
            return $node->data;
        } elseif ($node->data->key > $key) {
            $this->parent_node = $node;
            return $this->searchByNode($node->l_child, $key);
        } else {
            $this->parent_node = $node;
            return $this->searchByNode($node->r_child, $key);
        }
    }

    /**
     * @inheritDoc
     */
    public function insert($element)
    {
        if ($this->search($element->key)) {
            return false;
        }
        $new_node = new BinaryTreeNode($element);
        if (!$this->tree->root) {
            $this->tree->setRoot($new_node);
        } else {
            $child_type = $this->parent_node->data->key > $element->key ? 0 : 1;
            $this->tree->insertChild($this->parent_node, $child_type, $new_node);
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        if (!$this->search($key)) {
            return false;
        }
        if (!$this->parent_node) {
            $this->tree->deleteRoot();
        } else {
            $child_type = $this->parent_node->data->key > $key ? 0 : 1;
            $this->tree->deleteChild($this->parent_node, $child_type);
        }
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
