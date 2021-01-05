<?php
/**
 * GeneralizedNode.php :
 *
 * PHP version 7.1
 *
 * @category GeneralizedNode
 * @package  DataStructure\GeneralizedList\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\GeneralizedList\Model;


use DataStructure\GeneralizedList\ExtendGeneralizedList;
use DataStructure\GeneralizedList\GeneralizedList;

class GeneralizedNode
{
    /**
     * @var int 用于区分原子节点和表结点
     */
    public $tag;

    /**
     * @var mixed 原子节点的值域
     */
    public $atom;

    /**
     * @var GeneralizedList|ExtendGeneralizedList 表头
     */
    public $hp;

    /**
     * @var GeneralizedList|ExtendGeneralizedList 表尾
     */
    public $tp;
}
