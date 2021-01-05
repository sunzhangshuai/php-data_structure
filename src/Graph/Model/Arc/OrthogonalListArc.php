<?php
/**
 * OrthogonalListArc.php :
 *
 * PHP version 7.1
 *
 * @category OrthogonalListArc
 * @package  DataStructure\Graph\Model\Arc
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model\Arc;


class OrthogonalListArc extends Arc
{
    /**
     * @var int 弧尾下标
     */
    public $tail_vex;

    /**
     * @var int 弧头下标
     */
    public $head_vex;

    /**
     * @var OrthogonalListArc 指向下一个弧尾相同的弧结点
     */
    public $tail_link;

    /**
     * @var OrthogonalListArc 指向下一个弧头相同的弧结点
     */
    public $head_link;

    /**
     * 初始化
     * OrthogonalListArc constructor.
     *
     * @param $tail_vex
     * @param $head_vex
     */
    public function __construct($tail_vex, $head_vex)
    {
        $this->tail_vex = $tail_vex;
        $this->head_vex = $head_vex;
    }
}
