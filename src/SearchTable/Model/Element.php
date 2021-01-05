<?php
/**
 * Element.php :
 *
 * PHP version 7.1
 *
 * @category Element
 * @package  DataStructure\SearchTable\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\Model;


class Element
{
    /**
     * @var string 键
     */
    public $key;

    /**
     * @var mixed 值
     */
    public $value;

    /**
     * @var int 查询次数
     */
    public $search_times;

    /**
     * @var int 权重
     */
    public $weight;

    /**
     * @var bool 是否被删除
     */
    public $is_deleted = false;

    /**
     * 初始化
     * Element constructor.
     *
     * @param     $key
     * @param     $value
     * @param int $weight
     */
    public function __construct($key, $value, $weight = 1)
    {
        $this->key          = $key;
        $this->value        = $value;
        $this->weight       = $weight;
        $this->search_times = 0;
    }
}
