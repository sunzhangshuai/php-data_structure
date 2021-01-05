<?php
/**
 * IndexStaticSearchTable.php :
 *
 * PHP version 7.1
 *
 * @category IndexStaticSearchTable
 * @package  DataStructure\SearchTable\StaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\StaticSearchTable;


use DataStructure\Lists\Model\LinkedListNode;
use DataStructure\Lists\SingleLinkedList;
use DataStructure\SearchTable\Model\Element;
use DataStructure\SearchTable\Model\Index;
use Closure;
use Exception;

/**
 * IndexStaticSearchTable : 索引查找表
 *
 * @category IndexStaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class IndexStaticSearchTable extends StaticSearchTable
{
    /**
     * @var Index[]
     */
    public $index_list;

    /**
     * @var int 段数
     */
    public $chunk_num;

    /**
     * IndexStaticSearchTable constructor.
     *
     * @param Element[] $elements
     */
    public function __construct($elements)
    {
        $this->length = count($elements);
        // 获取分段个数
        $this->chunk_num = (int)ceil(sqrt($this->length));
        // 获取elements中最大的key和最小的key
        $this->getMinAndMax($min, $max, $elements);
        // 获取每段值的取值范围
        $range = ceil(($max - $min) / $this->chunk_num);
        // 初始化index_list
        $this->index_list = array_fill(0, $this->chunk_num, null);
        for ($i = 0; $i < $this->chunk_num; $i++) {
            $this->index_list[$i] = new Index(0, 0);
        }
        // 生成桶
        /** @var SingleLinkedList[] $buckets */
        $buckets = array_fill(0, $this->chunk_num, null);
        for ($i = 0; $i < $this->chunk_num; $i++) {
            $buckets[$i] = new SingleLinkedList();
        }
        // 将数据放入桶中，并更新index_list
        for ($i = 0; $i < $this->length; $i++) {
            $index = floor(($elements[$i]->key - $min) / $range);
            $buckets[$index]->insFirst(new LinkedListNode($i));
            $this->index_list[$index]->num++;
            if ($this->index_list[$index]->max_key < $elements[$i]->key) {
                $this->index_list[$index]->max_key = $elements[$i]->key;
            }
        }
        // 将桶中的数据串起来
        $index = 0;
        for ($i = 0; $i < $this->chunk_num; $i++) {
            if ($buckets[$i]) {
                $visit = function ($data) use (&$index, $elements) {
                    $this->elements[$index] = $elements[$data];
                    $index++;
                };
                $buckets[$i]->listTraverse($visit);
            }
        }
        // 更新index_list的index
        for ($i = 1; $i < $this->chunk_num; $i++) {
            $this->index_list[$i]->index = $this->index_list[$i - 1]->num + $this->index_list[$i - 1]->index;
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function search($key)
    {
        for ($index = 0; $index < $this->chunk_num; $index++) {
            if ($key <= $this->index_list[$index]->max_key) {
                break;
            }
        }
        if ($index === $this->chunk_num) {
            throw new Exception('没有找到该元素');
        }
        for ($i = $this->index_list[$index]->index; $i < $this->index_list[$index]->index + $this->index_list[$index]->num; $i++) {
            if ($this->elements[$i]->key === $key) {
                return $this->elements[$i];
            }
        }
        throw new Exception('没有找到该元素');
    }

    /**
     * @inheritDoc
     */
    public function traverse(Closure $visit)
    {
        for ($index = 0; $index < $this->length; $index++) {
            $visit($this->elements[$index]);
        }
    }

    /**
     * 获取最大值和最小值
     *
     * @param           $min
     * @param           $max
     * @param Element[] $elements
     */
    private function getMinAndMax(&$min, &$max, $elements)
    {
        if (count($elements) % 2 == 0) {
            if ($elements[0] < $elements[1]) {
                $min = $elements[0]->key;
                $max = $elements[1]->key;
            } else {
                $min = $elements[1]->key;
                $max = $elements[0]->key;
            }
            $index = 2;
        } else {
            $min   = $max = $elements[0]->key;
            $index = 1;
        }
        for ($i = $index; $i < count($elements); $i += 2) {
            if ($elements[$i]->key < $elements[$i + 1]->key) {
                $temp_min = $elements[$i]->key;
                $temp_max = $elements[$i + 1]->key;
            } else {
                $temp_min = $elements[$i + 1]->key;
                $temp_max = $elements[$i]->key;
            }
            $min = $min < $temp_min ? $min : $temp_min;
            $max = $max > $temp_max ? $max : $temp_max;
        }
    }
}
