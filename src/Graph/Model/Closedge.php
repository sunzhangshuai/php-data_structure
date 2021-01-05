<?php
/**
 * Closedge.php :
 *
 * PHP version 7.1
 *
 * @category Closedge
 * @package  DataStructure\Graph\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model;


class Closedge
{
    /**
     * @var int 邻接点
     */
    public $adj_vex;

    /**
     * @var int 最小权重
     */
    public $low_cast;

    /**
     * Closedge constructor.
     *
     * @param $adj_vex
     * @param $low_cast
     */
    public function __construct($adj_vex, $low_cast)
    {
        $this->adj_vex = $adj_vex;
        $this->low_cast = $low_cast;
    }
}
