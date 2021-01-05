<?php
/**
 * SkipLevelNode.php :
 *
 * PHP version 7.1
 *
 * @category SkipLevelNode
 * @package  DataStructure\Lists\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists\Model;


class SkipLevelNode
{
    /**
     * @var SkipNode 前进指针
     */
    public $forward;

    /**
     * @var int 跨度
     */
    public $span = 200000;
}
