<?php
/**
 * OrthogonalListSparseMatrix.php :
 *
 * PHP version 7.1
 *
 * @category OrthogonalListSparseMatrix
 * @package  DataStructure\SparseMatrix
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SparseMatrix;


use DataStructure\SparseMatrix\Interfaces\SparseMatrixInterface;
use DataStructure\SparseMatrix\Model\OrthogonalListNode;
use Exception;

/**
 * 十字链表稀疏矩阵
 * OrthogonalListSparseMatrix :
 *
 * @category OrthogonalListSparseMatrix
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class OrthogonalListSparseMatrix implements SparseMatrixInterface
{
    /**
     * @var OrthogonalListNode[] 行头节点
     */
    public $row_head;

    /**
     * @var OrthogonalListNode[] 列头结点
     */
    public $column_head;

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
     * @inheritDoc
     */
    public function __construct($array = [])
    {
        if (!$array) return;
        $this->mu          = count($array);
        $this->nu          = count($array[0]);
        $this->row_head    = array_fill(0, $this->mu + 1, null);
        $this->column_head = array_fill(0, $this->nu + 1, null);

        for ($row = $this->mu; $row > 0; $row--) {
            for ($col = $this->nu; $col > 0; $col--) {
                $data = $array[$row - 1][$col - 1];
                if ($data !== 0) {
                    $this->tu++;
                    $node                    = new OrthogonalListNode($row, $col, $data);
                    $node->right             = $this->row_head[$row];
                    $this->row_head[$row]    = $node;
                    $node->down              = $this->column_head[$col];
                    $this->column_head[$col] = $node;
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
        for ($row = 1; $row <= $this->mu; $row++) {
            $node = $this->row_head[$row];
            while ($node) {
                $result[$row - 1][$node->column - 1] = $node->data;
                $node                                = $node->right;
            }
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function __clone()
    {
        $result              = new OrthogonalListSparseMatrix();
        $result->mu          = $this->mu;
        $result->nu          = $this->nu;
        $result->tu          = $this->tu;
        $result->row_head    = array_fill(0, $this->mu + 1, null);
        $result->column_head = array_fill(0, $this->nu + 1, null);
        for ($row = 1; $row <= $result->mu; $row++) {
            $pre  = $result->row_head[$row];
            $node = $this->row_head[$row];
            while ($node) {
                $new_node = new OrthogonalListNode($node->row, $node->column, $node->data);
                $result->insAfter($pre, $new_node);
                $pre  = $new_node;
                $node = $node->right;
            }
        }
        return $result;
    }

    /**
     * @param OrthogonalListSparseMatrix $sparse_matrix
     *
     * @inheritDoc
     * @throws Exception
     */
    public function addSparseMatrix($sparse_matrix)
    {
        $this->additionAndSubtraction($sparse_matrix, '+');
        return $this;
    }

    /**
     * @param OrthogonalListSparseMatrix $sparse_matrix
     *
     * @inheritDoc
     * @throws Exception
     */
    public function subSparseMatrix($sparse_matrix)
    {
        $this->additionAndSubtraction($sparse_matrix, '-');
        return $this;
    }

    /**
     * @param OrthogonalListSparseMatrix $sparse_matrix
     *
     * @inheritDoc
     * @throws Exception
     */
    public function multSparseMatrix($sparse_matrix)
    {
        if ($this->nu !== $sparse_matrix->mu) {
            throw new Exception('矩阵大小不同，无法计算');
        }
        // 设置基础属性
        $result              = new OrthogonalListSparseMatrix();
        $result->mu          = $this->mu;
        $result->nu          = $sparse_matrix->nu;
        $result->tu          = 0;
        $result->row_head    = array_fill(0, $result->mu + 1, null);
        $result->column_head = array_fill(0, $result->nu + 1, null);

        // 遍历A矩阵的行
        for ($row_A = 1; $row_A <= $this->mu; $row_A++) {
            $pre = $result->row_head[$row_A];
            // 遍历B矩阵的列
            for ($col_B = 1; $col_B <= $this->mu; $col_B++) {
                // 获取A矩阵当前行的头结点
                $node_A = $this->row_head[$row_A];
                // 获取B矩阵对应列的头结点
                $node_B = $sparse_matrix->column_head[$col_B];
                // 计算结果
                $data = 0;
                while ($node_A && $node_B) {
                    if ($node_A->column > $node_B->row) {
                        $node_B = $node_B->down;
                    } elseif ($node_A->column < $node_B->row) {
                        $node_A = $node_A->right;
                    } else {
                        $data   += $node_A->data * $node_B->data;
                        $node_A = $node_A->right;
                        $node_B = $node_B->down;
                    }
                }
                // 插入节点
                if ($data !== 0) {
                    $result->tu++;
                    $new_node = new OrthogonalListNode($row_A, $col_B, $data);
                    $result->insAfter($pre, $new_node);
                    $pre = $new_node;
                }
            }
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function transposeSparseMatrix()
    {
        $result              = new OrthogonalListSparseMatrix();
        $result->mu          = $this->nu;
        $result->nu          = $this->mu;
        $result->tu          = $this->tu;
        $result->row_head    = array_fill(0, $result->mu + 1, null);
        $result->column_head = array_fill(0, $result->nu + 1, null);

        for ($column = 1; $column <= $this->nu; $column++) {
            $node = $this->column_head[$column];
            $pre  = $result->row_head[$column];
            while ($node) {
                $new_node = new OrthogonalListNode($node->column, $node->row, $node->data);
                $result->insAfter($pre, $new_node);
                $pre  = $new_node;
                $node = $node->down;
            }
        }
        return $result;
    }

    /**
     * @param OrthogonalListSparseMatrix $sparse_matrix
     * @param string                     $string
     *
     * @return void
     * @throws Exception
     */
    private function additionAndSubtraction(OrthogonalListSparseMatrix $sparse_matrix, string $string)
    {
        if ($this->mu !== $sparse_matrix->mu || $this->nu !== $sparse_matrix->nu) {
            throw new Exception('矩阵大小不同，无法计算');
        }
        for ($row = 1; $row <= $this->mu; $row++) {
            $node_A = $this->row_head[$row];
            $node_B = $sparse_matrix->row_head[$row];
            $pre    = null;
            while ($node_A && $node_B) {
                $data_A = $node_A->data;
                $col_A  = $node_A->column;
                $data_B = $node_B->data;
                if ($string === '-') $data_B *= -1;
                $col_B = $node_B->column;
                // 判断 A矩阵和B矩阵列的大小
                if ($col_A < $col_B) {
                    $pre    = $node_A;
                    $node_A = $node_A->right;
                } elseif ($col_A > $col_B) {
                    $new_node = new OrthogonalListNode($row, $col_B, $data_B);
                    $this->insAfter($pre, $new_node);
                    $pre    = $new_node;
                    $node_B = $node_B->right;
                    $this->tu++;
                } else {
                    $data = $data_A + $data_B;
                    if ($data !== 0) {
                        $node_A->data = $data;
                        $pre          = $node_A;
                    } else {
                        $this->tu--;
                        $this->delAfter($pre, $node_A);
                    }
                    $node_A = $node_A->right;
                    $node_B = $node_B->right;
                }
            }
            while ($node_B) {
                $this->tu++;
                $data_B = $node_B->data;
                if ($string === '-') $data_B *= -1;
                $new_node = new OrthogonalListNode($row, $node_B->column, $data_B);
                $this->insAfter($pre, $new_node);
                $pre    = $new_node;
                $node_B = $node_B->right;
            }
        }
    }

    /**
     * 在行链node节点前后插入new_node节点
     *
     * @param OrthogonalListNode         $node
     * @param OrthogonalListNode         $new_node
     */
    private function insAfter($node, $new_node)
    {
        // 行链插入
        if (!$node) {
            $new_node->right                         = $this->row_head[$new_node->row];
            $this->row_head[$new_node->row] = $new_node;
        } else {
            $new_node->right = $node->right;
            $node->right     = $new_node;
        }
        // 列链插入
        $col_node = $this->column_head[$new_node->column];
        if (!$col_node || $col_node->row > $new_node->row) {
            $new_node->down                                = $col_node;
            $this->column_head[$new_node->column] = $new_node;
        } else {
            while ($col_node->down && $col_node->down->row < $new_node->row) {
                $col_node = $col_node->down;
            }
            $new_node->down = $col_node->down;
            $col_node->down = $new_node;
        }
    }

    /**
     * 在行链node节点前后删除del_node节点
     *
     * @param OrthogonalListNode         $node
     * @param OrthogonalListNode         $del_node
     */
    private function delAfter($node, $del_node)
    {
        // 行链，删除当前节点
        if (!$node) {
            $this->row_head[$del_node->row] = $del_node->right;
        } else {
            $node->right = $del_node->right;
        }
        // 列链，删除当前节点
        $col_node = $this->column_head[$del_node->column];
        if ($col_node === $del_node) {
            $this->column_head[$del_node->column] = $del_node->down;
        } else {
            while ($col_node->down && $col_node->down->row < $del_node->row) {
                $col_node = $col_node->down;
            }
            $col_node->down = $del_node->down;
        }
    }
}
