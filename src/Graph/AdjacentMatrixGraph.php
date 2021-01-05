<?php
/**
 * AdjacentMatrixGraph.php :
 *
 * PHP version 7.1
 *
 * @category AdjacentMatrixGraph
 * @package  DataStructure\Graph
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph;

use DataStructure\Graph\Model\Arc\AdjacentMatrixArc;
use DataStructure\Graph\Model\Vertex\AdjacentMatrixVertex;
use Closure;
use Exception;

/**
 *
 * AdjacentMatrixGraph : 邻接矩阵存储（有向图、无向图、有向网、无向网）
 *
 * @category AdjacentMatrixGraph
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class AdjacentMatrixGraph extends Graph
{
    /**
     * @var AdjacentMatrixArc[][] 弧
     */
    public $arcs;

    /**
     * @var int 图的类型
     */
    public $kind;

    /**
     * 邻接矩阵
     * AdjacentMatrixGraph constructor.
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
        $this->arcs = array_fill(0, self::MAX_VERTEX_NUM, array_fill(0, self::MAX_VERTEX_NUM, null));

        parent::__construct($vertexs, $triple_arcs);
    }

    /**
     * 根据位置初始化弧
     *
     * @param int $row
     * @param int $col
     */
    private function initArcByLocate($row, $col)
    {
        switch ($this->kind) {
            case self::DG:
            case self::UDG:
                $this->arcs[$row][$col] = new AdjacentMatrixArc(0);
                break;
            case self::DN:
            case self::UDN:
                if ($row === $col) {
                    $this->arcs[$row][$col] = new AdjacentMatrixArc(0);
                } else {
                    $this->arcs[$row][$col] = new AdjacentMatrixArc(PHP_INT_MAX);
                }

                break;
            default:
                break;
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function firstAdjVex($vertex)
    {
        $row = $this->locateVex($vertex);
        return $this->getNextAdjVexByLocate($row, 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function nextAdjVex($vertex1, $vertex2)
    {
        $row = $this->locateVex($vertex1);
        $col = $this->locateVex($vertex2);
        return $this->getNextAdjVexByLocate($row, $col + 1);
    }

    /**
     * 通过位置获取邻接节点
     *
     * @param int $row_locate
     * @param int $col_locate
     *
     * @return string|null
     */
    private function getNextAdjVexByLocate($row_locate, $col_locate)
    {
        for ($i = $col_locate; $i < $this->vex_number; $i++) {
            $adj = $this->arcs[$row_locate][$i]->adj;
            switch ($this->kind) {
                case self::DG:
                case self::UDG:
                    if ($adj === 1) {
                        return $this->vexs[$i]->data;
                    }
                    break;
                case self::DN:
                case self::UDN:
                    if ($adj !== PHP_INT_MAX) {
                        return $this->vexs[$i]->data;
                    }
                    break;
                default:
                    break;
            }
        }
        return null;
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
        $this->vexs[$this->vex_number] = new AdjacentMatrixVertex($vertex);
        $this->vex_number++;
        $index = $this->vex_number;
        for ($i = 0; $i < $this->vex_number; $i++) {
            $this->initArcByLocate($i, $index - 1);
            $this->initArcByLocate($index - 1, $i);
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deleteVex($vertex)
    {
        $locate = $this->locateVex($vertex);

        // 获取弧的个数
        $this->arc_number -= $this->getTDByLocate($locate);

        // 分三段上移
        // 第一段
        for ($row = 0; $row < $locate; $row++) {
            for ($col = $locate; $col < $this->vex_number - 1; $col++) {
                $this->arcs[$row][$col] = $this->arcs[$row][$col + 1];
            }
        }
        // 第二段
        for ($row = $locate; $row < $this->vex_number - 1; $row++) {
            for ($col = 0; $col < $locate; $col++) {
                $this->arcs[$row][$col] = $this->arcs[$row + 1][$col];
            }
        }
        // 第三段
        for ($row = $locate; $row < $this->vex_number - 1; $row++) {
            for ($col = $locate; $col < $this->vex_number - 1; $col++) {
                $this->arcs[$row][$col] = $this->arcs[$row + 1][$col + 1];
            }
        }
        $this->vex_number--;
    }

    /**
     * 统计顶点的度
     *
     * @param $locate
     *
     * @return int
     */
    private function getTDByLocate($locate)
    {
        $result = 0;
        switch ($this->kind) {
            case self::DG:
                // 统计行和列
                for ($i = 0; $i < $this->vex_number; $i++) {
                    if ($i == $locate) continue;
                    if ($this->arcs[$i][$locate]->adj !== 0) {
                        $result++;
                    }
                }
            case self::UDG:
                // 统计行
                for ($i = 0; $i < $this->vex_number; $i++) {
                    if ($this->arcs[$locate][$i] && $this->arcs[$locate][$i]->adj !== 0 && $i != $locate) {
                        $result++;
                    }
                }
                break;
            case self::DN:
                // 统计行和列
                for ($i = 0; $i < $this->vex_number; $i++) {
                    if ($i == $locate) continue;
                    if ($this->arcs[$i][$locate]->adj !== PHP_INT_MAX) {
                        $result++;
                    }
                }
                break;
            case self::UDN:
                // 统计行
                for ($i = 0; $i < $this->vex_number; $i++) {
                    if ($this->arcs[$locate][$i]->adj !== PHP_INT_MAX) {
                        $result++;
                    }
                }
                break;
            default:
                break;
        }
        return $result;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function insertArc($triple_arc)
    {
        $row = $this->locateVex($triple_arc->arc_tail);
        $col = $this->locateVex($triple_arc->arc_head);
        switch ($this->kind) {
            case self::UDG:
                $this->arcs[$col][$row]->adj = 1;
            case self::DG:
                $this->arcs[$row][$col]->adj = 1;
                break;
            case self::UDN:
                $this->arcs[$col][$row]->adj = $triple_arc->weight;
            case self::DN:
                $this->arcs[$row][$col]->adj = $triple_arc->weight;
                break;
            default:
                break;
        }
        $this->arc_number++;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function deleteArc($vertex1, $vertex2)
    {
        $row = $this->locateVex($vertex1);
        $col = $this->locateVex($vertex2);
        switch ($this->kind) {
            case self::UDG:
                $this->arcs[$col][$row]->adj = 0;
            case self::DG:
                $this->arcs[$row][$col]->adj = 0;
                break;
            case self::UDN:
                $this->arcs[$col][$row]->adj = PHP_INT_MAX;
            case self::DN:
                $this->arcs[$row][$col]->adj = PHP_INT_MAX;
                break;
            default:
                break;
        }
        $this->arc_number--;
    }

    /**
     * 深度优先遍历
     *
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
        for ($i = 0; $i < $this->vex_number; $i++) {
            if ($this->arcs[$index][$i]->adj !== 0 && $this->arcs[$index][$i]->adj !== PHP_INT_MAX && !$this->is_visited[$i]) {
                $this->dfs($i, $visit);
            }
        }
    }

    /**
     * 广度优先遍历
     *
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
                // 出队后访问其邻接点
                for ($i = 0; $i < $this->vex_number; $i++) {
                    if ($this->arcs[$elem][$i]->adj !== 0 && $this->arcs[$elem][$i]->adj !== PHP_INT_MAX && !$this->is_visited[$i]) {
                        $this->queue->enQueue($i);
                        $visit($i);
                        $this->is_visited[$i] = true;
                    }
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $result = [];
        for ($row = 0; $row < $this->vex_number; $row++) {
            for ($col = 0; $col < $this->vex_number; $col++) {
                $result[$row][$col] = $this->arcs[$row][$col]->adj;
            }
        }
        return $result;
    }
}
