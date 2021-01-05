<?php
/**
 * BinaryTreeNode.php :
 *
 * PHP version 7.1
 *
 * @category BinaryTreeNode
 * @package  DataStructure\Tree\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree\Model;

/**
 * LinkedBinaryTreeNode : 二叉树节点
 *
 * @category LinkedBinaryTreeNode
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class BinaryTreeNode extends AbstractBinaryTreeNode
{
    /**
     * @var mixed 数据域
     */
    public $data;

    /**
     * @var BinaryTreeNode 左结点
     */
    public $l_child;

    /**
     * @var BinaryTreeNode 右结点
     */
    public $r_child;
}
