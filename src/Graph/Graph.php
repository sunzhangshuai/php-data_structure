<?php
/**
 * Graph.php :
 *
 * PHP version 7.1
 *
 * @category Graph
 * @package  DataStructure\Graph
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph;

use DataStructure\Graph\Interfaces\GraphInterface;
use DataStructure\Graph\Model\Vertex\AdjacencyMultListVertex;
use DataStructure\Graph\Model\Vertex\AdjacentListVertex;
use DataStructure\Graph\Model\Vertex\AdjacentMatrixVertex;
use DataStructure\Graph\Model\Vertex\OrthogonalListVerTex;
use DataStructure\Graph\Model\Vertex\Vertex;
use DataStructure\Queue\SingleLinkedQueue;
use DataStructure\Stack\SequenceStack;
use Closure;
use Exception;

abstract class Graph implements GraphInterface
{
    const MAX_VERTEX_NUM = 20;

    // 有向图
    const DG = 0;

    // 有向网
    const DN = 1;

    // 无向图
    const UDG = 2;

    // 无向网
    const UDN = 3;

    /**
     * @var boolean[] 是否访问过
     */
    public $is_visited;

    /**
     * @var AdjacencyMultListVertex[]|AdjacentListVertex[]|AdjacentMatrixVertex[]|OrthogonalListVerTex[]|Vertex[] 顶点数组
     */
    public $vexs;

    /**
     * @var int 顶点个数
     */
    public $vex_number;

    /**
     * @var int 弧或边的个数
     */
    public $arc_number;

    /**
     * @var SingleLinkedQueue 单链队列
     */
    protected $queue;

    /**
     * @var SequenceStack 栈
     */
    protected $stack;

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
        $this->vex_number = 0;
        $this->arc_number = 0;
        // 初始化矩阵和数组
        $this->vexs = array_fill(0, self::MAX_VERTEX_NUM, null);
        // 添加顶点
        for ($i = 0; $i < count($vertexs); $i++) {
            $this->insertVex($vertexs[$i]);
        }
        // 添加弧
        for ($i = 0; $i < count($triple_arcs); $i++) {
            $this->insertArc($triple_arcs[$i]);
        }
        $this->queue = new SingleLinkedQueue();
        $this->stack = new SequenceStack();
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function locateVex($vertex)
    {
        for ($i = 0; $i < $this->vex_number; $i++) {
            if ($this->vexs[$i]->data === $vertex) {
                return $i;
            }
        }
        throw new Exception('顶点没有找到');
    }

    /**
     * @inheritDoc
     */
    public function getVex($vertex)
    {
        return $vertex->data;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function putVex($vertex, $value)
    {
        $index                    = $this->locateVex($vertex);
        $this->vexs[$index]->data = $value;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    abstract public function firstAdjVex($vertex);

    /**
     * @inheritDoc
     * @throws Exception
     */
    abstract public function nextAdjVex($vertex, $other_vertex);

    /**
     * @inheritDoc
     * @throws Exception
     */
    abstract public function insertVex($vertex);

    /**
     * @inheritDoc
     * @throws Exception
     */
    abstract public function deleteVex($vertex);

    /**
     * @inheritDoc
     * @throws Exception
     */
    abstract public function insertArc($triple_arc);

    /**
     * @inheritDoc
     * @throws Exception
     */
    abstract public function deleteArc($vertex1, $vertex2);

    /**
     * @inheritDoc
     */
    public function DFSTraverse(Closure $visit)
    {
        // todo
    }

    /**
     * 深度优先遍历递归部分
     *
     * @param         $index
     * @param Closure $visit
     */
    public function dfs($index, Closure $visit)
    {
        // todo
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function BFSTraverse(Closure $visit)
    {
        // todo
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    abstract public function toArray();
}
