<?php

namespace DataStructure\String;

use DataStructure\String\Interfaces\StringInterface;
use Exception;

/**
 * SequenceString.php :
 *
 * PHP version 7.1
 *
 * @category SequenceString
 * @package  ${NAMESPACE}
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class SequenceString implements StringInterface
{
    /**
     * 字符串最大长度
     */
    const MAX_STRING_LENGTH = 255;

    /**
     * @var string 串
     */
    public $chars;

    /**
     * @inheritDoc
     */
    public function __construct(string $chars = '')
    {
        $length         = min(strlen($chars), self::MAX_STRING_LENGTH);
        $this->chars[0] = chr($length);
        for ($i = 0; $i < $length; $i++) {
            $this->chars[$i + 1] = $chars[$i];
        }
    }

    /**
     * @param SequenceString $string
     *
     * @inheritDoc
     */
    public function strCopy($string)
    {
        $length = $string->strLength();
        for ($i = 0; $i <= $length; $i++) {
            $this->chars[$i] = $string->chars[$i];
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
     * @param SequenceString $string
     *
     * @inheritDoc
     */
    public function strCompare($string)
    {
        $length     = $this->strLength();
        $str_length = $string->strLength();
        $i          = 1;
        while ($i <= $length && $i <= $str_length) {
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
        return ord($this->chars[0]);
    }

    /**
     * @inheritDoc
     */
    public function clearString()
    {
        $this->chars[0] = chr(0);
    }

    /**
     * @param SequenceString $string
     *
     * @inheritDoc
     */
    public function concat($string)
    {
        $result = new SequenceString();
        $result->strCopy($this);

        $length           = min($string->strLength() + $result->strLength(), self::MAX_STRING_LENGTH);
        $result->chars[0] = chr($length);
        for ($i = $this->strLength() + 1; $i <= $length; $i++) {
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
        $result           = new SequenceString();
        $result->chars[0] = chr($len);
        for ($i = 1; $i <= $len; $i++) {
            $result->chars[$i] = $this->chars[$i + $pos - 1];
        }
        return $result;
    }

    /**
     * @param SequenceString $subject
     *
     * @inheritDoc
     * @throws Exception
     */
    public function index($subject, $pos)
    {
        $length  = $this->strLength();
        $sub_len = $subject->strLength();
        if ($pos < 1 || $pos > $length - $sub_len + 1) {
            throw new Exception('pos非法');
        }
        for ($i = $pos; $i <= $length - $sub_len + 1; $i++) {
            for ($j = 1; $j <= $sub_len; $j++) {
                if ($this->chars[$i + $j - 1] !== $subject->chars[$j]) {
                    break;
                }
            }
            if ($j > $sub_len) return $i;
        }
        return 0;
    }

    /**
     * @param SequenceString $replace
     * @param SequenceString $subject
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
                $index = $this->index($replace, $index + $subject_length);
            }
        } catch (Exception $exception) {
        }
    }

    /**
     * @param SequenceString $subject
     *
     * @inheritDoc
     * @throws Exception
     */
    public function strInsert($pos, $subject)
    {
        $length     = $this->strLength();
        $sub_length = $subject->strLength();
        if ($pos < 1 || $pos > $length + 1) {
            throw new Exception('参数有误');
        }
        $new_length     = min($length + $sub_length, self::MAX_STRING_LENGTH);
        $set_index      = min($pos + $sub_length - 1, self::MAX_STRING_LENGTH);
        $this->chars[0] = chr($new_length);
        // 1. 先把pos位置之后的后移 sub_length 长度
        for ($i = $new_length; $i >= $set_index; $i--) {
            $this->chars[$i] = $this->chars[$i - $sub_length];
        }
        // 2. 在把subject放进去
        for ($i = $pos; $i <= $set_index; $i++) {
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
        if ($pos < 1 || $len < 0) {
            throw new Exception('参数不合法');
        }
        if ($pos + $len - 1 > $length) $len = $length - $pos + 1;

        for ($i = $pos; $i <= $length - $len; $i++) {
            $this->chars[$i] = $this->chars[$i + $len];
        }
        $this->chars[0] = chr($length - $len);
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $length = $this->strLength();
        $result = '';
        for ($i = 1; $i <= $length; $i++) {
            $result .= $this->chars[$i];
        }
        return $result;
    }
}
