<?php
namespace YamwLibs\Libs\Routing;

/**
 * Routes http requests to the right controller according to the routing table.
 *
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 */
class Router
{
    private static $instance;

    private $routes = array();

    /**
     * @return $this
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static;
        }
        return self::$instance;
    }

    /**
     * Registers a route on the current stack
     *
     * @param \YamwLibs\Libs\Routing\Route $route
     * @return $this
     */
    public function registerRoute(Route $route)
    {
        $this->routes[] = $route;
        return $this;
    }

    /**
     * Runs a string through the current routing stack
     *
     * @param string $string
     * @return boolean
     */
    public function route($string)
    {
        foreach ($this->routes as $route) {
            if ($route->doesHandle($string)) {
                return $route->handle($string);
            }
        }
        return false;
    }
}
