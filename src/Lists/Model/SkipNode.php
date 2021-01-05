<?php
/**
 * SkipNode.php :
 *
 * PHP version 7.1
 *
 * @category SkipNode
 * @package  DataStructure\Lists\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists\Model;


class SkipNode
{
    /**
     * @var SkipLevelNode[] 层
     */
    public $level;

    /**
     * @var SkipNode 后退指针
     */
    public $backword;

    /**
     * @var float 分数
     */
    public $score;

    /**
     * @var string 数据
     */
    public $data;
}
