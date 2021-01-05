<?php
/**
 * AdjacencyMultListGraph.php :
 *
 * PHP version 7.1
 *
 * @category AdjacencyMultListGraph
 * @package  DataStructure\Graph
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph;

use DataStructure\Graph\Model\Arc\AdjacencyMultListArc;
use DataStructure\Graph\Model\Vertex\AdjacencyMultListVertex;
use Closure;
use Exception;

/**
 * AdjacencyMultListGraph : 邻接多重表存储（无向图）
 *
 * @category AdjacencyMultListGraph
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class AdjacencyMultListGraph extends Graph implements Interfaces\GraphInterface
{

    /**
     * @var int 边的个数
     */
    public $arc_number;

    /**
     * 初始化
     * AdjacencyMultListGraph constructor.
     *
     * @param $vertexs
     * @param $triple_arcs
     *
     * @throws Exception
     */
    public function __construct($vertexs, $triple_arcs)
    {
        parent::__construct($vertexs, $triple_arcs);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function firstAdjVex($vertex)
    {
        $index = $this->locateVex($vertex);
        $edge  = $this->vexs[$index]->first_edge;
        if (!$edge) return null;
        return $this->vexs[$this->getAdjVex($edge, $index)]->data;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function nextAdjVex($vertex, $other_vertex)
    {
        $index       = $this->locateVex($vertex);
        $other_index = $this->locateVex($other_vertex);

        $edge = $this->vexs[$index]->first_edge;
        while ($this->getAdjVex($edge, $index) !== $other_index) {
            $edge = $this->getNextEdge($edge, $index);
        }
        $edge = $this->getNextEdge($edge, $index);
        if (!$edge) return null;
        return $this->vexs[$this->getAdjVex($edge, $index)]->data;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function insertVex($vertex)
    {
        if ($this->vex_number === self::MAX_VERTEX_NUM) {
            throw new Exception('顶点已满，无法添加');
        }
        $this->vexs[$this->vex_number] = new AdjacencyMultListVertex($vertex);
        $this->vex_number++;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deleteVex($vertex)
    {
        $index = $this->locateVex($vertex);

        // 删除相关弧
        $edge = $this->vexs[$index]->first_edge;
        while ($edge) {
            $this->deleteArc($vertex, $this->vexs[$this->getAdjVex($edge, $index)]->data);
            $edge = $this->getNextEdge($edge, $index);
        }

        // 移动顶点，并修改与顶点关联的
        for ($i = $index; $i < $this->vex_number - 1; $i++) {
            $this->vexs[$i] = $this->vexs[$i + 1];
        }
        $this->vex_number--;

        // 修改需要修改的弧结点的弧尾和弧头下标
        for ($i = 0; $i < $this->vex_number; $i++) {
            $edge = $this->vexs[$i]->first_edge;
            while ($edge) {
                if ($edge->mark === 0) {
                    if ($edge->i_vex > $index) $edge->i_vex--;
                    if ($edge->j_vex > $index) $edge->j_vex--;
                    $edge->mark = 1;
                }
                $edge = $this->getNextEdge($edge, $i);
            }
        }
        $this->initMark();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function insertArc($triple_arc)
    {
        $i_index = $this->locateVex($triple_arc->arc_tail);
        $j_index = $this->locateVex($triple_arc->arc_head);

        $edge = new AdjacencyMultListArc($i_index, $j_index);

        $i_vertex = $this->vexs[$i_index];
        $j_vertex = $this->vexs[$j_index];
        // 头插
        $edge->i_link         = $i_vertex->first_edge;
        $edge->j_link         = $j_vertex->first_edge;
        $i_vertex->first_edge = $edge;
        $j_vertex->first_edge = $edge;
        $this->arc_number++;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deleteArc($vertex1, $vertex2)
    {
        $i_index = $this->locateVex($vertex1);
        $j_index = $this->locateVex($vertex2);

        // i链删除
        $i_edge = $this->vexs[$i_index]->first_edge;
        if ($this->getAdjVex($i_edge, $i_index) === $j_index) {
            $this->vexs[$i_index]->first_edge = $this->getNextEdge($i_edge, $i_index);
        } else {
            while ($this->getAdjVex($this->getNextEdge($i_edge, $i_index), $i_index) !== $j_index) {
                $i_edge = $this->getNextEdge($i_edge, $i_index);
            }
            $this->deleteAfterEdge($i_edge, $i_index);
        }

        // j链删除
        $j_edge = $this->vexs[$j_index]->first_edge;
        if ($this->getAdjVex($j_edge, $j_index) === $i_index) {
            $this->vexs[$j_index]->first_edge = $this->getNextEdge($j_edge, $j_index);
        } else {
            while ($this->getAdjVex($this->getNextEdge($j_edge, $j_index), $j_index) !== $i_index) {
                $j_edge = $this->getNextEdge($j_edge, $j_index);
            }
            $this->deleteAfterEdge($j_edge, $j_index);
        }
        $this->arc_number--;
    }

    /**
     * @inheritDoc
     */
    public function DFSTraverse(Closure $visit)
    {
        $this->is_visited = array_fill(0, $this->vex_number, false);
        for ($i = 0; $i < $this->vex_number; $i++) {
            if (!$this->is_visited[$i]) {
                $this->dfs($i, $visit);
            }
        }
    }

    /**
     * 深度优先遍历递归部分
     *
     * @param         $index
     * @param Closure $visit
     */
    public function dfs($index, Closure $visit)
    {
        $visit($index);
        $this->is_visited[$index] = true;
        $edge                     = $this->vexs[$index]->first_edge;
        while ($edge) {
            $adj_vex = $this->getAdjVex($edge, $index);
            if (!$this->is_visited[$adj_vex]) {
                $this->dfs($adj_vex, $visit);
            }
            $edge = $this->getNextEdge($edge, $index);
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function BFSTraverse(Closure $visit)
    {
        $this->is_visited = array_fill(0, $this->vex_number, false);
        $this->queue->clearQueue();
        for ($index = 0; $index < $this->vex_number; $index++) {
            if ($this->is_visited[$index]) continue;
            $this->queue->enQueue($index);
            $visit($index);
            $this->is_visited[$index] = true;

            while (!$this->queue->queueEmpty()) {
                $elem = $this->queue->deQueue();

                $edge = $this->vexs[$elem]->first_edge;
                while ($edge) {
                    $adj_vex = $this->getAdjVex($edge, $index);
                    if (!$this->is_visited[$adj_vex]) {
                        $this->queue->enQueue($adj_vex);
                        $visit($adj_vex);
                        $this->is_visited[$adj_vex] = true;
                    }
                    $edge = $this->getNextEdge($edge, $index);
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $result = array_fill(0, $this->vex_number, array_fill(0, $this->vex_number, 0));
        for ($i = 0; $i < $this->vex_number; $i++) {
            $edge = $this->vexs[$i]->first_edge;
            while ($edge) {
                $result[$i][$this->getAdjVex($edge, $i)] = 1;
                $edge                                    = $this->getNextEdge($edge, $i);
            }
        }
        return $result;
    }

    /**
     * 获取下一条边
     *
     * @param AdjacencyMultListArc $edge  边
     * @param int                  $index 参照顶点下标
     *
     * @return AdjacencyMultListArc
     */
    private function getNextEdge($edge, $index)
    {
        return $edge->i_vex === $index ? $edge->i_link : $edge->j_link;
    }

    /**
     * 获取邻接点
     *
     * @param AdjacencyMultListArc $edge  边
     * @param int                  $index 参照顶点下标
     *
     * @return int
     */
    private function getAdjVex($edge, $index)
    {
        return $edge->i_vex === $index ? $edge->j_vex : $edge->i_vex;
    }

    /**
     * 删除下一条邻接边
     *
     * @param AdjacencyMultListArc $edge  边
     * @param int                  $index 参照顶点下标
     */
    private function deleteAfterEdge($edge, $index)
    {
        $edge->i_vex === $index ?
            $edge->i_link = $this->getNextEdge($this->getNextEdge($edge, $index), $index) :
            $edge->j_link = $this->getNextEdge($this->getNextEdge($edge, $index), $index);
    }

    /**
     * 初始化mark
     */
    private function initMark()
    {
        for ($i = 0; $i < $this->vex_number; $i++) {
            $edge = $this->vexs[$i]->first_edge;
            while ($edge) {
                $edge->mark = 0;
                $edge       = $this->getNextEdge($edge, $i);
            }
        }
    }
}
