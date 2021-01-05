<?php
/**
 * Term.php :
 *
 * PHP version 7.1
 *
 * @category Term
 * @package  DataStructure\Listss\Model
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists\Model;


class Term
{
    /**
     * @var int 系数
     */
    public $coef;

    /**
     * @var int 指数
     */
    public $expn;

    /**
     * Term constructor.
     *
     * @param $coef
     * @param $expn
     */
    public function __construct($coef, $expn)
    {
        $this->coef = $coef;
        $this->expn = $expn;
    }
}
