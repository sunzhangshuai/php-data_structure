<?php

use DataStructure\String\HeapString;
use DataStructure\String\LinkedString;
use DataStructure\String\SequenceString;
use Exception;
use PHPUnit\Framework\TestCase;

class StringTest extends TestCase
{
    protected $chars = 'There are moments in life when you miss someone so much that you just want to pick them from your dreams and hug them for real! Dream what you want to dream;go where you want to go;be what you want to be.';

    /**
     * @group string
     * @throws Exception
     */
    public function testSequenceString()
    {
        $chars  = $this->chars;
        $string = new SequenceString($chars);
        $this->assertEquals($chars, $string->__toString());
        // copy
        $copy_string = new SequenceString($chars);
        $copy_string->strCopy($string);
        $this->assertEquals($string->__toString(), $copy_string->__toString());
        // compare
        $compare_string = new SequenceString('There are moments in life when you miss someonq');
        $this->assertEquals(-12, $string->strCompare($compare_string));
        // concat
        $concat_chars  = ' I love you! laopo.';
        $concat_string = new SequenceString($concat_chars);
        $new_string    = $string->concat($concat_string);
        $this->assertEquals($new_string->__toString(), $chars . $concat_chars);
        // subString
        $sub_string = $string->subString(55, 2);
        $this->assertEquals($sub_string->__toString(), substr($chars, 54, 2));
        // index
        $sub_char   = 'you';
        $sub_string = new SequenceString($sub_char);
        $this->assertEquals($string->index($sub_string, 1), strpos($chars, $sub_char, 0) + 1);
        // strInsert
        $insert_chars  = 'insert';
        $insert_string = new SequenceString($insert_chars);
        $string->strInsert(55, $insert_string);
        $new_chars = substr($chars, 0, 54) . $insert_chars . substr($chars, 54);
        $this->assertEquals($string->__toString(), $new_chars);
        // strDelete
        $string->strDelete(55, 6);
        $this->assertEquals($string->__toString(), $chars);
        // replace
        $string->replace($sub_string, $insert_string);
        $this->assertEquals($string->__toString(), str_replace($sub_char, $insert_chars, $chars));
    }

    /**
     * @group string
     * @throws Exception
     */
    public function testHeapString()
    {
        $chars  = $this->chars;
        $string = new HeapString($chars);
        $this->assertEquals($chars, $string->__toString());
        // copy
        $copy_string = new HeapString($chars);
        $copy_string->strCopy($string);
        $this->assertEquals($string->__toString(), $copy_string->__toString());
        // compare
        $compare_string = new HeapString('There are moments in life when you miss someonq');
        $this->assertEquals(-12, $string->strCompare($compare_string));
        // concat
        $concat_chars  = ' I love you! laopo.';
        $concat_string = new HeapString($concat_chars);
        $new_string    = $string->concat($concat_string);
        $this->assertEquals($new_string->__toString(), $chars . $concat_chars);
        // subString
        $sub_string = $string->subString(55, 2);
        $this->assertEquals($sub_string->__toString(), substr($chars, 54, 2));
        // index
        $sub_char   = 'you';
        $sub_string = new HeapString($sub_char);
        $this->assertEquals($string->index($sub_string, 1), strpos($chars, $sub_char, 0) + 1);
        // strInsert
        $insert_chars  = 'insert';
        $insert_string = new HeapString($insert_chars);
        $string->strInsert(55, $insert_string);
        $new_chars = substr($chars, 0, 54) . $insert_chars . substr($chars, 54);
        $this->assertEquals($string->__toString(), $new_chars);
        // strDelete
        $string->strDelete(55, 6);
        $this->assertEquals($string->__toString(), $chars);
        // replace
        $string->replace($sub_string, $insert_string);
        $this->assertEquals($string->__toString(), str_replace($sub_char, $insert_chars, $chars));
    }

    /**
     * @group string
     * @throws Exception
     */
    public function testLinkedString()
    {
        $chars  = $this->chars;
        $string = new LinkedString($chars);
        $this->assertEquals($chars, $string->__toString());
        // copy
        $copy_string = new LinkedString($chars);
        $copy_string->strCopy($string);
        $this->assertEquals($string->__toString(), $copy_string->__toString());
        // compare
        $compare_string = new LinkedString('There are moments in life when you miss someonq');
        $this->assertEquals(-12, $string->strCompare($compare_string));
        // concat
        $concat_chars  = ' I love you! laopo.';
        $concat_string = new LinkedString($concat_chars);
        $new_string    = $string->concat($concat_string);
        $this->assertEquals($new_string->__toString(), $chars . $concat_chars);
        // subString
        $sub_string = $string->subString(55, 2);
        $this->assertEquals($sub_string->__toString(), substr($chars, 54, 2));
        // index
        $sub_char   = 'you';
        $sub_string = new LinkedString($sub_char);
        $this->assertEquals($string->index($sub_string, 1), strpos($chars, $sub_char, 0) + 1);
        // strInsert
        $insert_chars  = 'insert';
        $insert_string = new LinkedString($insert_chars);
        $string->strInsert(55, $insert_string);
        $new_chars = substr($chars, 0, 54) . $insert_chars . substr($chars, 54);
        $this->assertEquals($string->__toString(), $new_chars);
        // strDelete
        $string->strDelete(55, 6);
        $this->assertEquals($string->__toString(), $chars);
        // replace
        $string->replace($sub_string, $insert_string);
        $this->assertEquals($string->__toString(), str_replace($sub_char, $insert_chars, $chars));
    }

    public function testAppend() {
        $str = 'laosunl';
        $string = new LinkedString($str);
        $insert_chars  = 'love';
        $insert_string = new LinkedString($insert_chars);
        $string->strInsert(8, $insert_string);
        $this->assertTrue(true);
    }
}
