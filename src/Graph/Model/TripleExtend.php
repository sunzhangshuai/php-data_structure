<?php
/**
 * TripleExtend.php :
 *
 * PHP version 7.1
 *
 * @category TripleExtend
 * @package  DataStructure\Graph\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model;

use DataStructure\Graph\Model\Vertex\AdjacentMatrixVertex;

/**
 * TripleExtend : 三元组
 *
 * @category TripleExtend
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class TripleExtend
{
    /**
     * @var string 弧尾
     */
    public $arc_tail;

    /**
     * @var string 弧头
     */
    public $arc_head;

    /**
     * @var int 权重
     */
    public $weight;

    /**
     * TripleExtend constructor.
     *
     * @param $arc_tail
     * @param $arc_head
     * @param $weight
     */
    public function __construct($arc_tail, $arc_head, $weight = 0)
    {
        $this->arc_tail = $arc_tail;
        $this->arc_head = $arc_head;
        $this->weight   = $weight;
    }
}
