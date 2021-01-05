<?php
/**
 * TreeStaticSearchTable.php :
 *
 * PHP version 7.1
 *
 * @category TreeStaticSearchTable
 * @package  DataStructure\SearchTable\StaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\StaticSearchTable;

use DataStructure\SearchTable\Model\Element;
use DataStructure\Tree\BinaryTree\BinaryTree;
use DataStructure\Tree\BinaryTree\Model\BinaryTreeNode;
use Closure;
use Exception;

/**
 * TreeStaticSearchTable : 静态数表
 *
 * @category TreeStaticSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class TreeStaticSearchTable extends StaticSearchTable
{
    /**
     * @var BinaryTree
     */
    public $tree;

    /**
     * @var int 权重之和
     */
    public $sum_weight;

    /**
     * 初始化
     *
     * TreeStaticSearchTable constructor.
     *
     * @param $elements
     */
    public function __construct($elements)
    {
        $this->length   = count($elements);
        $this->elements = $elements;
        // 排序
        $this->sort();
        // 计算sw
        $this->findSumWeigth();
        // 生成静态树
        $this->createBiTree();
    }

    /**
     * 获取权重和
     */
    protected function findSumWeigth()
    {
        $this->sum_weight    = array_fill(0, $this->length + 1, 0);
        $this->sum_weight[0] = 0;
        for ($i = 1; $i <= $this->length; $i++) {
            $this->sum_weight[$i] = $this->sum_weight[$i - 1] + $this->elements[$i - 1]->weight;
        }
    }

    /**
     * 创建二叉树
     */
    public function createBiTree()
    {
        $this->tree = new BinaryTree();
        if ($this->length === 0) {
            return;
        }
        $this->tree->root = $this->secondOptimal(1, $this->length);
    }

    /**
     * 次序二叉树
     *
     * @param int $low
     * @param int $high
     */
    public function secondOptimal(int $low, int $high)
    {
        // 计算mid
        $mid         = $low;
        $min         = $this->sum_weight[$high] - $this->sum_weight[$low];
        $diff_weight = abs($this->sum_weight[$high] + $this->sum_weight[$low - 1]);
        for ($i = $low + 1; $i < $high; $i++) {
            if (abs($diff_weight - $this->sum_weight[$i - 1] - $this->sum_weight[$i]) < $min) {
                $min = abs($diff_weight - $this->sum_weight[$i - 1] - $this->sum_weight[$i]);
                $mid = $i;
            }
        }

        // mid和附近的两个数比较权重，计算最小的
        $start = $mid - 1;
        $end   = $mid + 1;
        $max   = $this->elements[$mid - 1]->weight;
        for ($i = $start; $i >= $low && $i <= $high && $i <= $end; $i++) {
            if ($this->elements[$i - 1]->weight > $max) {
                $max = $this->elements[$i - 1]->weight;
                $mid = $i;
            }
        }

        // 生成节点
        $node = new BinaryTreeNode($mid - 1);
        if ($mid === $low) {
            $node->l_child = null;
        } else {
            $node->l_child = $this->secondOptimal($low, $mid - 1);
        }
        if ($mid === $high) {
            $node->r_child = null;
        } else {
            $node->r_child = $this->secondOptimal($mid + 1, $high);
        }
        return $node;
    }

    /**
     * @param string $key
     *
     * @return Element
     * @throws Exception
     */
    public function search($key)
    {
        $node = $this->tree->root;
        while ($node) {
            if ($this->elements[$node->data]->key === $key) {
                return $this->elements[$node->data];
            } elseif ($this->elements[$node->data]->key > $key) {
                $node = $node->l_child;
            } else {
                $node = $node->r_child;
            }
        }
        throw new Exception('没有找到该元素');
    }

    /**
     * @inheritDoc
     */
    function traverse(Closure $visit)
    {
        $new_result = function ($data) use ($visit) {
            $visit($this->elements[$data]);
        };
        $this->tree->preOrderTraverse($new_result);
    }
}
