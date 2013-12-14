<?php
namespace YamwLibs\Libs\Routing;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataRoutes
     */
    public function testBasicRouting(Router $router, $uri, $result_target)
    {
        $result = $router->route($uri);
        self::assertEquals($result_target, $result["target"]);
    }

    public function dataRoutes()
    {
        $router = new Router;
        $routes = array(
            new Route("route1", "/derp/:module/:id", "target1"),
            new Route("route2", "/", "target2"),
            new Route("route3", "/:app", "target3"),
            new Route("route4", "/:app/:module", "target4"),
            new Route("route5", "/:app/:module/:index", "target5"),
        );

        foreach ($routes as $route) {
            $router->registerRoute($route);
        }

        return array(
            array($router, "/", "target2"),
            array($router, "", "target2"),
            array($router, "/derp/", "target3"),
            array($router, "/derp", "target3"),
            array($router, "/someapp/", "target3"),
            array($router, "/derp/hi", "target4"),
            array($router, "/derp/hi/derp", "target1"),
            array($router, "/huhu/hi/derp", "target5"),
        );
    }
}
