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
class ResCompiler
{
    private $type;

    /**
     * @param string $type
     * The type of the resource stack - either `css` or `js`
     */
    public function __construct($type)
    {
        $type = strtolower($type);
        BA::assertIsEnum(strtolower($type), array('js', 'css'));

        $this->type = $type;
    }

    private $resources = array();

    /**
     * Pushes a resource onto the resource stack for the resource type
     *
     * For example, it when pushing a Js file with the name jquery.min.js,
     * it will add it to the stack for js files
     *
     * @param string $type
     * The resource type
     *
     * @param string $name
     * The name of the resource
     */
    public function pushResource($name)
    {
        BA::assertIsString($name);
        FA::assertFileExists($this->path($name));

        $this->resources[] = $this->trim($name);

        return $this;
    }

    /**
     * Compiles and returns the resource
     *
     * @return string
     * The compiled resource
     */
    public function compile()
    {
        $content = "";

        foreach ($this->resources as $resource) {
            if ($this->type == 'css') {
                $content .= Builders\CssBuilder::buildFile(
                    $this->path($resource)
                );
            } elseif ($this->type == 'js') {
                $content .= Builders\JsBuilder::buildFromFile(
                    $this->path($resource)
                );
            } else {
                $content .= file_get_contents($this->path($resource));
            }
        }

        return $content;
    }

    private function path($name)
    {
        return $name;
        // return path($name);
    }

    private function trim($string)
    {
        return trim($string, ' /\\.');
    }
}
