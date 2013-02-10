<?php
namespace YamwLibs\Libs\Db\Schemer;

use Yamw\Lib\Config;
use Yamw\Lib\MySql\AdvMySql_Conn;

/**
 * <p>Main class for interacting with the database scheme</p>
 *
 * Does things like
 * <ul>
 *     <li>gets the full prefixed name</li>
 *     <li>finds out what database a table is using</li>
 *     <li>resetting a table to its initial state</li>
 * </ul>
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Db
 */
class Schemer
{
    /**
     * This' holding our cute lil' scheme
     * @var array
     */
    private static $scheme = array();

    /**
     * Whether the scheme config has already been loaded
     *
     * @var bool
     */
    private static $loaded_scheme = false;

    /**
     * @var string
     */
    private static $configPath = '/config/scheme.php';

    /**
     * Whether a table exists in the scheme configuration
     *
     * @param string $name
     * The name of the table without table prefix
     *
     * @throws \InvalidArgumentException
     *
     * @return boolean
     * Whether the table is in the scheme configuration
     */
    public static function isTableInScheme($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('$name is not a string!');
        }

        if (!static::$loaded_scheme) {
            static::loadScheme();
        }

        return isset(static::$scheme[$name]) &&
            is_array(static::$scheme[$name]);
    }

    /**
     * Gets the scheme entry for table $name
     *
     * @param string $name
     * The name of the table without table prefix
     *
     * @throws \RunTimeException
     * in case no such table was found...
     *
     * @return array
     * An array containing
     */
    private static function getTableScheme($name)
    {
        if (static::isTableInScheme($name)) {
            return static::$scheme[$name];
        } else {
            throw new \RunTimeException("Table $name was not found in config!");
        }
    }

    /**
     * Gets the Model class associated with the table/collection
     *
     * @param string $name
     * The name of the table without table prefix
     *
     * @return string
     * The name of the Model class, like `User` or `BlogPost`
     *
     * @throws \RunTimeException
     * If the table does not exist, then expect an exception
     */
    public static function getTableModel($name)
    {
        if (static::isTableInScheme($name)) {
            return static::$scheme[$name]['model'];
        } else {
            throw new \RunTimeException("Table $name was not found in config!");
        }
    }

    /**
     * Gets the full prefixed table name
     * with every decoration you can find in store.
     *
     * @param string $name
     * The name of the table without table prefix
     *
     * @return string
     * The finalized name of the table
     */
    public static function getTableName($name)
    {
        if (static::isTableInScheme($name)) {
            $scheme = static::getTableScheme($name);
            return $scheme['prefix_name'] === true ?
                Config::get('mysql.table_prefix').$name :
                $scheme['prefix_name'].$name;
        }
    }

    /**
     * Returns which Db Engine a table uses
     *
     * @param string $name
     * The name of the table without table prefix
     *
     * @return string
     * Currently returns either mysql or mongodb
     */
    public static function getTableDbType($name)
    {
        if (static::isTableInScheme($name)) {
            $scheme = static::getTableScheme($name);
            return isset($scheme['dbtype']) ? $scheme['dbtype'] : 'mysql';
        }
    }

    /**
     * Resets a table to initial state
     *
     * @param string $name
     * The name of the table without table prefix
     *
     * @param string $name_scheme
     * The name of the scheme file without file extension.<br />
     * Must exist in //Resources/Mysql/Scheme/
     *
     * @param string $name_data
     * The name of the data file without file extension.<br />
     * Must exist in //Resources/Mysql/Data/
     *
     * @throws \RuntimeException
     */
    public static function resetTable(
        $name,
        $name_scheme = null,
        $name_data = null
    ) {
        if (!static::isTableInScheme($name)) {
            throw new \RuntimeException("Table $name could not be reset.");
        }

        if ($name_scheme === null) {
            $name_scheme = $name;
        }

        if ($name_data === null) {
            $name_data = $name;
        }

        $dbtype = ucwords(static::getTableDbType($name));

        $name_scheme = path("/../Resources/$dbtype/Scheme/$name_scheme.sql");
        $name_data = path("/../Resources/$dbtype/Data/$name_data.sql");

        if (!(file_exists($name_scheme) && file_exists($name_data))) {
            throw new \RuntimeException(
                "Could not load $name for reset.\n$name_scheme"
            );
        }

        $table_name = static::getTableName($name);

        $raw_scheme = file_get_contents($name_scheme);
        $raw_data = file_get_contents($name_data);

        $query_scheme = str_replace('{TABLE_NAME}', $table_name, $raw_scheme);
        $query_data = str_replace('{TABLE_NAME}', $table_name, $raw_data);

        $db = AdvMySql_Conn::getConn();

        $db->query("DROP TABLE IF EXISTS `{$table_name}`");

        $db->query($query_scheme);
        $db->query($query_data);
    }

    /**
     * Sets the location of the scheme config file.
     *
     * NOTE: This must be called first before any action with Schemer is taken,
     * since the file will be cached internally once loaded, which happens when
     * the first action is taken, like on a database query.
     *
     * @param string $newLoc
     * The new location of the scheme config file. Note that this must be
     * relative to the library root.
     */
    public static function setSchemeLocation($newLoc)
    {
        self::$configPath = $newLoc;
    }

    /**
     * Loads the scheme config into storage
     *
     * @throws \RuntimeException
     */
    private static function loadScheme()
    {
        $scheme_location = path(self::$configPath);
        if (file_exists($scheme_location)) {
            static::$scheme = include $scheme_location;
            static::$loaded_scheme = true;
        } else {
            throw new \RuntimeException(
                "Database scheme could not be loaded! Error ChuckNorris."
            );
        }
    }
}
