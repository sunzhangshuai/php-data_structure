<?php
/**
 * OrthogonalListVerTex.php :
 *
 * PHP version 7.1
 *
 * @category OrthogonalListVerTex
 * @package  DataStructure\Graph\Model\Vertex
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model\Vertex;


use DataStructure\Graph\Model\Arc\OrthogonalListArc;

class OrthogonalListVerTex extends Vertex
{
    /**
     * @var OrthogonalListArc 第一个入度弧节点
     */
    public $first_in;

    /**
     * @var OrthogonalListArc 第一个出度弧节点
     */
    public $first_out;
}
