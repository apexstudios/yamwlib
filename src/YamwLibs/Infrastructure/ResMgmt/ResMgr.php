<?php
namespace YamwLibs\Infrastructure\ResMgmt;

use YamwLibs\Libs\Assertions\BasicAssertions as BA;
use YamwLibs\Libs\Assertions\FileAssertions as FA;

/**
 * Aggregates and compiles resources
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage ResMgmt
 */
class ResMgr
{
    /**
     * @var ResMgr
     */
    private static $instance;

    /**
     * @return ResMgr
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    private static $resourceMap = [];

    private $resources = [
        'css' => array(),
        'js'  => array(),
        'pck' => array(),
    ];

    public static function init($path = '__resource_map__.php')
    {
        if (!self::$resourceMap) {
            FA::assertFileExists($path);
            self::$resourceMap = require_once $path;
        }
    }

    public function __construct()
    {
        self::init();
    }

    private function pushResource($stackName, $resource)
    {
        BA::assertIsEnum($stackName, array('css', 'js'));

        if (!isset($this->resources[$stackName][$resource])) {
            $this->resources[$stackName][$resource] = true;
        }
        return $this;
    }

    public function requireCSS($name)
    {
        return $this->pushResource('css', $name);
    }

    public function fetchRequiredCSSResources()
    {
        $resources = [];
        foreach ($this->resources['css'] as $cssRes => $_) {
            $resEntry = $this->attemptToReadFromResMap("css", $cssRes);
            $resName = sprintf('%s.%s?v=%s', $cssRes, 'css', $resEntry['hash']);
            $resources[] = $resName;
        }
        return $resources;
    }

    private function attemptToReadFromResMap($type, $name)
    {
        $entry = idx(self::$resourceMap[$type], $name);

        if (!$entry) {
            $entry = idx(self::$resourceMap["pck"], $name);
        }

        return $entry;
    }
}
