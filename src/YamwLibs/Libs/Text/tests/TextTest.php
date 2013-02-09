<?php
namespace YamwLibs\Libs\Text;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class TextTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleTextRetrieve()
    {
        $string = "Some string";

        $retrieved = Text::getText($string);

        self::assertSame($string, (string)$retrieved);
    }

    public function testFormattedTextRetrieve()
    {
        $string = "Hey %s, you have %d new messages";
        $arg1 = "Joe";
        $arg2 = 15;

        $compare = "Hey Joe, you have 15 new messages";

        $retrieved = Text::getText($string, $arg1, $arg2);

        self::assertSame($compare, (string)$retrieved);
    }
}
