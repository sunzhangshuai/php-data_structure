<?php
/**
 * AdjacentListGraph.php :
 *
 * PHP version 7.1
 *
 * @category AdjacentListGraph
 * @package  DataStructure\Graph
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph;

use DataStructure\Graph\Model\Arc\AdjacentListArc;
use DataStructure\Graph\Model\Vertex\AdjacentListVertex;
use Closure;
use Exception;

/**
 * AdjacentListGraph : 邻接表存储（有向图、无向图）
 *
 * @category AdjacentListGraph
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class AdjacentListGraph extends Graph
{
    /**
     * @var int 图的类型
     */
    public $kind;

    /**
     * 初始化
     * AdjacentListGraph constructor.
     *
     * @param $vertexs
     * @param $triple_arcs
     * @param $kind
     *
     * @throws Exception
     */
    public function __construct($vertexs, $triple_arcs, $kind)
    {
        // 设置图的类型
        $this->kind = $kind;
        parent::__construct($vertexs, $triple_arcs);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function firstAdjVex($vertex)
    {
        $index  = $this->locateVex($vertex);
        $vertex = $this->vexs[$index];
        if (!$vertex->first_arc) return null;
        return $this->vexs[$vertex->first_arc->adj_vex]->data;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function nextAdjVex($vertex, $other_vertex)
    {
        $index = $this->locateVex($vertex);
        $arc   = $this->vexs[$index]->first_arc;
        while ($arc) {
            $adj_vex = $arc->adj_vex;
            if ($this->vexs[$adj_vex]->data === $other_vertex) break;
            $arc = $arc->next_arc;
        }
        if (!$arc->next_arc) return null;
        return $this->vexs[$arc->next_arc->adj_vex]->data;
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
        $this->vexs[$this->vex_number] = new AdjacentListVertex($vertex);
        $this->vex_number++;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deleteVex($vertex)
    {
        $tail_index = $this->locateVex($vertex);

        // 计算出度
        $count = 0;
        $arc   = $this->vexs[$tail_index]->first_arc;
        while ($arc) {
            $count++;
            $arc = $arc->next_arc;
        }

        // 移动顶点
        $this->vex_number--;
        for ($i = $tail_index; $i < $this->vex_number; $i++) {
            $this->vexs[$i] = $this->vexs[$i - 1];
        }

        // 变更弧节点的adj_vex并计算出度，删除vertex相应的弧节点
        for ($i = 0; $i < $this->vex_number; $i++) {
            $arc = $this->vexs[$i]->first_arc;
            if (!$arc) continue;
            if ($arc->adj_vex === $tail_index) {
                if ($this->kind === self::DG) {
                    $count++;
                }
                $this->vexs[$i]->first_arc = $arc->next_arc;
                $arc                       = $arc->next_arc;
            }
            if (!$arc) continue;
            while ($arc->next_arc) {
                if ($arc->next_arc->adj_vex === $tail_index) {
                    $arc->next_arc = $arc->next_arc->next_arc;
                    if ($this->kind === self::DG) {
                        $count++;
                    }
                }
                if ($arc->adj_vex > $tail_index) {
                    $arc->adj_vex--;
                }
                $arc = $arc->next_arc;
            }
            if ($arc->adj_vex > $tail_index) {
                $arc->adj_vex--;
            }
        }
        $this->arc_number -= $count;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function insertArc($triple_arc)
    {
        $tail_index = $this->locateVex($triple_arc->arc_tail);
        $head_index = $this->locateVex($triple_arc->arc_head);
        $weight     = $triple_arc->weight;
        switch ($this->kind) {
            case self::UDG:
                $this->insertFirst($head_index, $tail_index, $weight);
            case self::DG:
                $this->insertFirst($tail_index, $head_index, $weight);
                break;
            default:
                break;
        }
        $this->arc_number++;
    }

    /**
     * 通过弧头弧尾实现插入
     *
     * @param $tail_index
     * @param $head_index
     * @param $weight
     */
    public function insertFirst($tail_index, $head_index, $weight)
    {
        $vertex = $this->vexs[$tail_index];
        $arc    = new AdjacentListArc($head_index);
        // 头插
        $arc->next_arc     = $vertex->first_arc;
        $arc->info         = $weight;
        $vertex->first_arc = $arc;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deleteArc($vertex1, $vertex2)
    {
        $tail_index = $this->locateVex($vertex1);
        $head_index = $this->locateVex($vertex2);
        switch ($this->kind) {
            case self::UDG:
                $this->delete($head_index, $tail_index);
            case self::DG:
                $this->delete($tail_index, $head_index);
                break;
            default:
                break;
        }
        $this->arc_number++;
    }

    /**
     * 删除弧节点
     *
     * @param $tail_index
     * @param $head_index
     */
    public function delete($tail_index, $head_index)
    {
        $arc_node = $this->vexs[$tail_index]->first_arc;
        if ($arc_node->adj_vex === $head_index) {
            $this->vexs[$tail_index]->first_arc = $arc_node->next_arc;
        } else {
            while ($arc_node->next_arc !== null && $arc_node->next_arc->adj_vex !== $head_index) {
                $arc_node = $arc_node->next_arc;
            }
            $arc_node->next_arc = $arc_node->next_arc->next_arc;
        }
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
        $arc                      = $this->vexs[$index]->first_arc;
        while ($arc) {
            if (!$this->is_visited[$arc->adj_vex]) {
                $this->dfs($arc->adj_vex, $visit);
            }
            $arc = $arc->next_arc;
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
            // 入队时访问
            $this->queue->enQueue($index);
            $visit($index);
            $this->is_visited[$index] = true;
            while (!$this->queue->queueEmpty()) {
                $elem = $this->queue->deQueue();
                $arc  = $this->vexs[$elem]->first_arc;
                while ($arc) {
                    if (!$this->is_visited[$arc->adj_vex]) {
                        $this->queue->enQueue($arc->adj_vex);
                        $visit($arc->adj_vex);
                        $this->is_visited[$arc->adj_vex] = true;
                    }
                    $arc = $arc->next_arc;
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
        for ($row = 0; $row < $this->vex_number; $row++) {
            $arc = $this->vexs[$row]->first_arc;
            while ($arc) {
                $result[$row][$arc->adj_vex] = 1;
                $arc                         = $arc->next_arc;
            }
        }
        return $result;
    }
}
