<?php
/**
 * LinkedString.php :
 *
 * PHP version 7.1
 *
 * @category LinkedString
 * @package  DataStructure\String
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\String;


use DataStructure\String\Model\ChunkNode;
use DataStructure\String\Interfaces\StringInterface;
use Exception;

class LinkedString implements StringInterface
{
    /**
     * 块的大小
     */
    const CHUNK_SIZE = 3;

    /**
     * @var ChunkNode 块链头结点
     */
    public $head;

    /**
     * @var ChunkNode 块链尾节点
     */
    public $tail;

    /**
     * @var int 字符串长度
     */
    public $length;

    /**
     * @inheritDoc
     */
    public function __construct(string $chars = '')
    {
        $length       = strlen($chars);
        $this->head   = $this->tail = null;
        $this->length = $length;
        for ($i = 0; $i < $length; $i += self::CHUNK_SIZE) {
            $string = '';
            for ($j = $i; $j < $i + self::CHUNK_SIZE; $j++) {
                $string .= $j < $length ? $chars[$j] : '#';
            }
            $node = new ChunkNode($string);
            if ($i === 0) {
                $this->head = $this->tail = $node;
            } else {
                $this->tail->next = $node;
                $this->tail       = $node;
            }
        }
    }

    /**
     * @param LinkedString $string
     *
     * @inheritDoc
     */
    public function strCopy($string)
    {
        $this->length = $string->strLength();
        $node         = $string->head;
        if (!$this->strLength() === 0) {
            $this->head = $this->tail = null;
            return;
        }
        $this->head = new ChunkNode($node->chars);
        $this->tail = $this->head;
        $node       = $node->next;
        while ($node) {
            $new_node         = new ChunkNode($node->chars);
            $this->tail->next = $new_node;
            $this->tail       = $new_node;
            $node             = $node->next;
        }
    }

    /**
     * @inheritDoc
     */
    public function strEmpty()
    {
        return $this->strLength() === 0;
    }

    /**
     * @param LinkedString $string
     *
     * @inheritDoc
     */
    public function strCompare($string)
    {
        return $this->compare($string, $this->head, 0, $this->strLength());
    }

    /**
     * @inheritDoc
     */
    public function strLength()
    {
        return $this->length;
    }

    /**
     * @inheritDoc
     */
    public function clearString()
    {
        $this->length = 0;
        $this->head   = $this->tail = null;
    }

    /**
     * @param LinkedString $string
     *
     * @inheritDoc
     */
    public function concat($string)
    {
        $result = new LinkedString();
        $result->strCopy($this);
        $result->append($string->head, 0, $string->strLength());
        return $result;
    }

    /**
     * @inheritDoc
     * @return LinkedString
     * @throws Exception
     */
    public function subString($pos, $len)
    {
        if ($pos < 1 || $pos + $len - 1 > $this->strLength() || $len < 0) {
            throw new Exception('参数不合法');
        }
        $result = new LinkedString();
        $this->getNodeAndIndexByPos($pos, $node, $index);
        $result->append($node, $index, $len);
        return $result;
    }

    /**
     * @inheritDoc
     *
     * @param LinkedString $subject
     *
     * @throws Exception
     */
    public function index($subject, $pos)
    {
        $length  = $this->strLength();
        $sub_len = $subject->strLength();
        if ($pos < 1 || $pos > $length - $sub_len + 1) {
            throw new Exception('pos非法');
        }
        $this->getNodeAndIndexByPos($pos, $node, $index);
        $strand_count = 0;
        while ($node) {
            for ($i = $index; $i < self::CHUNK_SIZE; $i++) {
                $strand_count++;
                // 只比较固定的串数
                if ($strand_count > $length - $sub_len - $pos + 2) return 0;
                if ($this->compare($subject, $node, $i, $subject->strLength()) === 0) return $strand_count + $pos - 1;
            }
            $index = 0;
            $node  = $node->next;
        }
        return 0;
    }

    /**
     * @inheritDoc
     *
     * @param LinkedString $replace
     * @param LinkedString $subject
     *
     * @throws Exception
     */
    public function replace($replace, $subject)
    {
        $index = $this->index($replace, 1);
        try {
            while ($index) {
                $this->strDelete($index, $replace->strLength());
                $this->strInsert($index, $subject);
                $index = $this->index($replace, $index + $subject->strLength());
            }
        } catch (Exception $exception) {
        }
    }

    /**
     * @inheritDoc
     *
     * @param LinkedString $subject
     */
    public function strInsert($pos, $subject)
    {
        if ($pos === 1) {
            $next_node  = $this->head;
            $index      = 0;
            $this->head = $this->tail = null;
        } else {
            $this->getNodeAndIndexByPos($pos, $node, $index);
            if ($index === 0) {
                $next_node = $node;
                $this->getNodeAndIndexByPos($pos - 1, $node, $pre_index);
            } else {
                $next_node       = new ChunkNode($node->chars);
                $next_node->next = $node->next;
            }
            // 将字符串自pos位置断开
            $node->next = null;
            $this->tail = $node;
        }
        $other_length = $this->length - $pos + 1;
        $this->length = $pos - 1;
        $this->append($subject->head, 0, $subject->strLength());
        $this->append($next_node, $index, $other_length);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function strDelete($pos, $len)
    {
        if ($pos < 1 || $len < 0 || $pos + $len - 1 > $this->strLength()) {
            throw new Exception('参数不合法');
        }
        // 获取（pos + len - 1）位置对应的节点和所在节点的下标
        $this->getNodeAndIndexByPos($pos + $len, $next_node, $next_index);

        if ($pos === 1) {
            $this->head = $this->tail = null;
        } else {
            // 获取pos位置对应的节点和所在节点的下标
            $this->getNodeAndIndexByPos($pos, $node, $index);
            if ($index === 0) {
                $this->getNodeAndIndexByPos($pos - 1, $node, $pre_index);
            }
            // 如果（pos + len - 1）位置和pos位置对应的节点是同一个，需要拷贝出一个新的节点
            if ($next_node === $node) {
                $next_node       = new ChunkNode($node->chars);
                $next_node->next = $node->next;
            }
            $node->next = null;
            $this->tail = $node;
        }
        $other_length = $this->length - ($pos + $len - 1);
        $this->length = $pos - 1;
        $this->append($next_node, $next_index, $other_length);
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $node      = $this->head;
        $len_index = 0;
        $result    = '';
        while ($node) {
            for ($i = 0; $i < self::CHUNK_SIZE; $i++) {
                if ($len_index === $this->strLength()) return $result;
                $result .= $node->chars[$i];
                $len_index++;
            }
            $node = $node->next;
        }
        return $result;
    }

    /**
     * 根据pos位置获取该位置所在的node和在node中的下标
     *
     * @param int       $pos
     * @param ChunkNode $node
     * @param int       $index
     */
    private function getNodeAndIndexByPos($pos, &$node, &$index)
    {
        // 找到$pos的具体位置
        $node_count = (int)(ceil($pos / self::CHUNK_SIZE));
        $node       = $this->head;
        $node_index = 0;
        while ($node) {
            $node_index++;
            if ($node_index === $node_count) break;
            $node = $node->next;

        }
        $index = ($pos - 1) % self::CHUNK_SIZE;
    }

    /**
     * 从node节点的node_index下标开始，前缀是否和subject相等
     *
     * @param LinkedString $string
     * @param ChunkNode    $node
     * @param int          $node_index
     *
     * @param int          $length
     *
     * @return int
     */
    private function compare(LinkedString $string, ChunkNode $node, int $node_index, int $length)
    {
        $sub_len      = $string->strLength();
        $sub_node     = $string->head;
        $length_index = 0;
        while ($sub_node) {
            for ($i = 0; $i < self::CHUNK_SIZE; $i++, $length_index++, $node_index++) {
                if ($length_index >= $length || $length_index >= $sub_len) return $length - $sub_len;
                if ($node_index === self::CHUNK_SIZE) {
                    $node       = $node->next;
                    $node_index = 0;
                }
                if ($node->chars[$node_index] !== $sub_node->chars[$i]) {
                    return ord($node->chars[$node_index]) - ord($sub_node->chars[$i]);
                }
            }
            $sub_node = $sub_node->next;
        }
        return $length - $sub_len;
    }

    /**
     * 向字符串尾部追加从node节点的node_index下标开始，length长度的字符
     *
     * @param ChunkNode|null $node
     * @param int            $node_index
     * @param int            $length
     */
    private function append($node, int $node_index, int $length)
    {
        $tail_index = $this->strLength() % self::CHUNK_SIZE;
        $len_index  = 0;
        while ($node) {
            for ($i = $node_index; $i < self::CHUNK_SIZE; $i++) {
                $len_index++;
                if ($len_index > $length) break;
                if ($tail_index === self::CHUNK_SIZE) $tail_index = 0;
                if ($tail_index === 0) {
                    $new_node = new ChunkNode();
                    if (!$this->head) {
                        $this->head = $this->tail = $new_node;
                    } else {
                        $this->tail->next = $new_node;
                        $this->tail       = $new_node;
                    }
                }
                $this->tail->chars[$tail_index] = $node->chars[$i];
                $tail_index++;
            }
            $node_index = 0;
            if ($i !== self::CHUNK_SIZE) break;
            $node = $node->next;
        }
        if ($tail_index !== 0 && $tail_index !== self::CHUNK_SIZE) {
            for ($i = $tail_index; $i < self::CHUNK_SIZE; $i++) {
                $this->tail->chars[$i] = '#';
            }
        }
        $this->length += $length;
    }
}
