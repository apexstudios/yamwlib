<?php
namespace YamwLibs\Libs\Http;

use \YamwLibs\Infrastructure\Config\Config;

/**
 * A request object contains all information passed over by an external request,
 * be it Http or an internal request like when including a module within another
 * module.
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Http
 */
class Request
{
    /**
     * @var Config
     */
    private $config = array();
    private $params = array();
    private $globals = array();

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Assigns the passed data to the local key-value store, overwriting any
     * existing entries.
     *
     * @param array $data
     */
    public function populate(array $data)
    {
        foreach ($data as $key => $value) {
            $this->setValue($key, $value);
        }
    }

    /**
     * Populates the stack with an array of parameters, which keys will get
     * receive a prefix
     *
     * @param array $global
     * @param string $prefix
     */
    private function populatePrefix(array $global, $prefix = 'get')
    {
        $data = array();

        foreach ($global as $key => $value) {
            $data[$prefix . '-' . strtolower($key)] = $value;
        }

        $this->populate($data);
    }

    public function injectGlobal($name, $global)
    {
        $this->globals[$name] = $global;
        return $this;
    }

    private function populateSuperGlobal(
        array $global,
        $prefix = 'get',
        array $populate_objects = null
    ) {
        if (!$populate_objects) {
            $this->populatePrefix($global, $prefix);
        } else {
            $data = array();

            foreach ($populate_objects as $key => $value) {
                if (is_numeric($key)) {
                    $data[$value] = isset($global[$value]) ?
                        $global[$value] : null;
                } else {
                    $data[$key] = isset($global[$key]) ? $global[$key] : $value;
                }
            }

            $this->populatePrefix($data, $prefix);
        }
    }

    /**
     * Populates the Request object with data from the post superglobal
     */
    public function populateFromPost(array $populate_objects = null)
    {
        $this->populateSuperGlobal(isset($this->globals['post']) ? $this->globals['post'] : $_POST, 'post', $populate_objects);
    }

    /**
     * Populates the Request object with data from the get superglobal
     */
    public function populateFromGet(array $populate_objects = null)
    {
        $this->populateSuperGlobal(isset($this->globals['get']) ? $this->globals['get'] : $_GET, 'get', $populate_objects);
    }

    /**
     * Populates the Request object with data from the get superglobal
     */
    public function populateFromServer(array $populate_objects = null)
    {
        $this->populateSuperGlobal(isset($this->globals['server']) ? $this->globals['server'] : $_SERVER, 'server', $populate_objects);
    }

    public function populateFromCookies(array $populate_objects = null)
    {
        $this->populateSuperGlobal(isset($this->globals['cookie']) ? $this->globals['cookie'] : $_COOKIE, 'cookie', $populate_objects);
    }

    /**
     * Retrieves a cookie value. Has to be loaded with
     * `$this->populateFromCookies()` first.
     *
     * @param string $name
     * @param mixed $default_value
     * A value that will be return if the cookie value does not exist or is not
     * loaded
     *
     * @return mixed
     */
    public function getCookieValue($name, $default_value = null)
    {
        $param_name = 'cookie-' . $name;
        return $this->getValue($param_name, $default_value);
    }

    public function getGetValue($name, $default_value = null)
    {
        $param_name = 'get-' . $name;
        return $this->getValue($param_name, $default_value);
    }

    public function getPostValue($name, $default_value = null)
    {
        $param_name = 'post-' . $name;
        return $this->getValue($param_name, $default_value);
    }

    public function getServerValue($name, $default_value = null)
    {
        $param_name = 'server-' . $name;
        return $this->getValue($param_name, $default_value);
    }

    /**
     * Returns the value associated with the $name key
     * @param string $name
     *
     * @return multiptype: string|bool|number
     */
    public function getValue($name, $default_value = null)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        } else {
            // Invalid key
            return $default_value;
        }
    }

    public function getValueInt($name, $default_value = null)
    {
        return (int)$this->getValue($name, $default_value);
    }

    /**
     * Sets the key $name to the given $value
     *
     * @param string $name
     * @param mixed $value
     * A scalar value
     */
    public function setValue($name, $value)
    {
        if (!is_scalar($value) && !is_null($value)) {
            throw new \InvalidArgumentException(
                '$value must be a "normal" value!'
            );
        }

        $this->params[$name] = $value;
    }

    /**
     * Returns whether a value has been associated with the given $name key
     *
     * @param string $name
     *
     * @return boolean
     */
    public function valueExists($name)
    {
        return isset($this->params[$name]);
    }
}
