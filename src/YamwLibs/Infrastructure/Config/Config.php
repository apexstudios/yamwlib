<?php
namespace YamwLibs\Infrastructure\Config;

/**
 * The global configuration storage
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @since Yamw 2.0
 * @version SVN: $Revision$
 * @package YamwLibs
 * @subpackage Infrastructure
 */
class Config
{
    private static $config_file;
    private static $initialized = false;

    /**
     * Loads the config
     * @return \Yamw\Lib\Config
     */
    public static function init()
    {
        self::$config_file = include path('config/config.php');
        self::$initialized = true;

        return new static;
    }

    /**
     * Retrieves a variable from the config store
     *
     * @param string $name
     */
    public static function get($name)
    {
        if (!self::$initialized) {
            self::init();
        }

        if (!isset(self::$config_file[$name])) {
            return null;
        }

        return self::$config_file[$name];
    }

    /**
     * Sets a variable to a new value
     *
     * @param string $name
     * @param string $content
     */
    public static function set($name, $content)
    {
        if (!self::$initialized) {
            self::init();
        }

        if (isset(self::$config_file[$name])) {
            self::$config_file[$name] = $content;
        } else {
            throw new \InvalidArgumentException("Config value $name does not exit!");
        }

        return new static();
    }
}
