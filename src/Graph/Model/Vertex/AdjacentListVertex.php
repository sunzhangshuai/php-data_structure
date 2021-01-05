<?php
/**
 * AdjacentListVertex.php :
 *
 * PHP version 7.1
 *
 * @category AdjacentListVertex
 * @package  DataStructure\Graph\Model\Vertex
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model\Vertex;

use DataStructure\Graph\Model\Arc\AdjacentListArc;

class AdjacentListVertex extends Vertex
{
    /**
     * 第一个邻接点
     *
     * @var AdjacentListArc
     */
    public $first_arc;
}
