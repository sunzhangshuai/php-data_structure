<?php
/**
 * SparseMatrixInterface.php :
 *
 * PHP version 7.1
 *
 * @category SparseMatrixInterface
 * @package  DataStructure\SequenceSparseMatrix\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SparseMatrix\Interfaces;


interface SparseMatrixInterface
{
    /**
     * 初始化稀疏矩阵
     * SparseMatrixInterface constructor.
     *
     * @param array $array 二维数组，矩阵
     */
    public function __construct($array);

    /**
     * 将稀疏矩阵转为矩阵
     *
     * @return array
     */
    public function toArray();

    /**
     * 克隆稀疏矩阵
     *
     * @return SparseMatrixInterface
     */
    public function __clone();

    /**
     * 稀疏矩阵相加
     *
     * @param SparseMatrixInterface $sparse_matrix
     *
     * @return SparseMatrixInterface
     */
    public function addSparseMatrix($sparse_matrix);

    /**
     * 稀疏矩阵相减
     *
     * @param SparseMatrixInterface $sparse_matrix
     *
     * @return SparseMatrixInterface
     */
    public function subSparseMatrix($sparse_matrix);

    /**
     * 稀疏矩阵相乘
     *
     * @param SparseMatrixInterface $sparse_matrix
     *
     * @return SparseMatrixInterface
     */
    public function multSparseMatrix($sparse_matrix);

    /**
     * 稀疏矩阵转置
     *
     * @return SparseMatrixInterface
     */
    public function transposeSparseMatrix();
}
