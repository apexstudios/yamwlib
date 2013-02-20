<?php
namespace YamwLibs\Libs\Cli;

class Cli
{
    const PREFIX = ':';

    const TEXT_NOTICE = 'Notice';
    const TEXT_FATAL = 'Fatal';
    const TEXT_SUCCESS = 'Success';
    const TEXT_ERROR = 'Error';

    public static function notice($text)
    {
        static::prefixOutput(self::TEXT_NOTICE, $text, Color::COLOR_BLUE);
    }

    public static function success($text)
    {
        static::prefixOutput(self::TEXT_SUCCESS, $text, Color::COLOR_GREEN_BG);
    }

    public static function error($text)
    {
        static::prefixOutput(self::TEXT_ERROR, $text, Color::COLOR_YELLOW_BG);
    }

    public static function fatal($text)
    {
        static::prefixOutput(self::TEXT_FATAL, $text . "\nExiting.", Color::COLOR_RED_BG);
        die();
    }

    public static function prefixOutput($prefix, $text, $color = null)
    {
        $prefix = " " . str_pad($prefix, 8);

        if ($color) {
            $prefix = Color::makeColor($prefix, $color);
        }

        static::output($prefix . "" . self::PREFIX . "\t" . $text);
    }

    public static function output($text)
    {
        print $text . PHP_EOL;
    }
}
