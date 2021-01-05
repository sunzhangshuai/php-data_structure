<?php
/**
 * AdjacentListArc.php :
 *
 * PHP version 7.1
 *
 * @category AdjacentListArc
 * @package  DataStructure\Graph\Model\Arc
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model\Arc;


class AdjacentListArc extends Arc
{
    /**
     * 下一个弧
     *
     * @var AdjacentListArc
     */
    public $next_arc;

    /**
     * @var int 邻接点下标
     */
    public $adj_vex;

    /**
     * @var int 弧的其他信息
     */
    public $info;

    /**
     * AdjacentMatrixArc constructor.
     *
     * @param $adj_vex
     */
    public function __construct($adj_vex)
    {
        $this->adj_vex = $adj_vex;
    }
}
