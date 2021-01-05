<?php
/**
 * SkipTableSearch.php :
 *
 * PHP version 7.1
 *
 * @category SkipTableSearch
 * @package  DataStructure\SearchTable\DynamicSearchTable
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\SearchTable\DynamicSearchTable;


use DataStructure\Lists\SkipList;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Hash\Mod;
use DataStructure\SearchTable\DynamicSearchTable\HashTable\Table\LinkedHashTable;
use DataStructure\SearchTable\Model\Element;
use DataStructure\SearchTable\Model\SkipNode;
use Closure;
use Exception;

class SkipListSearchTable extends DynamicSearchTable
{
    /**
     * @var SkipList 跳跃表
     */
    protected $skip_list;

    /**
     * @var LinkedHashTable hash表
     */
    protected $hash_table;

    protected $temp_span;

    protected $pre_span;

    public function __construct()
    {
        $this->skip_list  = new SkipList();
        $this->hash_table = new LinkedHashTable(Mod::getInstance());
        parent::__construct();
    }

    /**
     * @param SkipNode|string $node
     *
     * @return mixed
     * @throws Exception
     */
    public function search($node)
    {
        if ($node->element && !$this->hash_table->search($node->element)) {
            return null;
        }
        switch ($node->request_type) {
            case SkipNode::SCORE:
                $this->searchByScore($node);
                break;
            case SkipNode::ELEMENT:
                $this->searchByElement($node);
                break;
            case SkipNode::RANK:
                $this->searchByRank($node);
                break;
            default:
                throw new Exception("查询类型暂不支持");
        }
        return $node->get();
    }

    /**
     * @param SkipNode|string $node
     *
     * @throws Exception
     */
    private function searchByScore($node)
    {
        $this->temp_span = 0;
        $this->pre_span = 0;
        $callback        = function (\DataStructure\Lists\Model\SkipNode $skip_node, SkipNode $search_node, int $level) use (&$node) {
            $result = $skip_node->score <=> $search_node->score;
            if ($result <= 0) {
                $this->temp_span += $this->pre_span;
                if ($skip_node->level[$level]->forward) {
                    $this->pre_span = $skip_node->level[$level]->span;
                } else {
                    $this->pre_span = 0;
                }
            } else {
                $this->pre_span = 0;
            }
            if ($result == 0) {
                $node->is_find = true;
                $node->element = $skip_node->data;
                $node->rank    = $this->temp_span - 1;
            }
            return $result;
        };
        $this->skip_list->search($node, $callback);
    }

    /**
     * @param SkipNode|string $node
     *
     * @throws Exception
     */
    private function searchByElement($node)
    {
        $this->temp_span = -1;
        $callback        = function (\DataStructure\Lists\Model\SkipNode $skip_node, SkipNode $search_node) use (&$node) {
            $result = $skip_node->data <=> $search_node->element;
            if ($result < 0) {
                $this->temp_span++;
            }
            if ($result == 0) {
                $node->is_find = true;
                $node->rank    = $this->temp_span;
                $node->score   = $skip_node->score;
            }
            return $result;
        };
        $this->skip_list->traverse($node, $callback);
    }

    /**
     * @param SkipNode|string $node
     *
     * @throws Exception
     */
    private function searchByRank($node)
    {
        $this->temp_span = 0;
        $this->pre_span = 0;
        $callback        = function (\DataStructure\Lists\Model\SkipNode $skip_node, SkipNode $search_node, int $level) use (&$node) {
            $result = $this->pre_span + $this->temp_span - 1 <=> $search_node->rank;
            if ($result <= 0) {
                $this->temp_span += $this->pre_span;
                if ($skip_node->level[$level]->forward) {
                    $this->pre_span = $skip_node->level[$level]->span;
                } else {
                    $this->pre_span = 0;
                }
            } else {
                $this->pre_span = 0;
            }
            if ($result == 0) {
                $node->is_find = true;
                $node->score   = $skip_node->score;
                $node->element = $skip_node->data;
            }
            return $result;
        };
        $this->skip_list->search($node, $callback);
    }

    /**
     * @param SkipNode|string $node
     *
     * @return bool|void
     */
    public function insert($node)
    {
        $search_node = $this->hash_table->search($node->element);
        if ($search_node) {
            $this->skip_list->delete($search_node->value);
        }
        $element = new Element($node->element, $node);
        $this->hash_table->insert($element);
        $this->skip_list->insert($node);
    }

    /**
     * @param SkipNode|string $node
     *
     * @return bool|void
     */
    public function delete($node)
    {
        /** @var SkipNode $search_node */
        $search_node = $this->hash_table->search($node->element);
        if (!$search_node) {
            return false;
        }
        $this->hash_table->delete($node->element);
        return $this->skip_list->delete($search_node);
    }

    public function traverse(Closure $visit)
    {
        $result = [];
        $level  = $this->skip_list->level;
        while ($level >= 0) {
            $node = $this->skip_list->head->level[$level]->forward;
            while ($node) {
                $result[$level][$node->score] = $node->level[$level]->span;
                $node                         = $node->level[$level]->forward;
            }
            $level--;
        }
        return $result;
    }
}
