<?php
/**
 * SkipList.php :
 *
 * PHP version 7.1
 *
 * @category SkipList
 * @package  DataStructure\Lists
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists;


use DataStructure\Lists\Interfaces\SkipListInterface;
use DataStructure\Lists\Model\SkipLevelNode;
use DataStructure\Lists\Model\SkipNode;
use Closure;
use Exception;

class SkipList implements SkipListInterface
{
    /**
     * @var SkipNode 头结点
     */
    public $head;

    /**
     * @var SkipNode 尾节点
     */
    public $tail;

    /**
     * @var int 链表长度
     */
    public $len;

    /**
     * @var int 层数最高节点的层数
     */
    public $level;

    /**
     * 跳表最高的层数
     */
    const MAX_LEVEL = 32;

    /**
     * 集合最大的大小
     */
    const MAX_SIZE = 200000;

    /**
     * @var SkipNode[] 每层的前驱节点
     */
    public $pre_node;

    /**
     * @var int[] 每层的前驱节点的排名
     */
    public $pre_rank;

    /**
     * @var int 要操作的节点的排名
     */
    public $rank;


    public function __construct()
    {
        $level = [];
        for ($i = 0; $i < self::MAX_LEVEL; $i++) {
            $level[$i] = new SkipLevelNode();
        }
        $node        = new SkipNode();
        $node->level = $level;
        $this->head  = $this->tail = $node;
        $this->len   = 0;
        $this->level = 0;
    }

    public function clearList()
    {
        $this->len   = 0;
        $this->level = 0;
        for ($i = 0; $i < self::MAX_LEVEL; $i++) {
            $this->head->level[$i]->forward = null;
            $this->head->level[$i]->span    = self::MAX_SIZE;
        }
        $this->tail = $this->head;
    }

    /**
     * 查找节点
     *
     * @param \DataStructure\SearchTable\Model\SkipNode $node
     * @param Closure                                       $callback
     *
     * @return bool
     */
    public function search(\DataStructure\SearchTable\Model\SkipNode $node, Closure $callback)
    {
        $find_node = $this->head;
        $level     = $this->level;
        while ($level >= 0) {
            $pre = $this->head;
            while ($find_node) {
                $compare = $callback($find_node, $node, $level);
                if ($compare < 0) {
                    $pre       = $find_node;
                    $find_node = $find_node->level[$level]->forward;
                } elseif ($compare == 0) {
                    return true;
                } else {
                    break;
                }
            }
            $level--;
            $find_node = $pre;
        }
        return false;
    }

    /**
     * @param \DataStructure\SearchTable\Model\SkipNode $node
     */
    public function insert(\DataStructure\SearchTable\Model\SkipNode $node)
    {
        $this->findNodePre($node);
        // 随机获取节点的层数
        $node_level = $this->getLevel();
        if ($this->level < $node_level) {
            $this->level = $node_level;
        }

        // 插入新节点
        $new_node           = new SkipNode();
        $new_node->score    = $node->score;
        $new_node->level    = array_fill(0, $node_level + 1, null);
        $new_node->data     = $node->element;
        $new_node->backword = $this->pre_node[0];
        if ($this->pre_node[0]->level[0]->forward) {
            $this->pre_node[0]->level[0]->forward->backword = $new_node;
        }
        // 从最高的level开始计算span值
        // 比当前节点层数大的前驱节点span++；
        // 当前节点所有层的前驱节点span切开
        $level = $this->level;
        while ($level >= 0) {
            if ($level <= $node_level) {
                $new_node->level[$level]          = new SkipLevelNode();
                $new_node->level[$level]->forward = $this->pre_node[$level]->level[$level]->forward;
                if ($this->pre_node[$level]->level[$level]->forward) {
                    $new_node->level[$level]->span = $this->pre_node[$level]->level[$level]->span - ($this->rank - $this->pre_rank[$level]) + 1;
                } else {
                    $new_node->level[$level]->span = self::MAX_SIZE;
                }
                $this->pre_node[$level]->level[$level]->forward = $new_node;
                $this->pre_node[$level]->level[$level]->span    = $this->rank - $this->pre_rank[$level];
            } else {
                $this->pre_node[$level]->level[$level]->span++;
            }
            $level--;
        }

        if ($this->rank > $this->len) {
            $this->tail = $new_node;
        }
        $this->len++;
    }

    /**
     * 删除节点
     *
     * @param \DataStructure\SearchTable\Model\SkipNode $node
     */
    public function delete(\DataStructure\SearchTable\Model\SkipNode $node)
    {
        $this->findNodePre($node);
        // 删除节点
        $new_node                              = $this->pre_node[0]->level[0]->forward;
        $new_node->level[0]->forward->backword = $this->pre_node[0];
        $level                                 = $this->level;
        // 比当前节点层数大的前驱节点span--；
        // 当前节点所有层的前驱节点span等于两段之和
        while ($level >= 0) {
            if (isset($new_node->level[$level])) {
                $this->pre_node[$level]->level[$level]->forward = $new_node->level[$level]->forward;
                $this->pre_node[$level]->level[$level]->span    += ($new_node->level[$level]->span - 1);
            } else {
                $this->pre_node[$level]->level[$level]->span--;
            }
            $level--;
        }
        $this->len--;
        if ($this->len == 0) {
            $this->tail = $this->head;
        }
    }

    /**
     * 节点遍历
     *
     * @param \DataStructure\SearchTable\Model\SkipNode $node
     * @param Closure                                       $callback
     *
     * @return bool
     */
    public function traverse(\DataStructure\SearchTable\Model\SkipNode $node, Closure $callback)
    {
        $find_node = $this->head;
        while ($find_node) {
            $result = $callback($find_node, $node);
            if ($result == 0) {
                return true;
            }
            $find_node = $find_node->level[0]->forward;
        }
        return false;
    }

    /**
     * 获取新节点层数
     *
     * @return int
     */
    protected function getLevel()
    {
        $count = $this->len;
        $level = 0;
        try {
            while ($count >= 0) {
                if (random_int(0, self::MAX_LEVEL - 1) > $this->rank) {
                    $level++;
                }
                $count--;
            }
        } catch (Exception $exception) {

        }
        return $level;
    }

    /**
     * 查找节点的前驱
     *
     * @param \DataStructure\SearchTable\Model\SkipNode $node
     */
    protected function findNodePre(\DataStructure\SearchTable\Model\SkipNode $node)
    {
        // 每层前驱节点
        $this->pre_node = array_fill(0, self::MAX_LEVEL, $this->head);
        // 每层前驱节点的排名
        $this->pre_rank = array_fill(0, self::MAX_LEVEL + 2, 0);
        $node_prev      = $this->head;
        $this->findPreByScore($node, $node_prev);
        $this->findPreByData($node, $node_prev);
    }

    /**
     * 通过分值查找节点的前驱
     *
     * @param \DataStructure\SearchTable\Model\SkipNode $node
     * @param SkipNode                                      $node_prev
     */
    protected function findPreByScore(\DataStructure\SearchTable\Model\SkipNode $node, SkipNode &$node_prev)
    {
        $level = $this->level;
        while ($level >= 0) {
            $this->pre_rank[$level] = $this->pre_rank[$level + 1];
            while ($node_prev->level[$level]->forward && $node_prev->level[$level]->forward->score < $node->score) {
                $this->pre_rank[$level] += $node_prev->level[$level]->span;
                $node_prev              = $node_prev->level[$level]->forward;
                $this->pre_node[$level] = $node_prev;
            }
            $level--;
            if ($level >= 0) {
                $this->pre_node[$level] = $node_prev;
            }
        }
    }

    /**
     * 通过元素遍历，从最底层遍历
     *
     * @param \DataStructure\SearchTable\Model\SkipNode $node
     * @param SkipNode                                      $node_prev
     */
    protected function findPreByData(\DataStructure\SearchTable\Model\SkipNode $node, SkipNode &$node_prev)
    {
        $this->rank = $this->pre_rank[0] + 1;
        if (!$node_prev->level[0]->forward || $node_prev->level[0]->forward->score > $node->score) {
            return;
        }
        while ($node_prev->level[0]->forward->data < $node->element) {
            $node_prev = $node_prev->level[0]->forward;
            $level     = $this->level;
            while ($level >= 0) {
                if ($node_prev->level[$level]) {
                    $this->pre_rank[$level] = $this->rank;
                }
            }
            $this->rank++;
        }
    }
}
