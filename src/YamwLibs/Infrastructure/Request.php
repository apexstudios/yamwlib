<?php
namespace YamwLibs\Infrastructure;

/**
 * The Request object holds all data associated with the http request
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package Yamw
 * @subpackage Lib
 */
class Request
{
    private static $params = array();

    /**
     * Populates the Request with the $params passed to it and, if applicable,
     * loads the default values for request information that has not been passed over
     *
     * @since 3.0
     * @param array $params
     */
    public static function init(array $params = array())
    {
        if (!$params) {
            $params = array(
                'module' => Config::get('default.module'),
                'action' => Config::get('default.action'),
                'section' => Config::get('default.section')
            );
        }

        if (!isset($params['section']) || !$params['section']) {
            $params['section'] = Config::get('default.section');
        }

        if (!isset($params['module']) || !$params['module']) {
            $params['module'] = Config::get('default.module');
        }

        if (!isset($params['action']) || !$params['action']) {
            $params['action'] = Config::get('default.action');
        }

        if (isset($_COOKIE['mybb_sid'])) {
            $params['c-sid'] = $_COOKIE['mybb_sid'];
        } else {
            $params['c-sid'] = false;
        }

        static::$params = $params;
    }

    /**
     * Assigns the passed data to the local key-value store, overwriting any existing
     * entries.
     *
     * @param array $data
     * @since 5.0
     */
    private static function populate(array $data)
    {
        foreach ($data as $key => $value) {
            static::$params[$key] = $value;
        }
    }

    private static function populatePrefix(array $global, $prefix = 'get')
    {
        $data = array();

        foreach ($global as $key => $value) {
            $data[$prefix.'-'.strtolower($key)] = $value;
        }

        static::populate($data);
    }

    private static function populateSuperGlobal(
        array $global,
        $prefix = 'get',
        array $populate_objects = null
    ) {
        if (!$populate_objects) {
            static::populatePrefix($global, $prefix);
        } else {
            $data = array();

            foreach ($populate_objects as $key => $value) {
                if (is_numeric($key)) {
                    $data[$value] = isset($global[$value]) ? $global[$value] : null;
                } else {
                    $data[$key] = isset($global[$key]) ? $global[$key] : $value;
                }
            }

            static::populatePrefix($data, $prefix);
        }
    }

    /**
     * Populates the Request object with data from the post superglobal
     *
     * @since 5.0
     */
    public static function populateFromPost(array $populate_objects = null)
    {
        static::populateSuperGlobal($_POST, 'post', $populate_objects);
    }

    /**
     * Populates the Request object with data from the get superglobal
     *
     * @since 5.0
     */
    public static function populateFromGet(array $populate_objects = null)
    {
        static::populateSuperGlobal($_GET, 'get', $populate_objects);
    }

    /**
     * Populates the Request object with data from the get superglobal
     *
     * @since 5.0
     */
    public static function populateFromServer(array $populate_objects = null)
    {
        static::populateSuperGlobal($_SERVER, 'server', $populate_objects);
    }

    /**
     * Returns the value associated with the $name key
     *
     * @since 5.0
     * @param string $name
     * @throws \InvalidArgumentException
     *
     * @return multiptype: string|bool|number
     */
    public static function get($name, $default_value = null)
    {
        if (isset(static::$params[$name])) {
            return static::$params[$name];
        } else {
            // Invalid key
            return $default_value;
        }
    }

    /**
     * Sets the key $name to the given $value
     *
     * @param string $name
     * @param string $value
     */
    public static function set($name, $value)
    {
        if (!is_scalar($value) && !is_null($value)) {
            throw new \InvalidArgumentException('$value must be a "normal" value!');
        }

        static::$params[$name] = $value;
    }

    /**
     * Returns whether a value has been associated with the given $name key
     *
     * @since 5.0
     * @param string $name
     *
     * @return boolean
     */
    public static function exists($name)
    {
        return isset(static::$params[$name]);
    }
}
