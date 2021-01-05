<?php
/**
 * ParentTreeNode.php :
 *
 * PHP version 7.1
 *
 * @category ParentTreeNode
 * @package  DataStructure\Tree\Tree\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\Tree\Model;

/**
 * ParentTreeNode : 树的双亲表示法
 *
 * @category ParentTreeNode
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class ParentTreeNode extends AbstractTreeNode
{
    /**
     * @var int 父节点的下标
     */
    public $parent;

    /**
     * @var
     */
    public $first_child;
}
