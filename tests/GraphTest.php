<?php

use DataStructure\Graph\AdjacencyMultListGraph;
use DataStructure\Graph\AdjacentListGraph;
use DataStructure\Graph\AdjacentMatrixGraph;
use DataStructure\Graph\Graph;
use DataStructure\Graph\Model\TripleExtend;
use DataStructure\Graph\OrthogonalListGraph;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * todo 还有问题
 *
 * Class GraphTest
 * @package Tests\Feature\DataStructure
 */
class GraphTest extends TestCase
{
    /**
     * 邻接矩阵
     *
     * @group graph
     * @throws Exception
     */
    public function testAdjacentMatrixGraph()
    {
        // 创建
        $vertex      = [
            'node1',
            'node2',
            'node3',
            'node4'
        ];
        $triples     = [
            new TripleExtend($vertex[0], $vertex[1], 2),
            new TripleExtend($vertex[1], $vertex[2], 3),
            new TripleExtend($vertex[3], $vertex[1], 4),
            new TripleExtend($vertex[0], $vertex[3], 5)
        ];
        $graph       = new AdjacentMatrixGraph($vertex, $triples, Graph::UDN);
        $result_data = [
            [PHP_INT_MAX, 2, PHP_INT_MAX, 5],
            [2, PHP_INT_MAX, 3, 4],
            [PHP_INT_MAX, 3, PHP_INT_MAX, PHP_INT_MAX],
            [5, 4, PHP_INT_MAX, PHP_INT_MAX],
        ];
        $this->assertEquals($result_data, $graph->toArray());
        // locate
        $this->assertEquals(2, $graph->locateVex('node3'));

        // firstAdjVex
        $this->assertEquals('node1', $graph->firstAdjVex('node2'));

        // nextAdjVex
        $this->assertEquals('node3', $graph->nextAdjVex('node2', 'node1'));

        // insert
        $graph->insertVex('node88');
        $this->assertEquals(4, $graph->locateVex('node88'));

        // put
        $graph->putVex('node88', 'node5');
        $this->assertEquals(4, $graph->locateVex('node5'));

        // insertArc
        $new_triple1 = new TripleExtend('node1', 'node5', 11);
        $new_triple2 = new TripleExtend('node5', 'node2', 12);
        $new_triple3 = new TripleExtend('node5', 'node3', 13);
        $new_triple4 = new TripleExtend('node4', 'node5', 14);
        $graph->insertArc($new_triple1);
        $graph->insertArc($new_triple2);
        $graph->insertArc($new_triple3);
        $graph->insertArc($new_triple4);
        $result_data = [
            [PHP_INT_MAX, 2, PHP_INT_MAX, 5, 11],
            [2, PHP_INT_MAX, 3, 4, 12],
            [PHP_INT_MAX, 3, PHP_INT_MAX, PHP_INT_MAX, 13],
            [5, 4, PHP_INT_MAX, PHP_INT_MAX, 14],
            [11, 12, 13, 14, PHP_INT_MAX],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // 遍历
        $data = [];
        $visit = function ($index) use (&$data, $graph) {
            $data[] = $graph->vexs[$index]->data;
        };
        $graph->DFSTraverse($visit);
        $this->assertEquals(['node1', 'node2', 'node3', 'node5', 'node4'], $data);
        $data = [];
        $graph->BFSTraverse($visit);
        $this->assertEquals(['node1', 'node2', 'node4', 'node5', 'node3'], $data);

        // deleteArc
        $graph->deleteArc('node5', 'node2');
        $result_data = [
            [PHP_INT_MAX, 2, PHP_INT_MAX, 5, 11],
            [2, PHP_INT_MAX, 3, 4, PHP_INT_MAX],
            [PHP_INT_MAX, 3, PHP_INT_MAX, PHP_INT_MAX, 13],
            [5, 4, PHP_INT_MAX, PHP_INT_MAX, 14],
            [11, PHP_INT_MAX, 13, 14, PHP_INT_MAX],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // deleteVex
        $graph->deleteVex('node5');
        $result_data = [
            [PHP_INT_MAX, 2, PHP_INT_MAX, 5],
            [2, PHP_INT_MAX, 3, 4],
            [PHP_INT_MAX, 3, PHP_INT_MAX, PHP_INT_MAX],
            [5, 4, PHP_INT_MAX, PHP_INT_MAX],
        ];
        $this->assertEquals($result_data, $graph->toArray());
    }

    /**
     * 邻接表
     *
     * @group graph
     * @throws Exception
     */
    public function testAdjacentListGraph()
    {
        // 创建
        $vertex      = [
            'node1',
            'node2',
            'node3',
            'node4'
        ];
        $triples     = [
            new TripleExtend($vertex[0], $vertex[1]),
            new TripleExtend($vertex[1], $vertex[2]),
            new TripleExtend($vertex[3], $vertex[1]),
            new TripleExtend($vertex[0], $vertex[3])
        ];
        $graph       = new AdjacentListGraph($vertex, $triples, Graph::UDG);
        $result_data = [
            [0, 1, 0, 1],
            [1, 0, 1, 1],
            [0, 1, 0, 0],
            [1, 1, 0, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());
        // locate
        $this->assertEquals(2, $graph->locateVex('node3'));

        // firstAdjVex
        $this->assertEquals('node4', $graph->firstAdjVex('node2'));

        // nextAdjVex
        $this->assertEquals('node3', $graph->nextAdjVex('node2', 'node4'));

        // insert
        $graph->insertVex('node88');
        $this->assertEquals(4, $graph->locateVex('node88'));

        // put
        $graph->putVex('node88', 'node5');
        $this->assertEquals(4, $graph->locateVex('node5'));

        // insertArc
        $new_triple1 = new TripleExtend('node1', 'node5');
        $new_triple2 = new TripleExtend('node5', 'node2');
        $new_triple3 = new TripleExtend('node5', 'node3');
        $new_triple4 = new TripleExtend('node4', 'node5');
        $graph->insertArc($new_triple1);
        $graph->insertArc($new_triple2);
        $graph->insertArc($new_triple3);
        $graph->insertArc($new_triple4);
        $result_data = [
            [0, 1, 0, 1, 1],
            [1, 0, 1, 1, 1],
            [0, 1, 0, 0, 1],
            [1, 1, 0, 0, 1],
            [1, 1, 1, 1, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // 遍历
        $data = [];
        $visit = function ($index) use (&$data, $graph) {
            $data[] = $graph->vexs[$index]->data;
        };
        $graph->DFSTraverse($visit);
        $this->assertEquals(['node1', 'node5', 'node4', 'node2', 'node3'], $data);
        $data = [];
        $graph->BFSTraverse($visit);
        $this->assertEquals(['node1', 'node5', 'node4', 'node2', 'node3'], $data);

        // deleteArc
        $graph->deleteArc('node5', 'node2');
        $result_data = [
            [0, 1, 0, 1, 1],
            [1, 0, 1, 1, 0],
            [0, 1, 0, 0, 1],
            [1, 1, 0, 0, 1],
            [1, 0, 1, 1, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // deleteVex
        $graph->deleteVex('node5');
        $result_data = [
            [0, 1, 0, 1],
            [1, 0, 1, 1],
            [0, 1, 0, 0],
            [1, 1, 0, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());
    }

    /**
     * 十字链表
     *
     * @group graph
     * @throws Exception
     */
    public function testOrthogonalListGraph()
    {
        // 创建
        $vertex      = [
            'node1',
            'node2',
            'node3',
            'node4'
        ];
        $triples     = [
            new TripleExtend($vertex[0], $vertex[1]),
            new TripleExtend($vertex[1], $vertex[2]),
            new TripleExtend($vertex[3], $vertex[1]),
            new TripleExtend($vertex[0], $vertex[3])
        ];
        $graph       = new OrthogonalListGraph($vertex, $triples);
        $result_data = [
            [0, 1, 0, 1],
            [0, 0, 1, 0],
            [0, 0, 0, 0],
            [0, 1, 0, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // locate
        $this->assertEquals(2, $graph->locateVex('node3'));

        // firstAdjVex
        $this->assertEquals('node3', $graph->firstAdjVex('node2'));

        // nextAdjVex
        $this->assertEquals(null, $graph->nextAdjVex('node2', 'node3'));

        // insert
        $graph->insertVex('node88');
        $this->assertEquals(4, $graph->locateVex('node88'));

        // put
        $graph->putVex('node88', 'node5');
        $this->assertEquals(4, $graph->locateVex('node5'));

        // insertArc
        $new_triple1 = new TripleExtend('node1', 'node5');
        $new_triple2 = new TripleExtend('node5', 'node2');
        $new_triple3 = new TripleExtend('node5', 'node3');
        $new_triple4 = new TripleExtend('node4', 'node5');
        $graph->insertArc($new_triple1);
        $graph->insertArc($new_triple2);
        $graph->insertArc($new_triple3);
        $graph->insertArc($new_triple4);
        $result_data = [
            [0, 1, 0, 1, 1],
            [0, 0, 1, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 1, 0, 0, 1],
            [0, 1, 1, 0, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // 遍历
        $data = [];
        $visit = function ($index) use (&$data, $graph) {
            $data[] = $graph->vexs[$index]->data;
        };
        $graph->DFSTraverse($visit);
        $this->assertEquals(['node1', 'node5', 'node3', 'node2', 'node4'], $data);
        $data = [];
        $graph->BFSTraverse($visit);
        $this->assertEquals(['node1', 'node5', 'node4', 'node2', 'node3'], $data);

        // deleteArc
        $graph->deleteArc('node5', 'node2');
        $result_data = [
            [0, 1, 0, 1, 1],
            [0, 0, 1, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 1, 0, 0, 1],
            [0, 0, 1, 0, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // deleteVex
        $graph->deleteVex('node5');
        $result_data = [
            [0, 1, 0, 1],
            [0, 0, 1, 0],
            [0, 0, 0, 0],
            [0, 1, 0, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());
    }

    /**
     * 邻接多重表
     *
     * @group graph
     * @throws Exception
     */
    public function testAdjacencyMultListGraph()
    {
        // 创建
        $vertex      = [
            'node1',
            'node2',
            'node3',
            'node4'
        ];
        $triples     = [
            new TripleExtend($vertex[0], $vertex[1]),
            new TripleExtend($vertex[1], $vertex[2]),
            new TripleExtend($vertex[3], $vertex[1]),
            new TripleExtend($vertex[0], $vertex[3])
        ];
        $graph       = new AdjacencyMultListGraph($vertex, $triples);
        $result_data = [
            [0, 1, 0, 1],
            [1, 0, 1, 1],
            [0, 1, 0, 0],
            [1, 1, 0, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // locate
        $this->assertEquals(2, $graph->locateVex('node3'));

        // firstAdjVex
        $this->assertEquals('node4', $graph->firstAdjVex('node2'));

        // nextAdjVex
        $this->assertEquals('node3', $graph->nextAdjVex('node2', 'node4'));

        // insert
        $graph->insertVex('node88');
        $this->assertEquals(4, $graph->locateVex('node88'));

        // put
        $graph->putVex('node88', 'node5');
        $this->assertEquals(4, $graph->locateVex('node5'));

        // insertArc
        $new_triple1 = new TripleExtend('node1', 'node5');
        $new_triple2 = new TripleExtend('node5', 'node2');
        $new_triple3 = new TripleExtend('node5', 'node3');
        $new_triple4 = new TripleExtend('node4', 'node5');
        $graph->insertArc($new_triple1);
        $graph->insertArc($new_triple2);
        $graph->insertArc($new_triple3);
        $graph->insertArc($new_triple4);
        $result_data = [
            [0, 1, 0, 1, 1],
            [1, 0, 1, 1, 1],
            [0, 1, 0, 0, 1],
            [1, 1, 0, 0, 1],
            [1, 1, 1, 1, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // 遍历
        $data = [];
        $visit = function ($index) use (&$data, $graph) {
            $data[] = $graph->vexs[$index]->data;
        };
        $graph->DFSTraverse($visit);
        $this->assertEquals(['node1', 'node5', 'node4', 'node2', 'node3'], $data);
        $data = [];
        $graph->BFSTraverse($visit);
        $this->assertEquals(['node1', 'node5', 'node4', 'node2', 'node3'], $data);

        // deleteArc
        $graph->deleteArc('node2', 'node5');
        $result_data = [
            [0, 1, 0, 1, 1],
            [1, 0, 1, 1, 0],
            [0, 1, 0, 0, 1],
            [1, 1, 0, 0, 1],
            [1, 0, 1, 1, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());

        // deleteVex
        $graph->deleteVex('node5');
        $result_data = [
            [0, 1, 0, 1],
            [1, 0, 1, 1],
            [0, 1, 0, 0],
            [1, 1, 0, 0],
        ];
        $this->assertEquals($result_data, $graph->toArray());
    }
}
