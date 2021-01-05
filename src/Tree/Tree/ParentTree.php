<?php
/**
 * ParentTree.php :
 *
 * PHP version 7.1
 *
 * @category ParentTree
 * @package  DataStructure\Tree\Tree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\Tree;

use DataStructure\Tree\Tree\Model\ParentTreeNode;
use Closure;
use Exception;

class ParentTree extends AbstractTree
{
    /**
     * 树的最大容量
     */
    const MAX_TREE_SIZE = 100;

    /**
     * @var ParentTreeNode[] 树结点数组
     */
    public $nodes;

    /**
     * 根的位置
     */
    public $root_index;

    /**
     * 已使用的结点数
     */
    public $length;

    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $this->root_index = -1;
        $this->length     = 0;
        $this->nodes      = array_fill(0, self::MAX_TREE_SIZE, null);
    }

    /**
     * @inheritDoc
     */
    public function treeDepth()
    {
        if ($this->root_index === -1) {
            return 0;
        }
        return $this->depth($this->root_index);
    }

    /**
     * 获取树的深度
     *
     * @param int $index
     *
     * @return int
     */
    public function depth($index)
    {
        $children = $this->getChildren($index);
        if (!count($children)) {
            return 1;
        }
        $max = 0;
        foreach ($children as $child) {
            $depth = $this->depth($child);
            if ($depth > $max) {
                $max = $depth;
            }
        }
        return $max + 1;
    }

    /**
     * @inheritDoc
     */
    public function root()
    {
        if ($this->root_index === -1) {
            return null;
        }
        return $this->nodes[$this->root_index];
    }

    /**
     * @param ParentTreeNode $node
     *
     * @inheritDoc
     * @throws Exception
     */
    public function parent($node)
    {
        if ($node->parent === -1) {
            throw new Exception('没有父节点');
        }
        return $this->nodes[$node->parent];
    }

    /**
     * @inheritDoc
     *
     * @param ParentTreeNode $node
     *
     * @throws Exception
     */
    public function leftChild($node)
    {
        $children = $this->getChildren($this->locate($node));
        if (count($children) === 0) {
            return null;
        }
        return $this->nodes[$children[0]];
    }

    /**
     * @inheritDoc
     *
     * @param ParentTreeNode $node
     */
    public function rightSibling($node)
    {
        if ($node->parent === -1) {
            return null;
        }
        $children = $this->getChildren($node->parent);
        $index    = 0;
        foreach ($children as $key => $child) {
            if ($this->nodes[$child] === $node) {
                $index = $key;
                break;
            }
        }
        return $this->nodes[$children[$index + 1]];
    }

    /**
     * @inheritDoc
     *
     * @param ParentTreeNode $node
     * @param ParentTreeNode $new_node
     *
     * @throws Exception
     */
    public function insertChild($node, $index, $new_node)
    {
        // 如果满了，需要清除垃圾
        $nodes = array_fill(0, self::MAX_TREE_SIZE, null);
        if ($this->length === self::MAX_TREE_SIZE) {
            $this->length     = 0;
            $this->root_index = -1;
            if (!$this->treeEmpty()) {
                $this->root_index = 0;
                $this->collection($this->root_index, $this->length, $nodes);
            }
            $this->nodes = $nodes;
        }

        if ($this->length === self::MAX_TREE_SIZE) {
            throw new Exception('树已满，无法继续插入');
        }

        $children = $this->getChildren($this->locate($node));
        if (count($children) + 1 < $index || $index < 1) {
            throw new Exception("index位置不合法");
        }
        $after_index = $this->length;
        for ($i = count($children); $i >= $index; $i--) {
            $grandchildren = $this->getChildren($children[$i]);
            foreach ($grandchildren as $grandchild) {
                $this->nodes[$grandchild]->parent = $after_index;
            }
            $this->nodes[$after_index] = $this->nodes[$children[$i]];
        }
        $this->nodes[$children[$index]] = $new_node;
        $new_node->parent               = $node;
        $this->length++;
    }

    /**
     * @inheritDoc
     *
     * @param ParentTreeNode $node
     *
     * @throws Exception
     */
    public function deleteChild($node, $index)
    {
        $children                                   = $this->getChildren($this->locate($node));
        $this->nodes[$children[$index - 1]]->parent = -1;
        return $this->nodes[$children[$index - 1]];
    }

    /**
     * @inheritDoc
     */
    public function preTraverseTree(Closure $visit)
    {
        if ($this->root() === null) {
            return;
        }
        $this->preTraverse($this->root_index, $visit);
    }

    /**
     * 先根遍历
     *
     * @param int     $index
     * @param Closure $visit
     */
    protected function preTraverse($index, Closure $visit)
    {
        $visit($this->nodes[$index]->data);
        $children = $this->getChildren($index);
        foreach ($children as $child) {
            $this->preTraverse($child, $visit);
        }
    }

    /**
     * @inheritDoc
     */
    public function postTraverseTree(Closure $visit)
    {
        if ($this->root() === null) {
            return;
        }
        $this->postTraverse($this->root_index, $visit);
    }

    /**
     * 后根遍历
     *
     * @param int     $index
     * @param Closure $visit
     */
    protected function postTraverse($index, Closure $visit)
    {
        $children = $this->getChildren($index);
        foreach ($children as $child) {
            $this->postTraverse($child, $visit);
        }
        $visit($this->nodes[$index]->data);
    }

    /**
     * 获取所有孩子的下标
     *
     * @param int $index
     *
     * @return int[]
     */
    protected function getChildren($index)
    {
        $result = [];
        for ($i = 0; $i < $this->length; $i++) {
            if ($this->nodes[$i]->parent == $index) {
                $result[] = $i;
            }
        }
        return $result;
    }

    /**
     * 获取node结点的位置
     *
     * @param ParentTreeNode $node
     *
     * @return int
     * @throws Exception
     */
    protected function locate($node)
    {
        for ($i = 0; $i < $this->length; $i++) {
            if ($this->nodes[$i] == $node) {
                return $i;
            }
        }
        throw new Exception('结点没有找到');
    }

    /**
     * 垃圾回收
     *
     * @param int              $index
     * @param int              $parent_index
     * @param ParentTreeNode[] $nodes
     */
    protected function collection($index, $parent_index, &$nodes)
    {
        $this->length++;
        $nodes[$this->length]->data   = $this->nodes[$index]->data;
        $nodes[$this->length]->parent = $parent_index;

        $children = $this->getChildren($index);
        foreach ($children as $child) {
            $this->collection($child, $index, $nodes);
        }
    }
}
