<?php
/**
 * HeapString.php :
 *
 * PHP version 7.1
 *
 * @category HeapString
 * @package  DataStructure\String
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\String;


use DataStructure\String\Interfaces\StringInterface;
use Exception;

class HeapString implements StringInterface
{
    /**
     * @var string 串
     */
    public $chars;

    /**
     * @var int 长度
     */
    public $length;

    /**
     * @inheritDoc
     */
    public function __construct(string $chars = '')
    {
        $this->chars  = $chars;
        $this->length = strlen($chars);
    }

    /**
     * @param HeapString $string
     *
     * @inheritDoc
     */
    public function strCopy($string)
    {
        for ($i = 0; $i < $string->length; $i++) {
            $this->chars[$i] = $string->chars[$i];
        }
        $this->length = $string->length;
    }

    /**
     * @inheritDoc
     */
    public function strEmpty()
    {
        return $this->strLength() === 0;
    }

    /**
     * @param HeapString $string
     *
     * @inheritDoc
     */
    public function strCompare($string)
    {
        $length     = $this->strLength();
        $str_length = $string->strLength();
        $i          = 0;
        while ($i < $length && $i < $str_length) {
            if ($this->chars[$i] !== $string->chars[$i]) {
                return ord($this->chars[$i]) - ord($string->chars[$i]);
            }
            $i++;
        }
        return $this->strLength() - $string->strLength();
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
        $this->chars  = '';
        $this->length = 0;
    }

    /**
     * @param HeapString $string
     *
     * @inheritDoc
     */
    public function concat($string)
    {
        $result = new HeapString();
        $result->strCopy($this);
        $result->length = $string->strLength() + $result->strLength();
        for ($i = $this->strLength(); $i < $result->length; $i++) {
            $result->chars[$i] = $string->chars[$i - $this->strLength()];
        }
        return $result;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function subString($pos, $len)
    {
        if ($pos < 1 || $pos + $len - 1 > $this->strLength() || $len < 0) {
            throw new Exception('参数不合法');
        }
        $result         = new HeapString();
        $result->length = $len;
        for ($i = 0; $i < $len; $i++) {
            $result->chars[$i] = $this->chars[$i + $pos - 1];
        }
        return $result;
    }

    /**
     * @inheritDoc
     *
     * @param HeapString $subject
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
        for ($i = 0; $i <= $length - $sub_len; $i++) {
            for ($j = 0; $j < $sub_len; $j++) {
                if ($this->chars[$i + $j] !== $subject->chars[$j]) {
                    break;
                }
            }
            if ($j === $sub_len) return $i + 1;
        }
        return 0;
    }

    /**
     * @param HeapString $replace
     * @param HeapString $subject
     *
     * @inheritDoc
     * @throws Exception
     */
    public function replace($replace, $subject)
    {
        $replace_length = $replace->strLength();
        $subject_length = $replace->strLength();
        $index          = $this->index($replace, 1);
        try {
            while ($index) {
                $this->strDelete($index, $replace_length);
                $this->strInsert($index, $subject);
                $index = $index + $subject_length;
                $index = $this->index($replace, $index);
            }
        } catch (Exception $exception) {
        }
    }

    /**
     * @param HeapString $subject
     *
     * @inheritDoc
     * @throws Exception
     */
    public function strInsert($pos, $subject)
    {
        // php自动扩容
        if ($pos < 1 || $pos > $this->strLength() + 1) {
            throw new Exception('参数有误');
        }
        $set_index    = $pos + $subject->strLength() - 1;
        $this->length = $this->strLength() + $subject->strLength();
        // 1. 先把pos位置之后的后移 sub_length 长度
        for ($i = $this->strLength() - 1; $i >= $set_index; $i--) {
            $this->chars[$i] = $this->chars[$i - $subject->strLength()];
        }
        // 2. 把subject插进去
        for ($i = $pos - 1; $i < $set_index; $i++) {
            $this->chars[$i] = $subject->chars[$i - $pos + 1];
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function strDelete($pos, $len)
    {
        $length = $this->strLength();
        if ($pos < 1 || $pos + $len - 1 > $length || $len < 0) {
            throw new Exception('参数不合法');
        }
        if ($pos + $len - 1 > $length) $len = $length - $pos + 1;

        for ($i = $pos - 1; $i < $length - $len; $i++) {
            $this->chars[$i] = $this->chars[$i + $len];
        }
        $this->length = $length - $len;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $result = '';
        for ($i = 0; $i < $this->strLength(); $i++) {
            $result .= $this->chars[$i];
        }
        return $result;
    }
}
