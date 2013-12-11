<?php
namespace YamwLibs\Libs\Html\Markup;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 */
class SafeTextNodeTest extends \PHPUnit_Framework_TestCase
{
    public function testHtmlIsNotEscaped()
    {
        $evilString = '<a href="hello">Hey</a>';
        $outputString = $evilString;

        $node = new SafeTextNode($evilString);
        self::assertEquals($outputString, $node->__toString());
    }

    public function testEntitiesAreAlsoNotEncoded()
    {
        $evilString = 'äö';
        $outputString = $evilString;

        $node = new SafeTextNode($evilString);
        self::assertEquals($outputString, $node->__toString());
    }
}
