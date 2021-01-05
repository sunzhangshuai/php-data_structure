<?php
/**
 * Vertex.php :
 *
 * PHP version 7.1
 *
 * @category Vertex
 * @package  DataStructure\Graph\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Graph\Model\Vertex;

/**
 * Vertex : 丁带你类
 *
 * @category Vertex
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class Vertex
{
    /**
     * @var string 顶点名称
     */
    public $data;

    /**
     * AdjacentMatrixVertex constructor.
     *
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
