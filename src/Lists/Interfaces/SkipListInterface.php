<?php
/**
 * SkipListInterface.php :
 *
 * PHP version 7.1
 *
 * @category SkipListInterface
 * @package  DataStructure\Lists\Interfaces
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Lists\Interfaces;


use DataStructure\SearchTable\Model\SkipNode;
use Closure;

/**
 * 跳表
 *
 * Interface SkipListInterface
 *
 * @package DataStructure\Lists\Interfaces
 */
interface SkipListInterface
{
    public function __construct();

    public function clearList();

    public function search(SkipNode $node, Closure $callback);

    public function insert(SkipNode $node);

    public function delete(SkipNode $node);

    public function traverse(SkipNode $node, Closure $callback);
}
