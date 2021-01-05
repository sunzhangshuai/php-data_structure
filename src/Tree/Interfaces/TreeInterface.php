<?php
/**
 * TreeInterface.php :
 *
 * PHP version 7.1
 *
 * @category TreeInterface
 * @package  DataStructure\Tree\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\Interfaces;

use DataStructure\Tree\Tree\Model\AbstractTreeNode;
use Closure;

/**
 * 树的接口实现
 * Interface TreeInterface
 *
 * @package DataStructure\Tree\Interfaces
 */
interface TreeInterface
{
    /**
     * 初始化
     * TreeInterface constructor.
     */
    public function __construct();

    /**
     * 树是否为空
     *
     * @return boolean
     */
    public function treeEmpty();

    /**
     * 树的深度
     *
     * @return int
     */
    public function treeDepth();

    /**
     * 树的根节点
     *
     * @return AbstractTreeNode
     */
    public function root();

    /**
     * 获取node节点的值域
     *
     * @param AbstractTreeNode $node
     *
     * @return mixed
     */
    public function value($node);

    /**
     * 将node节点的值域赋值为data
     *
     * @param AbstractTreeNode $node
     * @param mixed            $data
     */
    public function assign($node, $data);

    /**
     * 获取node节点的父节点
     *
     * @param $node
     *
     * @return AbstractTreeNode
     */
    public function parent($node);

    /**
     * 获取node节点最左边的孩子
     *
     * @param AbstractTreeNode $node
     *
     * @return AbstractTreeNode
     */
    public function leftChild($node);

    /**
     * 获取node节点的右兄弟
     *
     * @param AbstractTreeNode $node
     *
     * @return AbstractTreeNode
     */
    public function rightSibling($node);

    /**
     * 在node节点的第index位置插入new_node节点
     *
     * @param AbstractTreeNode $node
     * @param int              $index
     * @param AbstractTreeNode $new_node
     *
     * @return mixed
     */
    public function insertChild($node, $index, $new_node);

    /**
     * 删除node节点第i棵子树
     *
     * @param AbstractTreeNode $node
     * @param int              $index
     */
    public function deleteChild($node, $index);

    /**
     * 先根遍历
     *
     * @param Closure $visit
     */
    public function preTraverseTree(Closure $visit);

    /**
     * 后跟遍历
     *
     * @param Closure $visit
     */
    public function postTraverseTree(Closure $visit);
}
