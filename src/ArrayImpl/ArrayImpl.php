<?php
/**
 * ArrayImpl.php :
 *
 * PHP version 7.1
 *
 * @category ArrayImpl
 * @package  ${NAMESPACE}
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\ArrayImpl;


use DataStructure\ArrayImpl\Interfaces\ArrayInterface;
use Exception;

class ArrayImpl implements ArrayInterface
{
    /**
     * @var array 数组元素
     */
    private $elems;

    /**
     * @var int 数组维度
     */
    private $dim;

    /**
     * @var array 数组每维最多的元素
     */
    private $bounds;

    /**
     * @var array 数组每维需要跃进的步数
     */
    private $constants;

    /**
     * @inheritDoc
     */
    public function __construct(int $dim, array $bounds)
    {
        $this->dim                 = $dim;
        $this->bounds              = $bounds;
        $this->constants[$dim - 1] = 1;
        for ($i = $dim - 2; $i >= 0; $i--) {
            ;
            $this->constants[$i] = $this->bounds[$i + 1] * $this->constants[$i + 1];
        }
        for ($i = 0; $i < $this->constants[0] * $this->bounds[0]; $i++) {
            $this->elems[$i] = 0;
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function value($e, array $poss)
    {
        $this->check($poss);
        $this->elems[$this->locate($poss)] = $e;
    }

    /**
     * @inheritDoc
     */
    public function assign(array $poss)
    {
        $this->check($poss);
        return $this->elems[$this->locate($poss)];
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->getArray(1, 0, count($this->elems) - 1);
    }

    /**
     * 获取数组，递归
     * @param $depth
     * @param $start
     * @param $end
     *
     * @return array|mixed
     */
    public function getArray($depth, $start, $end)
    {
        if ($start === $end) {
            return $this->elems[$start];
        }
        $result = [];
        $bound = $this->bounds[$depth - 1];
        $constant = $this->constants[$depth - 1];
        $index = $start;
        for ($i = 0; $i < $bound; $i++) {
            $result[$i] = $this->getArray($depth + 1, $index, $index + $constant - 1);
            $index += $constant;
        }
        return $result;
    }

    /**
     * 检验参数
     *
     * @param $poss
     *
     * @throws Exception
     */
    private function check($poss)
    {
        for ($i = 0; $i < $this->dim; $i++) {
            if ($poss[$i] < 0 || $poss[$i] >= $this->bounds[$i]) {
                throw new Exception('参数非法');
            }
        }
    }

    /**
     * 根据下标获取位置
     *
     * @param $poss
     *
     * @return int
     */
    private function locate($poss)
    {
        $result = 0;
        for ($i = 0; $i < $this->dim; $i++) {
            $result += $poss[$i] * $this->constants[$i];
        }
        return $result;
    }
}
