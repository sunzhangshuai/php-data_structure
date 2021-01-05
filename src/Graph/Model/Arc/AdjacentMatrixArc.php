<?php
/**
 * AdjacentMatrixArc.php :
 *
 * PHP version 7.1
 *
 * @category AdjacentMatrixArc
 * @package  DataStructure\Graph\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model\Arc;


class AdjacentMatrixArc extends Arc
{
    /**
     * 顶点关系类型
     * 图：用0huo1表示是否相邻
     * 网：权值类型，不相临为∞
     *
     * @var int
     */
    public $adj;

    /**
     * AdjacentMatrixArc constructor.
     *
     * @param $adj
     */
    public function __construct($adj)
    {
        $this->adj = $adj;
    }
}
