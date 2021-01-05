<?php
/**
 * SequenceBinaryTree.php :
 *
 * PHP version 7.1
 *
 * @category SequenceBinaryTree
 * @package  DataStructure\Tree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree;

use DataStructure\Tree\BinaryTree\Model\BinaryTreeNode;
use Closure;
use Exception;

/**
 * SequenceBinaryTree : 顺序存储二叉树
 *
 * @category SequenceBinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class SequenceBinaryTree extends AbstractBinaryTree
{
    /**
     * @var BinaryTreeNode[]
     */
    public $nodes;

    /**
     * @var int
     */
    const MAX_TREE_SIZE = 100;

    /**
     * @inheritDoc
     */
    public function __construct($array)
    {
        $this->nodes = array_fill(0, self::MAX_TREE_SIZE, null);
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] !== 0) {
                $this->nodes[$i] = new BinaryTreeNode($array[$i]);
            }
        }
        parent::__construct($array);
    }

    /**
     * @inheritDoc
     */
    public function clearBiTree()
    {
        $this->nodes[0] = null;
    }

    /**
     * @inheritDoc
     */
    public function biTreeDepth()
    {
        return $this->getDepthByLocate(0);
    }

    /**
     * 通过下标求深度
     *
     * @param $locate
     *
     * @return int
     */
    protected function getDepthByLocate($locate)
    {
        if ($locate >= self::MAX_TREE_SIZE || $this->nodes[$locate] === null) return 0;
        $left_locate  = ($locate + 1) * 2 - 1;
        $right_locate = ($locate + 1) * 2;
        $left_depth   = $this->getDepthByLocate($left_locate);
        $right_depth  = $this->getDepthByLocate($right_locate);
        return max($left_depth, $right_depth) + 1;
    }

    /**
     * @inheritDoc
     */
    public function root()
    {
        return $this->nodes[0];
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function parent($node)
    {
        $index = $this->locate($node);
        if ($index === 0) {
            throw new Exception('没有父节点');
        }
        return floor(($index - 1) / 2);
    }

    /**
     * @inheritDoc
     */
    public function leftChild($node)
    {
        $locate = $this->locate($node);
        if ($this->getLeftChildLocateByLocate($locate) > self::MAX_TREE_SIZE - 1) {
            return null;
        }
        return $this->nodes[$this->getLeftChildLocateByLocate($locate)];
    }

    /**
     * @inheritDoc
     */
    public function rightChild($node)
    {
        $locate = $this->locate($node);
        if ($this->getRightChildLocateByLocate($locate) > self::MAX_TREE_SIZE - 1) {
            return null;
        }
        return $this->nodes[$this->getRightChildLocateByLocate($locate)];
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function leftSibling($node)
    {
        $index = $this->locate($node);
        if ($index == 0 || $index % 2 === 1) {
            throw new Exception('没有左兄弟');
        }
        return $this->nodes[$index - 1];
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function rightSibling($node)
    {
        $index = $this->locate($node);
        if ($index % 2 === 0) {
            throw new Exception('没有右兄弟');
        }
        return $this->nodes[$index + 1];
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function insertChild($node, $child_type, $new_node)
    {
//        $locate       = $this->locate($node);
//        $child_locate = $child_type === 0
//            ? $this->getLeftChildLocateByLocate($locate)
//            : $this->getRightChildLocateByLocate($locate);
//
//        if ($child_locate >= self::MAX_TREE_SIZE) {
//            throw new Exception('内存溢出');
//        }
//        $this->nodes[$child_locate] = $new_node;
    }

    /**
     * @inheritDoc
     */
    public function deleteChild($node, $child_type)
    {
        $locate       = $this->locate($node);
        $child_locate = $child_type === 0
            ? $this->getLeftChildLocateByLocate($locate)
            : $this->getRightChildLocateByLocate($locate);

        if ($child_locate >= self::MAX_TREE_SIZE) {
            return null;
        }
        $result                     = $this->nodes[$child_locate];
        $this->nodes[$child_locate] = null;
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function preOrderTraverse(Closure $visit)
    {
        $this->preOrderByLocate(0, $visit);
    }

    /**
     * 通过下标先序遍历
     *
     * @param int     $locate
     * @param Closure $visit
     */
    protected function preOrderByLocate($locate, Closure $visit)
    {
        if ($locate >= self::MAX_TREE_SIZE || $this->nodes[$locate] === null) return;
        $visit($this->nodes[$locate]->data);
        $this->preOrderByLocate($this->getLeftChildLocateByLocate($locate), $visit);
        $this->preOrderByLocate($this->getRightChildLocateByLocate($locate), $visit);
    }

    /**
     * @inheritDoc
     */
    public function inOrderTraverse(Closure $visit)
    {
        $this->inOrderByLocate(0, $visit);
    }

    /**
     * 通过下标中序遍历
     *
     * @param int     $locate
     * @param Closure $visit
     */
    protected function inOrderByLocate($locate, Closure $visit)
    {
        if ($locate >= self::MAX_TREE_SIZE || $this->nodes[$locate] === null) return;
        $this->inOrderByLocate($this->getLeftChildLocateByLocate($locate), $visit);
        $visit($this->nodes[$locate]->data);
        $this->inOrderByLocate($this->getRightChildLocateByLocate($locate), $visit);
    }

    /**
     * @inheritDoc
     */
    public function postOrderTraverse(Closure $visit)
    {
        $this->postOrderByLocate(0, $visit);
    }

    /**
     * 通过下标后序遍历
     *
     * @param int     $locate
     * @param Closure $visit
     */
    protected function postOrderByLocate($locate, Closure $visit)
    {
        if ($locate >= self::MAX_TREE_SIZE || $this->nodes[$locate] === null) return;
        $this->postOrderByLocate($this->getLeftChildLocateByLocate($locate), $visit);
        $this->postOrderByLocate($this->getRightChildLocateByLocate($locate), $visit);
        $visit($this->nodes[$locate]->data);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function levelOrderTraverse(Closure $visit)
    {
        if ($this->BiTreeEmpty()) {
            return;
        }
        $this->queue->clearQueue();
        $this->queue->enQueue(0);
        while (!$this->queue->queueEmpty()) {
            $locate = $this->queue->deQueue();
            $visit($this->nodes[$locate]->data);

            $left_locate  = $this->getLeftChildLocateByLocate($locate);
            $right_locate = $this->getRightChildLocateByLocate($locate);
            if ($left_locate < self::MAX_TREE_SIZE && $this->nodes[$left_locate] !== null) {
                $this->queue->enQueue($left_locate);
            }
            if ($right_locate < self::MAX_TREE_SIZE && $this->nodes[$right_locate] !== null) {
                $this->queue->enQueue($right_locate);
            }
        }
    }

    /**
     * 通过下标获取左孩子下标
     *
     * @param $locate
     *
     * @return float|int
     */
    public function getLeftChildLocateByLocate($locate)
    {
        return ($locate + 1) * 2 - 1;
    }

    /**
     * 通过下标获取右孩子下标
     *
     * @param $locate
     *
     * @return float|int
     */
    public function getRightChildLocateByLocate($locate)
    {
        return ($locate + 1) * 2;
    }

    /**
     * 获取node节点的下标
     *
     * @param BinaryTreeNode $node
     *
     * @return int
     */
    protected function locate($node)
    {
        // 获取node节点的下标
        for ($index = 0; $index < self::MAX_TREE_SIZE; $index++) {
            if ($node === $this->nodes[$index]) {
                break;
            }
        }
        return $index;
    }
}
