<?php
namespace YamwLibs\Libs\Html\Markup;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 */
class TextNodeTest extends \PHPUnit_Framework_TestCase
{
    public function testHtmlIsEscaped()
    {
        $evilString = '<a href="hello">Hey</a>';
        $outputString = '&lt;a href=&quot;hello&quot;&gt;Hey&lt;/a&gt;';

        $node = new TextNode($evilString);
        self::assertEquals($outputString, $node->__toString());
    }

    public function testEntitiesAreAlsoEncoded()
    {
        $evilString = 'äö';
        $outputString = '&auml;&ouml;';

        $node = new TextNode($evilString);
        self::assertEquals($outputString, $node->__toString());
    }
}
