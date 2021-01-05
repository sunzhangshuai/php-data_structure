<?php
/**
 * ArrayInterface.php :
 *
 * PHP version 7.1
 *
 * @category ArrayInterface
 * @package  ${NAMESPACE}
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\ArrayImpl\Interfaces;

interface ArrayInterface
{
    /**
     * 数组初始化
     * ArrayInterface constructor.
     *
     * @param int   $dim    维数
     * @param array $bounds 每维元素的最大值
     */
    public function __construct(int $dim, array $bounds);

    /**
     * 数组赋值
     *
     * @param       $e
     * @param array $poss 下标数组
     */
    public function value($e, array $poss);

    /**
     * 获取数组的元素
     *
     * @param array $poss 下标数组
     *
     * @return mixed
     */
    public function assign(array $poss);

    /**
     * 获取标准数组
     *
     * @return array
     */
    public function toArray();
}
