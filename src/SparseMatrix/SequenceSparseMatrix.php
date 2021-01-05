<?php
/**
 * SequenceSparseMatrix.php :
 *
 * PHP version 7.1
 *
 * @category SequenceSparseMatrix
 * @package  DataStructure\SequenceSparseMatrix
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SparseMatrix;


use DataStructure\SparseMatrix\Interfaces\SparseMatrixInterface;
use DataStructure\SparseMatrix\Model\Triple;
use Exception;

/**
 * 顺序稀疏矩阵
 * SequenceSparseMatrix :
 *
 * @category SequenceSparseMatrix
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class SequenceSparseMatrix implements SparseMatrixInterface
{
    /**
     * 二维数组的最大尺寸
     */
    const MAX_SIZE = 12500;

    /**
     * @var Triple[] 数组
     */
    public $data;

    /**
     * @var int 行数
     */
    public $mu;

    /**
     * @var int 列数
     */
    public $nu;

    /**
     * @var int 总数据个数
     */
    public $tu;

    /**
     * @var array 每行的开始位置
     */
    public $rpos;

    /**
     * @inheritDoc
     */
    public function __construct($array = [])
    {
        $index    = 0;
        $this->mu = count($array);
        foreach ($array as $row => $item) {
            if (!$this->nu) $this->nu = count($item);
            $this->rpos[$row + 1] = $index;
            foreach ($item as $col => $data) {
                if ($data !== 0) {
                    $this->tu++;
                    $this->data[$index] = new Triple($row + 1, $col + 1, $data);
                    $index++;
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $result = array_fill(0, $this->mu, array_fill(0, $this->nu, 0));
        foreach ($this->data as $datum) {
            $result[$datum->row - 1][$datum->column - 1] = $datum->data;
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function __clone()
    {
    }

    /**
     * @inheritDoc
     *
     * @param SequenceSparseMatrix $sparse_matrix
     *
     * @throws Exception
     */
    public function addSparseMatrix($sparse_matrix)
    {
        return $this->additionAndSubtraction($sparse_matrix, '+');
    }

    /**
     * @inheritDoc
     *
     * @param SequenceSparseMatrix $sparse_matrix
     *
     * @throws Exception
     */
    public function subSparseMatrix($sparse_matrix)
    {
        return $this->additionAndSubtraction($sparse_matrix, '-');
    }

    /**
     * @param SequenceSparseMatrix $sparse_matrix
     * @param string               $type
     *
     * @return SequenceSparseMatrix
     * @throws Exception
     */
    public function additionAndSubtraction($sparse_matrix, $type)
    {
        if ($this->mu !== $sparse_matrix->mu || $this->nu !== $sparse_matrix->nu) {
            throw new Exception('矩阵大小不同，无法计算');
        }
        // 设置基础属性
        $result       = new SequenceSparseMatrix();
        $result->mu   = $this->mu;
        $result->nu   = $this->nu;
        $result->rpos = array_fill(0, $result->mu + 1, 0);

        // 遍历每行
        $index = 0;
        for ($i = 1; $i <= $this->mu; $i++) {
            // 给每行开始位置赋值
            $result->rpos[$i] = $index;

            // 获取参与运算的两个矩阵的开始位置和结束位置
            $index1 = $this->rpos[$i];
            $end1   = $i === $this->mu ? $this->tu - 1 : $this->rpos[$i + 1] - 1;
            $index2 = $sparse_matrix->rpos[$i];
            $end2   = $i === $sparse_matrix->mu ? $sparse_matrix->tu - 1 : $sparse_matrix->rpos[$i + 1] - 1;
            while ($index1 <= $end1 && $index2 <= $end2) {
                $col1  = $this->data[$index1]->column;
                $data1 = $this->data[$index1]->data;
                $col2  = $sparse_matrix->data[$index2]->column;
                $data2 = $sparse_matrix->data[$index2]->data;
                if ($type == '-') $data2 *= -1;
                if ($col1 < $col2) {
                    $result->data[$index] = new Triple($i, $col1, $data1);
                    $index1++;
                    $index++;
                } elseif ($col1 > $col2) {
                    $result->data[$index] = new Triple($i, $col2, $data2);
                    $index2++;
                    $index++;
                } else {
                    $data = $data1 + $data2;
                    if ($data) {
                        $result->data[$index] = new Triple($i, $col1, $data1 + $data2);
                        $index++;
                    }
                    $index1++;
                    $index2++;
                }
            }
            // 如果有剩下的要续
            while ($index1 <= $end1) {
                $col1                 = $this->data[$index1]->column;
                $data1                = $this->data[$index1]->data;
                $result->data[$index] = new Triple($i, $col1, $data1);
                $index1++;
                $index++;
            }
            while ($index2 <= $end2) {
                $col2  = $sparse_matrix->data[$index2]->column;
                $data2 = $sparse_matrix->data[$index2]->data;
                if ($type == '-') $data2 *= -1;
                $result->data[$index] = new Triple($i, $col2, $data2);
                $index2++;
                $index++;
            }
        }
        $result->tu = $index;
        return $result;
    }

    /**
     * 1. 当矩阵A的列数（column）等于矩阵B的行数（row）时，A与B可以相乘。
     * 2. 矩阵C的行数等于矩阵A的行数，C的列数等于B的列数。
     * 3. 乘积C的第m行第n列的元素等于矩阵A的第m行的元素与矩阵B的第n列对应元素乘积之和。
     *
     * @inheritDoc
     *
     * @param SequenceSparseMatrix $sparse_matrix
     *
     * @throws Exception
     */
    public function multSparseMatrix($sparse_matrix)
    {
        if ($this->nu !== $sparse_matrix->mu) {
            throw new Exception('矩阵大小不同，无法计算');
        }
        // 设置基础属性
        $result       = new SequenceSparseMatrix();
        $result->mu   = $this->mu;
        $result->nu   = $sparse_matrix->nu;
        $result->rpos = array_fill(0, $result->mu + 1, 0);

        // 遍历矩阵A
        $index = 0;
        for ($row_A = 1; $row_A <= $this->mu; $row_A++) {
            // 设置每行的开始元素的下标
            $result->rpos[$row_A] = $index;

            $index_A = $this->rpos[$row_A];
            $end_A   = $row_A === $this->mu ? $this->tu - 1 : $this->rpos[$row_A + 1] - 1;

            $data = array_fill(0, $sparse_matrix->nu + 1, 0);

            // 遍历每行的元素
            while ($index_A <= $end_A) {

                $col_A  = $this->data[$index_A]->column;
                $data_A = $this->data[$index_A]->data;

                // 获取B矩阵第$col_A行的所有元素
                $index_B = $sparse_matrix->rpos[$col_A];
                $end_B   = $col_A === $sparse_matrix->mu ? $sparse_matrix->tu - 1 : $sparse_matrix->rpos[$col_A + 1] - 1;
                while ($index_B <= $end_B) {
                    $col_B        = $sparse_matrix->data[$index_B]->column;
                    $data_B       = $sparse_matrix->data[$index_B]->data;
                    $data_C       = $data_A * $data_B;
                    $data[$col_B] += $data_C;
                    $index_B++;
                }
                $index_A++;
            }

            // A矩阵每行遍历完之后，新矩阵C当前行的元素就已经确定了
            for ($col_B = 1; $col_B <= $sparse_matrix->nu; $col_B++) {
                if ($data[$col_B] !== 0) {
                    $result->data[$index] = new Triple($row_A, $col_B, $data[$col_B]);
                    $index++;
                }
            }
        }

        $result->tu = $index;
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function transposeSparseMatrix()
    {
        // 设置基础属性
        $result     = new SequenceSparseMatrix();
        $result->mu = $this->nu;
        $result->nu = $this->mu;
        $result->tu = $this->tu;

        $result->data = array_fill(0, $result->tu, null);

        // 获取转置后每行的数量
        $rpos = array_fill(0, $result->mu + 1, 0);
        for ($i = 0; $i < $this->tu; $i++) {
            $row = $this->data[$i]->column;
            $rpos[$row]++;
        }
        // 获取每行转置后的开始位置
        $pre = 0;
        for ($i = 1; $i <= $result->mu; $i++) {
            $temp     = $pre + $rpos[$i];
            $rpos[$i] = $pre;
            $pre      = $temp;
        }
        $result->rpos = $rpos;

        // 生成data
        for ($i = 0; $i < $this->tu; $i++) {
            $row                       = $this->data[$i]->column;
            $col                       = $this->data[$i]->row;
            $data                      = $this->data[$i]->data;
            $result->data[$rpos[$row]] = new Triple($row, $col, $data);
            $rpos[$row]++;
        }
        return $result;
    }
}
