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
    private $config_path = 'config/config.php';
    private $config_file;
    private $initialized = false;

    /**
     * Loads the config
     * @return $this
     */
    public function init()
    {
        $this->config_file = include $this->config_path;
        $this->initialized = true;

        return $this;
    }

    /**
     * Sets the config file to the new location
     *
     * @param type $newPath
     * The new location of the config file
     */
    public function setConfigPath($newPath)
    {
        $this->config_path = $newPath;
    }

    /**
     * Flushes the config cache, initiating a reload of the config file at the
     * next interaction with Config
     */
    public function flushCache()
    {
        $this->config_file = null;
        $this->initialized = false;
    }

    /**
     * Retrieves a variable from the config store
     *
     * @param string $name
     */
    public function get($name)
    {
        if (!$this->initialized) {
            $this->init();
        }

        if (!isset($this->config_file[$name])) {
            return null;
        }

        return $this->config_file[$name];
    }

    /**
     * Sets a variable to a new value. Note that this won't save the config
     * variable. To do that, you have to use ConfigParser.
     *
     * @param string $name
     * @param string $content
     *
     * @return $this
     */
    public function set($name, $content)
    {
        if (!$this->initialized) {
            $this->init();
        }

        if (isset($this->config_file[$name])) {
            $this->config_file[$name] = $content;
        } else {
            throw new \InvalidArgumentException("Config value $name does not exit!");
        }

        return $this;
    }
}
