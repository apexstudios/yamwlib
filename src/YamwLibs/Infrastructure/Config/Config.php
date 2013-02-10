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
    private static $config_path = 'config/config.php';
    private static $config_file;
    private static $initialized = false;

    /**
     * Loads the config
     * @return \Yamw\Lib\Config
     */
    public static function init()
    {
        self::$config_file = include self::$config_path;
        self::$initialized = true;

        return new static;
    }

    /**
     * Sets the config file to the new location
     *
     * @param type $newPath
     * The new location of the config file
     */
    public static function setConfigPath($newPath)
    {
        self::$config_path = $newPath;
    }

    /**
     * Flushes the config cache, initiating a reload of the config file at the
     * next interaction with Config
     */
    public static function flushCache()
    {
        self::$config_file = null;
        self::$initialized = false;
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
     * Sets a variable to a new value. Note that this won't save the config
     * variable. To do that, you have to use ConfigParser.
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
