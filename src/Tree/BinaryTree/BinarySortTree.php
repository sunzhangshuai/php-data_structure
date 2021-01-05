<?php
/**
 * BinarySortTree.php :
 *
 * PHP version 7.1
 *
 * @category BinarySortTree
 * @package  DataStructure\Tree\BinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree;

use DataStructure\Tree\BinaryTree\Model\BinaryTreeNode;

/**
 * BinarySortTree : 二叉排序树
 *
 * @category BinarySortTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class BinarySortTree extends BinaryTree
{
    /**
     * @var int 删除方法：1，2，3
     */
    public $delete_method = 1;

    /**
     * 初始化
     * BinarySortTree constructor.
     *
     * @param array $array
     */
    public function __construct($array = [])
    {
        $this->root = null;
    }

    /**
     * 设置根节点
     *
     * @param $node
     */
    public function setRoot($node)
    {
        $this->root = $node;
    }

    /**
     * @inheritDoc
     */
    public function insertChild($node, $child_type, $new_node)
    {
        $child_type == 0 ? $node->l_child = $new_node : $node->r_child = $new_node;
    }

    /**
     * 删除根节点
     */
    public function deleteRoot()
    {
        $this->root = $this->deleteNode($this->root());
    }

    /**
     * @inheritDoc
     */
    public function deleteChild($node, $child_type)
    {
        $child_node = $child_type === 0 ? $node->l_child : $node->r_child;
        $child_type === 0 ? $node->l_child = $this->deleteNode($child_node) : $node->r_child = $this->deleteNode($child_node);
        return $child_node;
    }

    /**
     * 删除节点方法1
     * 要删除节点的左子树替代自己，要删除节点的右子树成为节点前驱的右子树
     *
     * @param BinaryTreeNode $node
     *
     * @return BinaryTreeNode|null
     */
    public function deleteNode($node)
    {
        if ($node === null) {// 1. 要删除的节点为空
            return null;
        } elseif (!$node->r_child) {// 2. 没有右孩子
            return $node->l_child;
        } elseif (!$node->l_child) {// 3. 没有左孩子
            return $node->r_child;
        } else {// 4.有左右孩子
            switch ($this->delete_method) {
                case 1:
                    return $this->delete1($node);
                case 2:
                    return $this->delete2($node);
                case 3:
                    return $this->delete3($node);
                default:
                    return null;
            }
        }
    }

    /**
     * 删除节点方法1
     * 要删除节点的左子树替代自己，要删除节点的右子树成为节点前驱的右子树
     *
     * @param BinaryTreeNode $node
     *
     * @return BinaryTreeNode
     */
    public function delete1($node)
    {
        // 找前驱节点
        $pre = $node->l_child;
        while ($pre->r_child) {
            $pre = $pre->r_child;
        }
        $pre->r_child = $node->r_child;
        return $node->l_child;
    }

    /**
     * 删除节点方法2
     * 要删除节点的前驱替代自己，前驱节点的父节点的右指针指向前驱的左结点
     *
     * @param BinaryTreeNode $node
     *
     * @return BinaryTreeNode
     */
    public function delete2($node)
    {
        // 找前驱节点，顺带找到前驱节点的父节点
        $pre_parent = $node;
        $pre        = $node->l_child;
        while ($pre->r_child) {
            $pre_parent = $pre;
            $pre        = $pre->r_child;
        }
        // 如果前驱的父节点是要删除的节点
        if ($pre_parent === $node) {
            return $node->l_child;
        }
        // 前驱节点的父节点的右指针指向前驱的左结点
        $pre_parent->r_child = $pre->l_child;
        // 前驱替代要删除的节点
        $pre->l_child = $node->l_child;
        $pre->r_child = $node->r_child;
        return $pre;
    }

    /**
     * 删除节点方法3
     * 要删除节点的后继替代自己，后继节点的父节点的左指针指向后继的右结点
     *
     * @param BinaryTreeNode $node
     *
     * @return BinaryTreeNode
     */
    public function delete3($node)
    {
        // 找后继节点，顺带找到后继节点的父节点
        $next_parent = $node;
        $next        = $node->r_child;
        while ($next->l_child) {
            $next_parent = $next;
            $next        = $next->l_child;
        }
        // 如果后继的父节点是要删除的节点
        if ($next_parent === $node) {
            return $node->r_child;
        }
        // 后继节点的父节点的左指针指向后继的右结点
        $next_parent->l_child = $next->r_child;
        // 前驱替代要删除的节点
        $next->l_child = $node->l_child;
        $next->r_child = $node->r_child;
        return $next;
    }
}
