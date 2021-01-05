<?php
/**
 * OrthogonalListGraph.php :
 *
 * PHP version 7.1
 *
 * @category OrthogonalListGraph
 * @package  DataStructure\Graph
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph;

use DataStructure\Graph\Model\Arc\OrthogonalListArc;
use DataStructure\Graph\Model\Vertex\OrthogonalListVerTex;
use Closure;
use Exception;

/**
 *
 * OrthogonalListGraph :十字链表存储(有向图)
 *
 * @category OrthogonalListGraph
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class OrthogonalListGraph extends Graph
{
    /**
     * OrthogonalListGraph constructor.
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
        $index  = $this->locateVex($vertex);
        $vertex = $this->vexs[$index];
        if (!$vertex->first_out) return null;
        return $this->vexs[$vertex->first_out->head_vex]->data;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function nextAdjVex($vertex, $other_vertex)
    {
        $index       = $this->locateVex($vertex);
        $other_index = $this->locateVex($other_vertex);

        $vertex = $this->vexs[$index]->first_out;
        while ($vertex->head_vex !== $other_index) {
            $vertex = $vertex->tail_link;
        }
        if (!$vertex->tail_link) return null;
        return $this->vexs[$vertex->tail_link->head_vex]->data;
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
        $this->vexs[$this->vex_number] = new OrthogonalListVerTex($vertex);
        $this->vex_number++;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deleteVex($vertex)
    {
        $index = $this->locateVex($vertex);

        // 删除顶点的出度和入度
        $out_node = $this->vexs[$index]->first_out;
        while ($out_node) {
            $this->deleteArc($vertex, $this->vexs[$out_node->head_vex]->data);
            $out_node = $out_node->tail_link;
        }
        $in_node = $this->vexs[$index]->first_in;
        while ($in_node) {
            $this->deleteArc($this->vexs[$in_node->tail_vex]->data, $vertex);
            $in_node = $in_node->head_link;
        }

        // 移动顶点，并修改与顶点关联的
        for ($i = $index; $i < $this->vex_number - 1; $i++) {
            $this->vexs[$i] = $this->vexs[$i + 1];
        }
        $this->vex_number--;

        // 修改需要修改的弧结点的弧尾和弧头下标
        for ($i = 0; $i < $this->vex_number; $i++) {
            $node = $this->vexs[$i]->first_out;
            while ($node) {
                if ($node->tail_vex > $index) $node->tail_vex--;
                if ($node->head_vex > $index) $node->head_vex--;
                $node = $node->tail_link;
            }
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function insertArc($triple_arc)
    {
        $tail_index = $this->locateVex($triple_arc->arc_tail);
        $head_index = $this->locateVex($triple_arc->arc_head);

        $arc_node = new OrthogonalListArc($tail_index, $head_index);

        $tail_vertex = $this->vexs[$tail_index];
        $head_vertex = $this->vexs[$head_index];
        // 头插
        $arc_node->tail_link    = $tail_vertex->first_out;
        $arc_node->head_link    = $head_vertex->first_in;
        $tail_vertex->first_out = $arc_node;
        $head_vertex->first_in  = $arc_node;
        $this->arc_number++;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deleteArc($vertex1, $vertex2)
    {
        $tail_index = $this->locateVex($vertex1);
        $head_index = $this->locateVex($vertex2);

        // 出度链删除
        $arc_node = $this->vexs[$tail_index]->first_out;
        if ($arc_node->head_vex === $head_index) {
            $this->vexs[$tail_index]->first_out = $arc_node->tail_link;
        } else {
            while ($arc_node->tail_link->head_vex !== $head_index) {
                $arc_node = $arc_node->tail_link;
            }
            $arc_node->tail_link = $arc_node->tail_link->tail_link;
        }

        // 入度链删除
        $arc_node = $this->vexs[$head_index]->first_in;
        if ($arc_node->tail_vex === $tail_index) {
            $this->vexs[$head_index]->first_in = $arc_node->head_link;
        } else {
            while ($arc_node->head_link->tail_vex !== $head_index) {
                $arc_node = $arc_node->head_link;
            }
            $arc_node->head_link = $arc_node->head_link->head_link;
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
        $arc                      = $this->vexs[$index]->first_out;
        while ($arc) {
            if (!$this->is_visited[$arc->head_vex]) {
                $this->dfs($arc->head_vex, $visit);
            }
            $arc = $arc->tail_link;
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
                $arc  = $this->vexs[$elem]->first_out;
                while ($arc) {
                    if (!$this->is_visited[$arc->head_vex]) {
                        $this->queue->enQueue($arc->head_vex);
                        $visit($arc->head_vex);
                        $this->is_visited[$arc->head_vex] = true;
                    }
                    $arc = $arc->tail_link;
                }
            }

        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function toArray()
    {
        $result_in = array_fill(0, $this->vex_number, array_fill(0, $this->vex_number, 0));
        for ($i = 0; $i < $this->vex_number; $i++) {
            $node = $this->vexs[$i]->first_in;
            while ($node) {
                $result_in[$node->tail_vex][$node->head_vex] = 1;
                $node                                        = $node->head_link;
            }
        }

        $result_out = array_fill(0, $this->vex_number, array_fill(0, $this->vex_number, 0));
        for ($i = 0; $i < $this->vex_number; $i++) {
            $node = $this->vexs[$i]->first_out;
            while ($node) {
                $result_out[$node->tail_vex][$node->head_vex] = 1;
                $node                                         = $node->tail_link;
            }
        }
        if ($result_in !== $result_out) throw new Exception('计算出错');
        return $result_in;
    }
}
