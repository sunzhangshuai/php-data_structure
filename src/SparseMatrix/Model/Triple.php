<?php
/**
 * Triple.php :
 *
 * PHP version 7.1
 *
 * @category Triple
 * @package  DataStructure\SequenceSparseMatrix\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SparseMatrix\Model;


class Triple
{
    /**
     * @var int 行
     */
    public $row;

    /**
     * @var int 列
     */
    public $column;

    /**
     * @var mixed 数据域
     */
    public $data;

    /**
     * 初始化
     * Triple constructor.
     *
     * @param $row
     * @param $column
     * @param $data
     */
    public function __construct($row, $column, $data)
    {
        $this->row    = $row;
        $this->column = $column;
        $this->data   = $data;
    }
}
