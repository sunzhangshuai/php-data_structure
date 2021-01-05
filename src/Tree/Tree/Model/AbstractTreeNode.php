<?php
/**
 * AbstractTreeNode.php :
 *
 * PHP version 7.1
 *
 * @category AbstractTreeNode
 * @package  DataStructure\Tree\Tree\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\Tree\Model;

/**
 * AbstractTreeNode : 树的抽象类
 *
 * @category AbstractTreeNode
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class AbstractTreeNode
{
    /**
     * @var mixed
     */
    public $data;

    /**
     * 初始化
     * AbstractTreeNode constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
