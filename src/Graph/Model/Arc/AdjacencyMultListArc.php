<?php
/**
 * AdjacencyMultListArc.php :
 *
 * PHP version 7.1
 *
 * @category AdjacencyMultListArc
 * @package  DataStructure\Graph\Model\Arc
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model\Arc;


class AdjacencyMultListArc extends Arc
{
    /**
     * @var int 标志域
     */
    public $mark;

    /**
     * @var int 第一个顶点
     */
    public $i_vex;

    /**
     * @var AdjacencyMultListArc 下一条依附于i顶点的边
     */
    public $i_link;

    /**
     * @var int 第二个顶点
     */
    public $j_vex;

    /**
     * @var AdjacencyMultListArc 下一条依附于j顶点的边
     */
    public $j_link;

    /**
     * 初始化
     * OrthogonalListArc constructor.
     *
     * @param int $i_vex
     * @param int $j_vex
     */
    public function __construct($i_vex, $j_vex)
    {
        $this->i_vex = $i_vex;
        $this->j_vex = $j_vex;
    }
}
