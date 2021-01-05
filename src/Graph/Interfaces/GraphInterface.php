<?php
/**
 * GraphInterface.php :
 *
 * PHP version 7.1
 *
 * @category GraphInterface
 * @package  DataStructure\Graph\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Interfaces;


use DataStructure\Graph\Model\TripleExtend;
use DataStructure\Graph\Model\Vertex\OrthogonalListVerTex;
use DataStructure\Graph\Model\Vertex\Vertex;
use Closure;

interface GraphInterface
{
    /**
     * vertex顶点在图中的位置（下标）
     *
     * @param string $vertex
     *
     * @return int
     */
    public function locateVex($vertex);

    /**
     * 获取顶点vertex的值
     *
     * @param Vertex $vertex
     *
     * @return string
     */
    public function getVex($vertex);

    /**
     * 给顶点vertex赋值
     *
     * @param string $vertex
     * @param string $value
     */
    public function putVex($vertex, $value);

    /**
     * 获取vertex的第一个邻接顶点
     *
     * @param string $vertex
     *
     * @return string
     */
    public function firstAdjVex($vertex);

    /**
     * 返回vertex1相对于vertex2的下一个邻接顶点，若vertex2是vertex1的最后一个邻接顶点，则返回null
     *
     * @param string $vertex
     * @param string $other_vertex
     *
     * @return string
     */
    public function nextAdjVex($vertex, $other_vertex);

    /**
     * 在图中添加新顶点vertex
     *
     * @param string $vertex
     */
    public function insertVex($vertex);

    /**
     * 删除顶点vertex和其相关的弧
     *
     * @param string $vertex
     */
    public function deleteVex($vertex);

    /**
     * 添加弧，考虑有向、无向
     *
     * @param TripleExtend $triple_arc
     */
    public function insertArc($triple_arc);

    /**
     * 删除弧，考虑有向、无向
     *
     * @param string $vertex1
     * @param string $vertex2
     */
    public function deleteArc($vertex1, $vertex2);

    /**
     * 深度优先遍历
     *
     * @param Closure $visit
     */
    public function DFSTraverse(Closure $visit);

    /**
     * 广度优先遍历
     *
     * @param Closure $visit
     */
    public function BFSTraverse(Closure $visit);

    /**
     * 输出数组
     *
     * @return array
     */
    public function toArray();
}
