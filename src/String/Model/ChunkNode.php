<?php
/**
 * ChunkNode.php :
 *
 * PHP version 7.1
 *
 * @category ChunkNode
 * @package  DataStructure\String\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\String\Model;


class ChunkNode
{
    /**
     * @var int 块内的字符
     */
    public $chars;

    /**
     * @var ChunkNode 下一个块儿
     */
    public $next;

    /**
     * 初始化
     * ChunkNode constructor.
     *
     * @param $string
     * @param $length
     */
    public function __construct($string = '')
    {
        $this->chars = $string;
    }
}
