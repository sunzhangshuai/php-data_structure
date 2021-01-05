<?php
/**
 * SkipNode.php :
 *
 * PHP version 7.1
 *
 * @category SkipNode
 * @package  DataStructure\SearchTable\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\Model;


use Exception;

class SkipNode
{
    const SCORE = 1;
    const ELEMENT = 2;
    const RANK = 3;

    /**
     * @var float 分值
     */
    public $score;

    /**
     * @var string 元素
     */
    public $element;

    /**
     * @var int 排名
     */
    public $rank;

    /**
     * @var int 查询类型，1：通过分值查询|2：通过元素查询|3：通过排名查询
     */
    public $request_type;

    /**
     * @var int 返回值类型，1：分值|2：元素|3：排名
     */
    public $response_type;

    /**
     * @var boolean 是否找到
     */
    public $is_find = false;

    public $pre_span = 0;

    /**
     * 获取结果
     *
     * @throws Exception
     */
    public function get()
    {
        if (!$this->is_find) {
            return null;
        }
        switch ($this->response_type) {
            case self::SCORE:
                return $this->score;
            case self::ELEMENT:
                return $this->element;
            case self::RANK:
                return $this->rank;
            default:
                throw new Exception('返回值类型暂不支持');
        }
    }

    public function __construct($score = null, $element = '')
    {
        $this->score   = $score;
        $this->element = $element;
    }
}
