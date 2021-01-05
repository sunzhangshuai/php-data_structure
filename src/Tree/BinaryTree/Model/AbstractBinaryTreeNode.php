<?php
/**
 * AbstractBinaryTreeNode.php :
 *
 * PHP version 7.1
 *
 * @category Ab
 * @package  DataStructure\Tree\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree\Model;

/**
 * AbstractBinaryTreeNode : 二叉树节点基类
 *
 * @category AbstractBinaryTreeNode
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class AbstractBinaryTreeNode
{
    /**
     * @var mixed 数据域
     */
    public $data;

    /**
     * BinaryTreeNode constructor.
     *
     * @param        $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
