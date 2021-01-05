<?php
/**
 * StaticSearchTable.php :
 *
 * PHP version 7.1
 *
 * @category StaticSearchTable
 * @package  DataStructure\SearchTable\StaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\StaticSearchTable;

use DataStructure\SearchTable\Interfaces\StaticSearchTableInterface;
use DataStructure\SearchTable\Model\Element;
use Closure;

/**
 * StaticSearchTable : 静态查询表
 *
 * @category StaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
abstract class StaticSearchTable implements StaticSearchTableInterface
{
    /**
     * @var int 查找表长度
     */
    public $length;

    /**
     * @var Element[] 用于存储数据
     */
    public $elements;

    /**
     * 查找
     *
     * @param string $key
     *
     * @return Element
     */
    abstract public function search($key);

    /**
     * @inheritDoc
     */
    abstract public function traverse(Closure $visit);

    /**
     * 排序
     */
    protected function sort()
    {
        for ($i = 1; $i < $this->length; $i++) {
            $elem = $this->elements[$i];
            for ($j = $i; $j > 0; $j--) {
                if ($elem->key < $this->elements[$j - 1]->key) {
                    $this->elements[$j] = $this->elements[$j - 1];
                } else {
                    break;
                }
            }
            $this->elements[$j] = $elem;
        }
    }
}
