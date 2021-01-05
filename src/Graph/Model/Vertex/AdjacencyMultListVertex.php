<?php
/**
 * AdjacencyMultListVertex.php :
 *
 * PHP version 7.1
 *
 * @category AdjacencyMultListVertex
 * @package  DataStructure\Graph\Model\Vertex
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model\Vertex;


use DataStructure\Graph\Model\Arc\AdjacencyMultListArc;

class AdjacencyMultListVertex extends Vertex
{
    /**
     * @var AdjacencyMultListArc 第一条依附于当前顶点的边
     */
    public $first_edge;
}
