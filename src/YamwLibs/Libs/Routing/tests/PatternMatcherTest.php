<?php
namespace YamwLibs\Libs\Routing;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 */
class PatternMatcherTest extends \PHPUnit_Framework_TestCase
{
    public function dataRoutesInvalid()
    {
        return array(
            array("/img/files/", "/:app/:module/:whatever/"),
            array("/img/files/", "/js/:module/"),
            array("/lsf/home/", "/lsf/index/"),
        );
    }

    public function dataRoutesInvalidExtract()
    {
        return array(
            array("/img/files/", "/:app/:module/:whatever/"),
            array("/lsf/home/ss/", "/lsf/index/"),
        );
    }

    public function dataRoutes()
    {
        return array(
            array(
                "/account/details",
                "/:app/:module",
                array(
                    "app" => "account",
                    "module" => "details",
                ),
            ),
            array(
                "/rsrc/css/ru2092h4",
                "/rsrc/:module/:id",
                array(
                    "id" => "ru2092h4",
                    "module" => "css",
                ),
            ),
        );
    }

    /**
     * @dataProvider dataRoutes
     */
    public function testPositiveRouteMatchRecognition($string, $pattern)
    {
        self::assertTrue(PatternMatcher::isMatching($string, $pattern));
    }

    /**
     * @dataProvider dataRoutesInvalid
     */
    public function testNegativeRouteMatchRecognition($string, $pattern)
    {
        self::assertFalse(PatternMatcher::isMatching($string, $pattern));
    }

    /**
     * @dataProvider dataRoutesInvalidExtract
     */
    public function testNegativeRouteMatchExtraction($string, $pattern)
    {
        self::assertEquals(
            false,
            PatternMatcher::extract($string, $pattern)
        );
    }

    /**
     * @dataProvider dataRoutes
     */
    public function testRoutePatternExtraction($string, $pattern, $expOutput)
    {
        self::assertEquals(
            $expOutput,
            PatternMatcher::extract($string, $pattern)
        );
    }
}
