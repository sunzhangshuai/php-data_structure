<?php
/**
 * SequenceStaticSearchTable.php :
 *
 * PHP version 7.1
 *
 * @category SequenceStaticSearchTableImpl
 * @package  DataStructure\SearchTable\StaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\StaticSearchTable;

use DataStructure\SearchTable\Model\Element;
use Closure;
use Exception;

/**
 * SequenceStaticSearchTable :顺序静态查询表
 *
 * @category SequenceStaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class SequenceStaticSearchTable extends StaticSearchTable
{
    /**
     * SequenceStaticSearchTable constructor.
     *
     * @param $elements
     */
    public function __construct($elements)
    {
        $this->length      = count($elements);
        $this->elements[0] = new Element(0, 0);
        for ($i = 1; $i <= $this->length; $i++) {
            $this->elements[$i] = $elements[$i - 1];
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function search($key)
    {
        // 查找
        $this->elements[0]->key   = $key;
        $this->elements[0]->value = 0;
        for ($index = $this->length; $this->elements[$index]->key !== $key; $index--)
            if ($index === 0) {
                throw new Exception('没有找到该元素');
            }
        $this->elements[$index]->search_times++;
        $element      = $this->elements[$index];
        $search_times = $element->search_times;
        // 改变顺序
        for ($i = $index; $i < $this->length; $i++) {
            if ($search_times > $this->elements[$i + 1]->search_times) {
                $this->elements[$i] = $this->elements[$i + 1];
            } else {
                break;
            }
        }
        $this->elements[$i] = $element;
        return $element;
    }

    /**
     * @inheritDoc
     */
    public function traverse(Closure $visit)
    {
        for ($index = $this->length; $index > 0; $index--) {
            $visit($this->elements[$index]);
        }
    }
}
