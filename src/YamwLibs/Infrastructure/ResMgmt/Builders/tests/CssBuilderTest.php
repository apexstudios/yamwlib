<?php
namespace YamwLibs\Infrastructure\ResMgmt\Builders;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage ResMgmt
 */
class CssBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleBuildFromFile()
    {
        $mockFileName = __DIR__ . "/mocks/main.less";
        $outputFileName = __DIR__ . "/mocks/output";
        $outputFileContents = file_get_contents($outputFileName);

        self::assertEquals(
            $outputFileContents,
            CssBuilder::buildFile($mockFileName)
        );
    }
}
