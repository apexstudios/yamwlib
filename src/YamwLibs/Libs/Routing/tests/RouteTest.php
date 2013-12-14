<?php
namespace YamwLibs\Libs\Routing;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 */
class RouteTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $route = new Route("herp", "derp", "target");
        self::assertEquals("herp", $route->getName());
    }

    /**
     * @dataProvider dataRoutesInvalid
     */
    public function testDoesHandle($uri, $pattern, $match)
    {
        $route = new Route("some name", $pattern, "some target");
        self::assertSame($match, $route->doesHandle($uri));
    }

    /**
     * @dataProvider dataRoutesReqs
     */
    public function testHandlingWithRequirements($uri, $pattern, array $reqs, $exp)
    {
        $route = new Route("some name", $pattern, "some target");
        $route->setRequirements($reqs);
        $result = $route->handle($uri);
        if (is_array($result)) {
            unset($result["target"]);
        }
        self::assertSame($exp, (bool)$result);
    }

    /**
     * @dataProvider dataRoutesParams
     */
    public function testHandlingWithParams($uri, $pattern, array $exp, array $params)
    {
        $route = new Route("some name", $pattern, "some target");
        $route->setParameters($params);
        $result = $route->handle($uri);
        if (is_array($result)) {
            unset($result["target"]);
        }
        self::assertSame($exp, $result);
    }

    // Taken from PatternMatcherTest
    public function dataRoutesInvalid()
    {
        return array(
            array("/img/files/", "/:app/:module/:whatever/", false),
            array("/img/files/", "/js/:module/", false),
            array("/lsf/home/", "/lsf/index/", false),
            array("/img/files/", "/:app/:module/:whatever/", false),
            array("/lsf/home/ss/", "/lsf/index/", false),
        );
    }

    public function dataRoutesReqs()
    {
        return array(
            array( // Types match
                "/account/details",
                "/:app/:module",
                array(
                    "app" => array("type" => "string"),
                    "module" => array("type" => "string"),
                ),
                true, // Types match, all fine
            ),
            array( // Types do not match
                "/rsrc/css/ru2092h4",
                "/rsrc/:module/:id",
                array(
                    "id" => array("type" => "int"),
                    "module" => array("type" => "string"),
                ),
                false, // Types do not match
            ),
        );
    }

    public function dataRoutesParams()
    {
        return array(
            array( // Add
                "/account/details",
                "/:app/:module",
                array(
                    "app" => "account",
                    "module" => "details",
                    "index" => "someindex", // From Param
                ),
                array(
                    "index" => "someindex",
                ),
            ),
            array( // Overwrite
                "/rsrc/css/ru2092h4",
                "/rsrc/:module/:id",
                array(
                    "module" => "js", // Overwritten from param
                    "id" => "ru2092h4",
                ),
                array(
                    "module" => "js",
                ),
            ),
        );
    }
}
