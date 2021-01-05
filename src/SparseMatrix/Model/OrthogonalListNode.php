<?php
/**
 * OrthogonalListNode.php :
 *
 * PHP version 7.1
 *
 * @category OrthogonalListNode
 * @package  DataStructure\SparseMatrix\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SparseMatrix\Model;


class OrthogonalListNode
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
     * @var mixed 值
     */
    public $data;

    /**
     * @var OrthogonalListNode 行表后继
     */
    public $right;

    /**
     * @var OrthogonalListNode 列表后继
     */
    public $down;

    /**
     * OrthogonalListNode constructor.
     *
     * @param int   $row
     * @param int   $column
     * @param mixed $data
     */
    public function __construct($row, $column, $data)
    {
        $this->row = $row;
        $this->column = $column;
        $this->data = $data;
    }
}
