<?php
namespace YamwLibs\Infrastructure\ResMgmt\Builders;

/**
 * Builds your Less/Css files
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage ResMgmt
 */
class CssBuilder
{
    /**
     * Builds a LESS/CSS resource from a file
     *
     * @param string $path
     * The path to a CSS/LESS file
     *
     * @return type
     * The final compressed CSS
     */
    public static function buildFile($path)
    {
        $obj = new \lessc();
        $obj->setFormatter('compressed');

        try {
            $output = $obj->compileFile($path);
        } catch (\Exception $e) {
            throw $e;
        }

        return $output;
    }

    /**
     * Builds a LESS/CSS resource from string
     *
     * @param string $string
     *
     * @return type
     * The compiled and compressed CSS
     */
    public static function buildString($string)
    {
        $obj = new \lessc();
        $obj->setFormatter('compressed');

        try {
            $output = $obj->compile($string);
        } catch (\Exception $e) {
            throw $e;
        }

        return $output;
    }
}
