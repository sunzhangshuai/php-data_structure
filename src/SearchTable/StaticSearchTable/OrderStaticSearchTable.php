<?php
/**
 * OrderStaticSearchTable.php :
 *
 * PHP version 7.1
 *
 * @category OrderStaticSearchTable
 * @package  DataStructure\SearchTable\StaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\StaticSearchTable;

use DataStructure\SearchTable\Model\Element;
use Closure;
use Exception;

/**
 * OrderStaticSearchTable : 有序查找表
 *
 * @category OrderStaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class OrderStaticSearchTable extends StaticSearchTable
{
    /**
     * @var array 斐波那契数组
     */
    public $fibonacci;

    /**
     * @var int 斐波那契最大值
     */
    public $max_fibonacci_key;

    /**
     * @var array 关键字数组
     */
    public $keys;

    /**
     * 初始化
     * StaticSearchTable constructor.
     *
     * @param $elements
     */
    public function __construct($elements)
    {
        $this->length   = count($elements);
        $this->elements = $elements;
        $this->sort();
        $this->initFibonacci();
        $this->initKeys();
    }

    /**
     * 获取斐波那契数组
     */
    protected function initFibonacci()
    {
        $this->fibonacci    = [];
        $this->fibonacci[0] = 0;
        $this->fibonacci[1] = 1;
        for ($i = 2; $this->fibonacci[$i - 1] <= $this->length; $i++) {
            $this->fibonacci[$i] = $this->fibonacci[$i - 1] + $this->fibonacci[$i - 2];
        }
        $this->max_fibonacci_key = $i - 1;
    }

    /**
     * 因为数组长度为f(n) - 1时更方便查找，所以将元素补足，因为元素为对象，则抽出新数组
     */
    protected function initKeys()
    {
        $this->keys = array_fill(0, $this->fibonacci[$this->max_fibonacci_key] - 1, 0);
        for ($i = 0; $i < $this->fibonacci[$this->max_fibonacci_key] - 1; $i++) {
            if ($i < $this->length) {
                $this->keys[$i] = $this->elements[$i]->key;
            } else {
                // 哨兵
                $this->keys[$i] = $this->elements[$this->length - 1]->key;
            }
        }
    }

    /**
     * 折半查找
     *
     * @param string $key
     *
     * @return Element
     * @throws Exception
     */
    public function search($key)
    {
        $low  = 0;
        $high = $this->length - 1;
        while ($low <= $high) {
            $mid = ceil(($low + $high) / 2);
            if ($this->elements[$mid]->key === $key) {
                return $this->elements[$mid];
            } elseif ($this->elements[$mid]->key > $key) {
                $high = $mid - 1;
            } else {
                $low = $mid + 1;
            }
        }
        throw new Exception('没有找到该元素');
    }


    /**
     * 斐波那契查找
     *
     * @param $key
     *
     * @return Element
     * @throws Exception
     */
    public function fibonacciSearch($key)
    {
        $identification = $this->max_fibonacci_key;
        $low            = 0;
        $high           = $this->length - 1;
        while ($low <= $high) {
            $mid = $low + $this->fibonacci[$identification - 1] - 1;
            if ($this->keys[$mid] === $key) {
                if ($mid < $this->length) {
                    return $this->elements[$mid];
                } else {
                    return $this->elements[$this->length];
                }
            } elseif ($this->elements[$mid]->key > $key) {
                $high = $mid - 1;
                $identification--;
            } else {
                $low            = $mid + 1;
                $identification -= 2;
            }
        }
        throw new Exception('没有找到该元素');
    }

    /**
     * 插值查找
     *
     * @param $key
     *
     * @return Element
     * @throws Exception
     */
    public function interpolationSearch($key)
    {
        $low  = 0;
        $high = $this->length - 1;
        while ($low <= $high) {
            $mid = $this->getMid($low, $high, $key);
            if ($this->elements[$mid]->key === $key) {
                return $this->elements[$mid];
            } elseif ($this->elements[$mid]->key > $key) {
                $high = (int)$mid - 1;
            } else {
                $low = (int)$mid + 1;
            }
        }
        throw new Exception('没有找到该元素');
    }

    /**
     * 获取mid
     *
     * @param $high
     * @param $low
     * @param $key
     *
     * @return false|float
     */
    protected function getMid($low, $high, $key)
    {
        if ($low === $high) return $low;

        $num1 = (int)$key - (int)$this->elements[$low]->key;
        $num2 = (int)$this->elements[$high]->key - (int)$this->elements[$low]->key;
        $num3 = $high - $low + 1;
        $mid = $low + ceil($num1 / ($num2 / $num3)) - 1;
        if ($mid < $low) {
            $mid = $low;
        }
        if ($mid > $high) {
            $mid = $high;
        }
        return $mid;
    }

    /**
     * @inheritDoc
     */
    function traverse(Closure $visit)
    {
        for ($index = 0; $index < $this->length; $index++) {
            $visit($this->elements[$index]);
        }
    }
}
