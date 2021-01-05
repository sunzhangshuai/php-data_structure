<?php



use DataStructure\Tree\BinaryTree\BinaryTree;
use DataStructure\Tree\BinaryTree\Model\BinaryTreeNode;
use DataStructure\Tree\BinaryTree\SequenceBinaryTree;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * todo 还有问题
 *
 * Class BinaryTreeTest
 * @package Tests\Feature\DataStructure
 */
class BinaryTreeTest extends TestCase
{
    /**
     * @group binary_tree
     * @throws Exception
     */
    public function testSequenceBinaryTree()
    {
        $data = [1, 2, 3, 4, 5, 0, 0, 0, 0, 6, 7];
        $tree = new SequenceBinaryTree($data);
        $root = $tree->root();
        $this->assertEquals(1, $root->data);
        $node2 = $tree->leftChild($root);
        $this->assertEquals(2, $node2->data);
        $node5 = $tree->rightChild($node2);
        $this->assertEquals(5, $node5->data);
        $node6 = $tree->leftChild($node5);
        $this->assertEquals(6, $node6->data);
        $this->assertEquals(4, $tree->leftSibling($node5)->data);
        $this->assertEquals(7, $tree->rightSibling($node6)->data);

        $visit  = function ($data) use (&$result) {
            $result[] = $data;
        };
        $result = [];
        $tree->preOrderTraverse($visit);
        $this->assertEquals([1, 2, 4, 5, 6, 7, 3], $result);
        $result = [];
        $tree->inOrderTraverse($visit);
        $this->assertEquals([4, 2, 6, 5, 7, 1, 3], $result);
        $result = [];
        $tree->postOrderTraverse($visit);
        $this->assertEquals([4, 6, 7, 5, 2, 3, 1], $result);
        $result = [];
        $tree->levelOrderTraverse($visit);
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7], $result);
    }

    /**
     * @group binary_tree
     * @throws Exception
     */
    public function testLinkedBinaryTree()
    {
        $data = [1, 2, 4, 0, 0, 5, 6, 0, 0, 7, 0, 0, 3, 0, 0];
        $tree = new BinaryTree($data);
        $root = $tree->root();
        $this->assertEquals(1, $root->data);
        $node2 = $tree->leftChild($root);
        $this->assertEquals(2, $node2->data);
        $node5 = $tree->rightChild($node2);
        $this->assertEquals(5, $node5->data);
        $node6 = $tree->leftChild($node5);
        $this->assertEquals(6, $node6->data);
        $this->assertEquals(4, $tree->leftSibling($node5)->data);
        $this->assertEquals(7, $tree->rightSibling($node6)->data);

        $visit  = function ($data) use (&$result) {
            $result[] = $data;
        };
        $result = [];
        $tree->preOrderTraverse($visit);
        $this->assertEquals([1, 2, 4, 5, 6, 7, 3], $result);
        $result = [];
        $tree->inOrderTraverse($visit);
        $this->assertEquals([4, 2, 6, 5, 7, 1, 3], $result);
        $result = [];
        $tree->postOrderTraverse($visit);
        $this->assertEquals([4, 6, 7, 5, 2, 3, 1], $result);
        $result = [];
        $tree->levelOrderTraverse($visit);
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7], $result);

        // 插入
        $node8 = new BinaryTreeNode(8);
        $tree->insertChild($node2, 1, $node8);
        $result = [];
        $tree->preOrderTraverse($visit);
        $this->assertEquals([1, 2, 4, 8, 5, 6, 7, 3], $result);

        // 删除
        $tree->deleteChild($root, 0);
        $result = [];
        $tree->preOrderTraverse($visit);
        $this->assertEquals([1, 8, 4, 5, 6, 7, 3], $result);
    }

    public function testLinkedBinaryTree2()
    {
        $visit  = function ($data) use (&$result) {
            $result[] = $data;
        };
        $data = [1, 2, 4, 0, 0, 6, 0, 0, 0];
        $tree = new BinaryTree($data);
        $root = $tree->root();
        // 删除
        $tree->deleteChild($root, 0);
        $result = [];
        $tree->preOrderTraverse($visit);
        $this->assertEquals([1, 8, 4, 5, 6, 7, 3], $result);
    }
}
