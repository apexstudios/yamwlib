<?php
namespace YamwLibs\Libs\Text\Strings;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class TextStringTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleString()
    {
        $string = "Some text to be written";

        $text = new TextString($string);

        self::assertSame($string, (string)$text);
    }

    public function testFormattedString()
    {
        $string = "%s is %d inches high";
        $arg1 = "Mastah Chief";
        $arg2 = 77;

        $compare = "Mastah Chief is 77 inches high";

        $text = new TextString($string, $arg1, $arg2);

        self::assertSame($compare, (string)$text);
    }
}
