<?php
/**
 * BalanceBinaryTree.php :
 *
 * PHP version 7.1
 *
 * @category BalanceBinaryTree
 * @package  DataStructure\Tree\BinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */

namespace DataStructure\Tree\BinaryTree;

use DataStructure\Stack\SequenceStack;
use DataStructure\Tree\BinaryTree\Model\BalanceBinaryTreeNode;
use Exception;

/**
 * BalanceBinaryTree : 平衡二叉树
 *
 * @category BalanceBinaryTree
 * @author   zhangshuai <zhangshaui1134@gmail.com>
 */
class BalanceBinaryTree extends BinarySortTree
{
    /**
     * @var boolean 树是否长高
     */
    public $tallier;

    /**
     * @var boolean 树是否降低
     */
    public $low;

    /**
     * 节点删除或新增的方向
     *
     * @var int 0左1右
     */
    public $direction;

    /**
     * @var BalanceBinaryTreeNode
     */
    public $root;

    /**
     * @var boolean 是否有外部查找
     */
    public $external_search;

    /**
     * 获取父节点
     *
     * @param BalanceBinaryTreeNode $node
     *
     * @return BalanceBinaryTreeNode
     * @throws Exception
     */
    public function parent($node)
    {
        if ($this->root() === $node) {
            throw new Exception('node节点没有父节点');
        }
        $this->stack->clearStack();
        $this->stack->push($this->root());

        while (!$this->stack->stackEmpty()) {
            $cur = $this->stack->pop();
            if ($cur->r_child === $node || $cur->l_child === $node) {
                $this->stack->push($cur);
                return $cur;
            }
            if ($cur->r_child != null) $this->stack->push($cur->r_child);
            if ($cur->l_child != null) $this->stack->push($cur->l_child);
        }
        throw new Exception('node节点没有父节点');
    }

    /**
     * 初始化
     * BinarySortTree constructor.
     *
     * @param array $array
     */
    public function __construct($array = [])
    {
        $this->stack = new SequenceStack();
        $this->root  = null;
    }

    /**
     * 设置根节点
     *
     * @param BalanceBinaryTreeNode $node
     */
    public function setRoot($node)
    {
        parent::setRoot($node);
        $node->balance_factor = BalanceBinaryTreeNode::EH;
    }

    /**
     * 删除根节点
     *
     * @throws Exception
     */
    public function deleteRoot()
    {
        // 如果孩子是null，不做任何处理
        if ($this->root === null) {
            return;
        }
        if (!$this->root->r_child && !$this->root->l_child) {
            $this->root = null;
            return;
        } else {
            $this->deleteNode($this->root);
        }
        $this->deleteBalance();
    }

    /**
     * @inheritDoc
     *
     * @param BalanceBinaryTreeNode $new_node
     *
     * @throws Exception
     */
    public function insertChild($node, $child_type, $new_node)
    {
        $this->direction = $child_type;
        parent::insertChild($node, $child_type, $new_node);
        $new_node->balance_factor = BalanceBinaryTreeNode::EH;
        if (!$this->external_search) {
            $this->parent($new_node);
        }
        // 平衡
        $this->insertBalance();
    }

    /**
     * @inheritDoc
     *
     * @param BalanceBinaryTreeNode $node
     *
     * @throws Exception
     */
    public function deleteChild($node, $child_type)
    {
        $child_node = $child_type === self::LEFT ? $node->l_child : $node->r_child;
        if (!$this->external_search) {
            $this->parent($child_node);
        }
        $this->direction = $child_type;
        // 如果孩子是null，不做任何处理
        if ($child_node === null) {
            return;
        }
        if (!$child_node->r_child && !$child_node->l_child) {// 孩子是原子节点，删除孩子本身
            $child_type === self::LEFT ? $node->l_child = null : $node->r_child = null;
        } else {// 孩子是非原子节点，转化为删除孩子的前驱或后继
            $this->deleteNode($child_node);
        }
        $this->deleteBalance();
    }

    /**
     * 插入平衡
     *
     * @throws Exception
     */
    protected function insertBalance()
    {
        $this->tallier = true;
        // 栈中元素为查找到新插入的所有祖先节点
        while (!$this->stack->stackEmpty() && $this->tallier) {
            /** @var BalanceBinaryTreeNode $node */
            $node = $this->stack->pop();
            switch ($this->direction) {
                case self::LEFT:// 向node节点的左子树插入节点
                    switch ($node->balance_factor) {
                        case BalanceBinaryTreeNode::LH:
                            // 原树左边高，再向其左子树插入节点，导致該树失衡，需要平衡左子树
                            if ($this->stack->stackEmpty()) {
                                $this->root = $this->leftBalance($node);
                            } else {
                                /** @var BalanceBinaryTreeNode $parent */
                                $parent = $this->stack->getTop();
                                if ($parent->l_child === $node) {
                                    $parent->l_child = $this->leftBalance($node);
                                } else {
                                    $parent->r_child = $this->leftBalance($node);
                                }
                            }
                            // 平衡过程中会设置平衡因子，平衡后的树不会长高
                            $this->tallier = false;
                            break;
                        case BalanceBinaryTreeNode::EH:
                            $node->balance_factor = BalanceBinaryTreeNode::LH;
                            $this->tallier        = true;
                            break;
                        case BalanceBinaryTreeNode::RH:
                            $node->balance_factor = BalanceBinaryTreeNode::EH;
                            $this->tallier        = false;
                            break;
                    }
                    break;
                case self::RIGHT:// 向node节点的右子树插入节点
                    switch ($node->balance_factor) {
                        case BalanceBinaryTreeNode::LH:
                            $node->balance_factor = BalanceBinaryTreeNode::EH;
                            $this->tallier        = false;
                            break;
                        case BalanceBinaryTreeNode::EH:
                            $node->balance_factor = BalanceBinaryTreeNode::RH;
                            $this->tallier        = true;
                            break;
                        case BalanceBinaryTreeNode::RH:
                            // 原树右边高，再向其右子树插入节点，导致該树失衡，需要平衡右子树
                            if ($this->stack->stackEmpty()) {
                                $this->root = $this->rightBalance($node);
                            } else {
                                /** @var BalanceBinaryTreeNode $parent */
                                $parent = $this->stack->getTop();
                                if ($parent->l_child === $node) {
                                    $parent->l_child = $this->rightBalance($node);
                                } else {
                                    $parent->r_child = $this->rightBalance($node);
                                }
                            }
                            // 平衡过程中会设置平衡因子，平衡后的树不会长高
                            $this->tallier = false;
                            break;
                    }
                    break;
            }
            if (!$this->stack->stackEmpty()) {
                /** @var BalanceBinaryTreeNode $parent_node */
                $parent_node     = $this->stack->getTop();
                $this->direction = $parent_node->l_child === $node ? self::LEFT : self::RIGHT;
            }
        }
    }

    /**
     * 删除并获取节点最终删除的方向
     *
     * @param BalanceBinaryTreeNode $node
     */
    public function deleteNode($node)
    {
        // 非原子节点不删自己本身，删除其子树中的节点，本身的平衡因子要发生变化
        $this->stack->push($node);
        if (!$node->r_child) {// 2. 没有右孩子
            $this->direction = self::LEFT;
            $node->copyTo($node->l_child);
        } elseif (!$node->l_child) {// 3. 没有左孩子
            $this->direction = self::RIGHT;
            $node->copyTo($node->r_child);
        } else {// 4.有左右孩子
            switch ($node->balance_factor) {
                case BalanceBinaryTreeNode::LH:
                case BalanceBinaryTreeNode::EH:
                    // 找前驱节点，顺带找到前驱节点的父节点
                    $pre_parent = $node;
                    $pre        = $node->l_child;
                    while ($pre->r_child) {
                        $pre_parent = $pre;
                        $this->stack->push($pre_parent);
                        $pre = $pre->r_child;
                    }
                    // 如果前驱的父节点是要删除的节点
                    if ($pre_parent === $node) {
                        $this->direction = self::LEFT;
                        $node->data      = $node->l_child->data;
                        $node->l_child   = $node->l_child->l_child;
                    } else {
                        $this->direction = self::RIGHT;
                        $node->data      = $pre->data;
                        // 前驱节点的父节点的右指针指向前驱的左结点
                        $pre_parent->r_child = $pre->l_child;
                    }
                    break;
                case BalanceBinaryTreeNode::RH:
                    // 找后继节点，顺带找到前驱节点的父节点
                    $pre_parent = $node;
                    $pre        = $node->r_child;
                    while ($pre->l_child) {
                        $pre_parent = $pre;
                        $this->stack->push($pre_parent);
                        $pre = $pre->l_child;
                    }
                    // 如果前驱的父节点是要删除的节点
                    if ($pre_parent === $node) {
                        $this->direction = self::RIGHT;
                        $node->data      = $node->r_child->data;
                        $node->r_child   = $node->r_child->l_child;
                    } else {
                        $this->direction = self::LEFT;
                        $node->data      = $pre->data;
                        // 前驱节点的父节点的右指针指向前驱的左结点
                        $pre_parent->l_child = $pre->r_child;
                    }
                    break;
            }
        }
    }

    /**
     * 删除平衡
     *
     * @throws Exception
     */
    protected function deleteBalance()
    {
        $this->low = true;
        // 栈中元素为查找到新插入的所有祖先节点
        while (!$this->stack->stackEmpty() && $this->low) {
            /** @var BalanceBinaryTreeNode $node */
            $node = $this->stack->pop();
            switch ($this->direction) {
                case self::LEFT:// 删除node节点的左子树中的节点
                    switch ($node->balance_factor) {
                        case BalanceBinaryTreeNode::LH:
                            // 原树左边高，删除左边节点，平衡度变为0，树变低了
                            $node->balance_factor = BalanceBinaryTreeNode::EH;
                            $this->low            = true;
                            break;
                        case BalanceBinaryTreeNode::EH:
                            // 原树一样高，树不会变低
                            $node->balance_factor = BalanceBinaryTreeNode::RH;
                            $this->low            = false;
                            break;
                        case BalanceBinaryTreeNode::RH:
                            // 原树右边高，需要右平衡
                            if ($this->stack->stackEmpty()) {
                                $this->root = $this->rightBalance($node);
                            } else {
                                /** @var BalanceBinaryTreeNode $parent */
                                $parent = $this->stack->getTop();
                                if ($parent->l_child === $node) {
                                    $parent->l_child = $this->rightBalance($node);
                                } else {
                                    $parent->r_child = $this->rightBalance($node);
                                }
                            }
                            $this->low = false;
                            break;
                    }
                    break;
                case self::RIGHT:// 向node节点的右子树插入节点
                    switch ($node->balance_factor) {
                        case BalanceBinaryTreeNode::LH:
                            // 原树左边高，删除右边节点，需要左平衡
                            if ($this->stack->stackEmpty()) {
                                $this->root = $this->leftBalance($node);
                            } else {
                                /** @var BalanceBinaryTreeNode $parent */
                                $parent = $this->stack->getTop();
                                if ($parent->l_child === $node) {
                                    $parent->l_child = $this->leftBalance($node);
                                } else {
                                    $parent->r_child = $this->leftBalance($node);
                                }
                            }
                            $this->low = false;
                            break;
                        case BalanceBinaryTreeNode::EH:
                            // 原树一样高，树不会变低
                            $node->balance_factor = BalanceBinaryTreeNode::LH;
                            $this->low            = false;
                            break;
                        case BalanceBinaryTreeNode::RH:
                            // 原树右边高，删除右边节点，树变得左右一样高，但高度降低了
                            $node->balance_factor = BalanceBinaryTreeNode::EH;
                            $this->low            = true;
                            break;
                    }
                    break;
            }
            if (!$this->stack->stackEmpty()) {
                /** @var BalanceBinaryTreeNode $parent_node */
                $parent_node     = $this->stack->getTop();
                $this->direction = $parent_node->l_child === $node ? self::LEFT : self::RIGHT;
            }
        }
    }

    /**
     * 左子树平衡
     *
     * @param BalanceBinaryTreeNode $node
     *
     * @return BalanceBinaryTreeNode
     */
    protected function leftBalance($node)
    {
        $left_child = $node->l_child;
        switch ($left_child->balance_factor) {
            case BalanceBinaryTreeNode::LH:// 向左子树的左子树中插入节点导致树的高度变高

                $node->balance_factor       = BalanceBinaryTreeNode::EH;
                $left_child->balance_factor = BalanceBinaryTreeNode::EH;
                $node                       = $this->rightRotate($node);
                break;
            case BalanceBinaryTreeNode::RH:// 向左子树的右子树中插入节点导致树的高度变高
                $left_right_child = $left_child->r_child;
                switch ($left_right_child->balance_factor) {
                    case BalanceBinaryTreeNode::LH:
                        $node->balance_factor       = BalanceBinaryTreeNode::RH;
                        $left_child->balance_factor = BalanceBinaryTreeNode::EH;
                        break;
                    case BalanceBinaryTreeNode::EH:
                        $node->balance_factor       = BalanceBinaryTreeNode::EH;
                        $left_child->balance_factor = BalanceBinaryTreeNode::EH;
                        break;
                    case BalanceBinaryTreeNode::RH:
                        $node->balance_factor       = BalanceBinaryTreeNode::EH;
                        $left_child->balance_factor = BalanceBinaryTreeNode::LH;
                        break;
                }
                $left_right_child->balance_factor = BalanceBinaryTreeNode::EH;
                $node->l_child                    = $this->leftRotate($node->l_child);
                $node                             = $this->rightRotate($node);
                break;
        }
        return $node;
    }

    /**
     * 右子树平衡
     *
     * @param BalanceBinaryTreeNode $node
     *
     * @return BalanceBinaryTreeNode
     */
    protected function rightBalance($node)
    {
        $right_child = $node->r_child;
        switch ($right_child->balance_factor) {
            case BalanceBinaryTreeNode::LH:// 向右子树的左子树中插入节点导致树的高度变高
                $right_left_child = $right_child->l_child;
                switch ($right_left_child->balance_factor) {
                    case BalanceBinaryTreeNode::LH:
                        $node->balance_factor        = BalanceBinaryTreeNode::EH;
                        $right_child->balance_factor = BalanceBinaryTreeNode::RH;
                        break;
                    case BalanceBinaryTreeNode::EH:
                        $node->balance_factor        = BalanceBinaryTreeNode::EH;
                        $right_child->balance_factor = BalanceBinaryTreeNode::EH;
                        break;
                    case BalanceBinaryTreeNode::RH:
                        $node->balance_factor        = BalanceBinaryTreeNode::LH;
                        $right_child->balance_factor = BalanceBinaryTreeNode::EH;
                        break;
                }
                $right_left_child->balance_factor = BalanceBinaryTreeNode::EH;
                $node->r_child                    = $this->rightRotate($right_child);
                $node                             = $this->leftRotate($node);
                break;
            case BalanceBinaryTreeNode::RH:// 向右子树的右子树中插入节点导致树的高度变高
                $node->balance_factor        = BalanceBinaryTreeNode::EH;
                $right_child->balance_factor = BalanceBinaryTreeNode::EH;
                $node                        = $this->leftRotate($node);
                break;
        }
        return $node;
    }

    /**
     * 对以node节点为根的二叉树做左旋处理
     *
     * @param BalanceBinaryTreeNode $node
     *
     * @return BalanceBinaryTreeNode
     */
    protected function leftRotate($node)
    {
        // 处理跟的右结点
        $right_child = $node->r_child;
        // 右结点的左子树挂接为node的右结点
        $node->r_child = $right_child->l_child;
        // node挂接到右结点的左子树上
        $right_child->l_child = $node;
        return $right_child;
    }

    /**
     * 节点右旋
     *
     * @param BalanceBinaryTreeNode $node
     *
     * @return BalanceBinaryTreeNode
     */
    protected function rightRotate($node)
    {
        // 处理跟的左结点
        $left_child = $node->l_child;
        // 左结点的右子树挂接为node的左子树
        $node->l_child = $left_child->r_child;
        // node挂接为左结点的右子树
        $left_child->r_child = $node;
        return $left_child;
    }
}
