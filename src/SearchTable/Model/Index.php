<?php
/**
 * Index.php :
 *
 * PHP version 7.1
 *
 * @category Index
 * @package  DataStructure\SearchTable\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\Model;


class Index
{
    /**
     * @var int 下标
     */
    public $index;

    /**
     * @var int 区域内个数
     */
    public $num;

    /**
     * @var int 最大值
     */
    public $max_key;

    /**
     * 初始化
     *
     * Index constructor.
     *
     * @param $max_key
     * @param $num
     */
    public function __construct($max_key, $num)
    {
        $this->max_key = $max_key;
        $this->num = $num;
    }
}
