<?php
/**
 * Lists.php :
 *
 * PHP version 7.1
 *
 * @category Lists
 * @package  ${NAMESPACE}
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists;

use DataStructure\Lists\Interfaces\SequenceListInterface;
use Closure;
use Exception;

class SequenceList implements SequenceListInterface
{
    const LIST_INIT_SIZE = 100;
    const LIST_INCREMENT = 10;

    /**
     * @var array 数据内容
     */
    protected $elem;

    /**
     * @var int 长度
     */
    protected $length;

    /**
     * @var int 当前分配的存储容量
     */
    protected $list_size;

    /**
     * 初始化线性表
     *
     * Lists constructor.
     */
    public function __construct()
    {
        $this->length = self::LIST_INIT_SIZE;
        $this->elem   = [];
    }

    /**
     * 清空线性表
     */
    public function clearList()
    {
        $this->length = 0;
        $this->elem   = [];
    }

    /**
     * 若线性表为空，返回true，否则返回false
     *
     * @return bool
     */
    public function listEmpty()
    {
        return $this->length == 0;
    }

    /**
     * 返回表中数据元素的个数
     *
     * @return int
     */
    public function listLength()
    {
        return $this->length;
    }

    /**
     * 返回表中第i个元素的值
     *
     * @param $index
     *
     * @return mixed
     * @throws Exception
     */
    public function getElem($index)
    {
        if ($index <= 0 || $index > $this->length) {
            throw new Exception('表中没有第' . $index . '个元素');
        }
        return $this->elem[$index - 1];
    }

    /**
     * 返回第一个与elem满足compare关系的数据元素的位序
     *
     * @param         $elem
     * @param Closure $compare
     *
     * @return int
     */
    public function locateElem($elem, Closure $compare)
    {
        for ($index = 0; $index < $this->length; $index++) {
            if ($compare($elem, $this->elem[$index])) {
                return $index + 1;
            }
        }
        return 0;
    }

    /**
     * 找到elem的前驱元素
     *
     * @param $elem
     *
     * @return mixed
     * @throws Exception
     */
    public function priorElem($elem)
    {
        if ($elem === $this->elem[0]) throw new Exception('没有前驱元素');
        for ($index = 1; $index < $this->length; $index++) {
            if ($this->elem[$index] !== $elem) continue;
            return $this->elem[$index - 1];
        }
        throw new Exception('没有找到当前元素');
    }

    /**
     * 找到elem的后继元素
     *
     * @param $elem
     *
     * @return mixed
     * @throws Exception
     */
    public function nextElem($elem)
    {
        if ($elem === $this->elem[$this->length - 1]) throw new Exception('没有后继元素');
        for ($index = 0; $index < $this->length - 1; $index++) {
            if ($this->elem[$index] !== $elem) continue;

            return $this->elem[$index - 1];
        }
        throw new Exception('没有找到当前元素');
    }

    /**
     * 在第index个位置插入元素
     *
     * @param $index
     * @param $elem
     *
     * @throws Exception
     */
    public function listInsert($index, $elem)
    {
        // 判断插入位置
        if ($index <= 0 || $index > $this->length + 1) {
            throw new Exception('插入位置有误');
        }
        // 扩容
        $this->expand($this->length + 1);

        for ($i = $this->length - 1; $i >= $index - 1; $i++) {
            $this->elem[$i + 1] = $this->elem[$i];
        }
        $this->elem[$index - 1] = $elem;
        $this->length++;
    }

    /**
     * 删除第index个位置的元素
     *
     * @param $index
     *
     * @return mixed
     * @throws Exception
     */
    public function listDelete($index)
    {
        // 判断插入位置
        if ($index <= 0 || $index > $this->length) {
            throw new Exception('位置有误');
        }
        $result = $this->elem[$index - 1];
        for ($i = $index - 1; $i < $this->length; $i++) {
            $this->elem[$i] = $this->elem[$i + 1];
        }
        $this->length++;
        return $result;
    }

    /**
     * 遍历数序表
     *
     * @param Closure $visit
     */
    public function listTraverse(Closure $visit)
    {
        for($i = 0; $i < $this->length; $i++) {
            $visit($this->elem[$i]);
        }
    }

    /**
     * 扩容
     * @param $length
     */
    public function expand($length)
    {
        // 判断顺序表是否已满，如果满了需要扩容
        if ($this->length < $length) {
            $new_length = $this->list_size + self::LIST_INCREMENT;
            $this->list_size = $length > $new_length ? $length : $new_length;
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->elem;
    }
}
