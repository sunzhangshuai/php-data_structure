<?php
/**
 * ClueBinaryTreeNode.php :
 *
 * PHP version 7.1
 *
 * @category ClueBinaryTreeNode
 * @package  DataStructure\Tree\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree\Model;

/**
 * ClueBinaryTreeNode : 线索二叉树节点
 *
 * @category ClueBinaryTreeNode
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class ClueBinaryTreeNode extends AbstractBinaryTreeNode
{
    /**
     * @var int 左标识
     */
    public $l_tag;

    /**
     * @var int 右标识
     */
    public $r_tag;

    /**
     * ClueBinaryTreeNode constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
    }
}
