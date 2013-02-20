<?php
namespace YamwLibs\Libs\Cli;

class Color
{
    const COLOR_RED = "\x1b[31;1m%s\x1b[0m";
    const COLOR_RED_BG = "\x1b[30;41m%s\x1b[0m";
    const COLOR_GREEN = "\x1b[32;1m%s\x1b[0m";
    const COLOR_GREEN_BG = "\x1b[30;42m%s\x1b[0m";
    const COLOR_YELLOW = "\x1b[33;1m%s\x1b[0m";
    const COLOR_YELLOW_BG = "\x1b[30;43m%s\x1b[0m";
    const COLOR_BLUE = "\x1b[34;1m%s\x1b[0m";
    const COLOR_BLUE_BG = "\x1b[30;44m%s\x1b[0m";

    public static $color = false;

    public static function green($text)
    {
        return static::makeColor($text, self::COLOR_GREEN);
    }

    public static function greenBg($text)
    {
        return static::makeColor($text, self::COLOR_GREEN_BG);
    }

    public static function red($text)
    {
        return static::makeColor($text, self::COLOR_RED);
    }

    public static function redBg($text)
    {
        return static::makeColor($text, self::COLOR_RED_BG);
    }

    public static function yellow($text)
    {
        return static::makeColor($text, self::COLOR_YELLOW);
    }

    public static function yellowBg($text)
    {
        return static::makeColor($text, self::COLOR_YELLOW_BG);
    }

    public static function blue($text)
    {
        return static::makeColor($text, self::COLOR_BLUE);
    }

    public static function blueBg($text)
    {
        return static::makeColor($text, self::COLOR_BLUE_BG);
    }

    public static function makeColor($text, $color = self::COLOR_GREEN)
    {
        if (static::$color) {
            return sprintf($color, $text);
        } else {
            return $text;
        }
    }
}
