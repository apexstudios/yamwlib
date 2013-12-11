<?php
namespace YamwLibs\Libs\Html;

/**
 * Description of HtmlFactoryTest
 *
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 */
class HtmlFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateDivAndSpan()
    {
        self::assertRegExp(
            '/<div id="name" class="hw">(\s+)?<\/div>/i',
            HtmlFactory::divTag()->setId('name')->addClass('hw')->__toString()
        );

        self::assertRegExp(
            '/<span id="name" class="hw">(\s+)?<\/span>/i',
            HtmlFactory::spanTag()->setId('name')->addClass('hw')->__toString()
        );
    }

    public function testCanCreateImg()
    {
        self::assertRegExp(
            '/<img src="name" width="100" height="200" \/>/i',
            HtmlFactory::imgTag('name', 100, 200)->__toString()
        );
    }
}
