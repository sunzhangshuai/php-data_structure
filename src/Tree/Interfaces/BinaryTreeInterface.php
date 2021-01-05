<?php
/**
 * BinaryTreeInterface.php :
 *
 * PHP version 7.1
 *
 * @category BinaryTreeInterface
 * @package  DataStructure\Tree\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\Interfaces;

use DataStructure\Tree\BinaryTree\Model\BinaryTreeNode;
use Closure;

interface BinaryTreeInterface
{
    /**
     * 初始化二叉树
     *
     * BinaryTreeInterface constructor.
     *
     * @param int[] $array
     */
    public function __construct($array);

    /**
     * 清空树
     */
    public function clearBiTree();

    /**
     * 判断树是否为空
     *
     * @return boolean
     */
    public function BiTreeEmpty();

    /**
     * 获取树的深度
     *
     * @return int
     */
    public function biTreeDepth();

    /**
     * 返回树的根节点
     *
     * @return BinaryTreeNode
     */
    public function root();

    /**
     * node是二叉树的一个节点，返回node节点的值
     *
     * @param BinaryTreeNode $node
     *
     * @return mixed
     */
    public function value($node);

    /**
     * node是二叉树的一个节点，给node节点赋值为value
     *
     * @param BinaryTreeNode $node
     * @param mixed                $value
     */
    public function assign($node, $value);

    /**
     * node是二叉树的一个节点，返回node节点的双亲
     *
     * @param BinaryTreeNode $node
     *
     * @return BinaryTreeNode
     */
    public function parent($node);

    /**
     * node是二叉树的一个节点，返回node节点的左孩子
     *
     * @param BinaryTreeNode $node
     *
     * @return BinaryTreeNode
     */
    public function leftChild($node);

    /**
     * node是二叉树的一个节点，返回node节点的右孩子
     *
     * @param BinaryTreeNode $node
     *
     * @return BinaryTreeNode
     */
    public function rightChild($node);

    /**
     * node是二叉树的一个节点，返回node节点的左兄弟
     *
     * @param BinaryTreeNode $node
     *
     * @return BinaryTreeNode
     */
    public function leftSibling($node);

    /**
     * node是二叉树的一个节点，返回node节点的右兄弟
     *
     * @param BinaryTreeNode $node
     *
     * @return BinaryTreeNode
     */
    public function rightSibling($node);

    /**
     * node是二叉树的一个节点
     * child_type为0，将c作为node的左子树，child_type为1，将c作为node的右子树
     * node的原左子树或右子树变为new_node的右子树
     *
     * @param BinaryTreeNode $node
     * @param int                  $child_type
     * @param BinaryTreeNode $new_node
     */
    public function insertChild($node, $child_type, $new_node);

    /**
     * node是二叉树的一个节点
     * child_type为0，删除node的左子树，child_type为1，删除node的右子树
     *
     * @param BinaryTreeNode $node
     * @param int                  $child_type
     *
     * @return BinaryTreeNode
     */
    public function deleteChild($node, $child_type);

    /**
     * 先序遍历
     *
     * @param Closure $visit
     */
    public function preOrderTraverse(Closure $visit);

    /**
     * 中序遍历
     *
     * @param Closure $visit
     */
    public function inOrderTraverse(Closure $visit);

    /**
     * 后序遍历
     *
     * @param Closure $visit
     */
    public function postOrderTraverse(Closure $visit);

    /**
     * 层序遍历
     *
     * @param Closure $visit
     */
    public function levelOrderTraverse(Closure $visit);
}
