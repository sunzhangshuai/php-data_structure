<?php

use DataStructure\SparseMatrix\OrthogonalListSparseMatrix;
use DataStructure\SparseMatrix\SequenceSparseMatrix;
use PHPUnit\Framework\TestCase;

class SparseMatrixTest extends TestCase
{
    /**
     * @group sparse_matrix
     * @throws Exception
     */
    public function testSequenceSparseMatrix()
    {
        $data = [
            [0, 3, 0, 0, 0],
            [0, 0, 6, 0, 0],
            [9, 0, 4, 0, 2],
            [0, 0, 0, 7, 0],
        ];
        // 初始化
        $sparse_matrix = new SequenceSparseMatrix($data);
        $this->assertEquals($sparse_matrix->toArray(), $data);

        // 克隆
        $clone_sparse_matrix = clone $sparse_matrix;
        $this->assertEquals($sparse_matrix->toArray(), $clone_sparse_matrix->toArray());

        // 转置
        $transpose_data          = [
            [0, 0, 9, 0],
            [3, 0, 0, 0],
            [0, 6, 4, 0],
            [0, 0, 0, 7],
            [0, 0, 2, 0]
        ];
        $transpose_sparse_matrix = $sparse_matrix->transposeSparseMatrix();
        $this->assertEquals($transpose_sparse_matrix->toArray(), $transpose_data);

        // 加法
        $add_data          = [
            [0, -3, 0, 2, 0],
            [0, 0, -6, 4, 0],
            [-2, 0, 4, 0, 0],
            [0, 0, 0, 0, 0],
        ];
        $add_sparse_matrix = new SequenceSparseMatrix($add_data);
        $result_data       = [
            [0, 0, 0, 2, 0],
            [0, 0, 0, 4, 0],
            [7, 0, 8, 0, 2],
            [0, 0, 0, 7, 0],
        ];
        $sparse_matrix     = $sparse_matrix->addSparseMatrix($add_sparse_matrix);
        $this->assertEquals($sparse_matrix->toArray(), $result_data);

        // 减法
        $sparse_matrix = $sparse_matrix->subSparseMatrix($add_sparse_matrix);
        $this->assertEquals($sparse_matrix->toArray(), $data);

        // 乘法
        $result_data   = [
            [9, 0, 0, 0],
            [0, 36, 24, 0],
            [0, 24, 101, 0],
            [0, 0, 0, 49]
        ];
        $sparse_matrix = $sparse_matrix->multSparseMatrix($transpose_sparse_matrix);
        $this->assertEquals($sparse_matrix->toArray(), $result_data);
    }

    /**
     * @group sparse_matrix
     * @throws Exception
     */
    public function testOrthogonalListSparseMatrix()
    {
        $data = [
            [0, 3, 0, 0, 0],
            [0, 0, 6, 0, 0],
            [9, 0, 4, 0, 2],
            [0, 0, 0, 7, 0],
        ];
        // 初始化
        $sparse_matrix = new OrthogonalListSparseMatrix($data);
        $this->assertEquals($sparse_matrix->toArray(), $data);

        // 克隆
        $clone_sparse_matrix = clone $sparse_matrix;
        $this->assertEquals($sparse_matrix->toArray(), $clone_sparse_matrix->toArray());

        // 转置
        $transpose_data          = [
            [0, 0, 9, 0],
            [3, 0, 0, 0],
            [0, 6, 4, 0],
            [0, 0, 0, 7],
            [0, 0, 2, 0]
        ];
        $transpose_sparse_matrix = $sparse_matrix->transposeSparseMatrix();
        $this->assertEquals($transpose_sparse_matrix->toArray(), $transpose_data);

        // 加法
        $add_data          = [
            [0, -3, 0, 2, 0],
            [0, 0, -6, 4, 0],
            [-2, 0, 4, 0, 0],
            [0, 0, 0, 0, 0],
        ];
        $add_sparse_matrix = new OrthogonalListSparseMatrix($add_data);
        $result_data       = [
            [0, 0, 0, 2, 0],
            [0, 0, 0, 4, 0],
            [7, 0, 8, 0, 2],
            [0, 0, 0, 7, 0],
        ];
        $sparse_matrix     = $sparse_matrix->addSparseMatrix($add_sparse_matrix);
        $this->assertEquals($sparse_matrix->toArray(), $result_data);

        // 减法
        $sparse_matrix = $sparse_matrix->subSparseMatrix($add_sparse_matrix);
        $this->assertEquals($sparse_matrix->toArray(), $data);

        // 乘法
        $result_data   = [
            [9, 0, 0, 0],
            [0, 36, 24, 0],
            [0, 24, 101, 0],
            [0, 0, 0, 49]
        ];
        $sparse_matrix = $sparse_matrix->multSparseMatrix($transpose_sparse_matrix);
        $this->assertEquals($sparse_matrix->toArray(), $result_data);
    }
}
