<?php
/**
 * BalanceBinaryTreeNode.php :
 *
 * PHP version 7.1
 *
 * @category BalanceBinaryTreeNode
 * @package  DataStructure\Tree\BinaryTree\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree\Model;

/**
 * BalanceBinaryTreeNode : 平衡二叉树的节点
 *
 * @category BalanceBinaryTreeNode
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class BalanceBinaryTreeNode extends BinaryTreeNode
{
    /**
     * 1 左高，0 一样高， -1 右高
     */
    const LH = 1;
    const EH = 0;
    const RH = -1;

    /**
     * @var mixed 数据域
     */
    public $data;

    /**
     * @var BalanceBinaryTreeNode 左结点
     */
    public $l_child;

    /**
     * @var BalanceBinaryTreeNode 右结点
     */
    public $r_child;

    /**
     * @var int 平衡因子
     */
    public $balance_factor;

    /**
     * @param BalanceBinaryTreeNode $node
     */
    public function copyTo($node)
    {
        $this->data    = $node->data;
        $this->l_child = $node->l_child;
        $this->r_child = $node->r_child;
    }
}
