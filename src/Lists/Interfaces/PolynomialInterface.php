<?php
/**
 * PolynomialInterface.php :
 *
 * PHP version 7.1
 *
 * @category PolynomialInterface
 * @package  DataStructure\Listss\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists\Interfaces;


use App\Algorithm\Lists\Polynomial;

interface PolynomialInterface
{
    /**
     * 一元多项式长度
     * @return int
     */
    public function polynLength();

    /**
     * 一元多项式相加
     * @param Polynomial $polynomial
     *
     * @return mixed
     */
    public function addPolyn(Polynomial $polynomial);

    /**
     * 一元多项式相减
     * @return mixed
     */
    public function subtractPolyn(Polynomial $polynomial);

    /**
     * 一元多项式相乘
     * @return mixed
     */
    public function multiplyPolyn(Polynomial $polynomial);
}
