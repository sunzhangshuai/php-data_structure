<?php
/**
 * StringInterface.php :
 *
 * PHP version 7.1
 *
 * @category StringInterface
 * @package  App\String\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\String\Interfaces;

/**
 * 串接口
 * Interface StringInterface
 *
 * @package App\String\Interfaces
 */
interface StringInterface
{
    /**
     * 根据chars初始化串
     *
     * @param string $chars
     */
    public function __construct(string $chars);

    /**
     * 复制串string
     *
     * @param StringInterface $string
     */
    public function strCopy($string);

    /**
     * 判断串是否为空
     *
     * @return boolean
     */
    public function strEmpty();

    /**
     * 比较和串string的大小  大于：>0；等于：相等；小于：<0
     *
     * @param StringInterface $string
     *
     * @return int
     */
    public function strCompare($string);

    /**
     * 获取串长
     *
     * @return int
     */
    public function strLength();

    /**
     * 清空串
     */
    public function clearString();

    /**
     * 返回串拼接string的字符串
     *
     * @param StringInterface $string
     *
     * @return StringInterface
     */
    public function concat($string);

    /**
     * 从pos位置开始截取串中长度为len的子串
     *
     * @param int $pos
     * @param int $len
     *
     * @return StringInterface
     */
    public function subString($pos, $len);

    /**
     * 返回子串sting在串中的第一次出现位置，没有返回0
     *
     * @param StringInterface $subject
     * @param int             $pos
     *
     * @return int
     */
    public function index($subject, $pos);

    /**
     * 用subject替换串中所有的与replace相等的不重叠的子串
     *
     * @param StringInterface $replace
     * @param StringInterface $subject
     */
    public function replace($replace, $subject);

    /**
     * 在串的第pos个字符之前插入subject串
     *
     * @param int             $pos
     * @param StringInterface $subject
     */
    public function strInsert($pos, $subject);

    /**
     * 在串中删除第pos个字符起，长度为len的子串
     *
     * @param int $pos
     * @param int $len
     */
    public function strDelete($pos, $len);

    /**
     * 将串对象通过string的格式返回
     *
     * @return string
     */
    public function __toString();
}
