<?php
namespace YamwLibs\Libs\Db\Schemer;

use YamwLibs\Infrastructure\Config\Config;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class SchemerTest extends \PHPUnit_Framework_TestCase
{
    private static $tablePrefix = "lolz_";

    public static function setUpBeforeClass()
    {
        $config = new Config;
        $config->setConfigPath(__DIR__ . "/mocks/config.php");
        Schemer::setConfig($config);
        Schemer::setSchemeLocation(__DIR__ . "/mocks/scheme.php");
    }

    public function dataTables()
    {
        return array(
            array('forum_cache', self::$tablePrefix."forum_cache"),
            array('users', "mybb_users"),
            array('gallery', 'gallery'),
        );
    }

    /**
     * @dataProvider dataTables
     * @param type $tableName
     * @param type $expTableName
     */
    public function testCanGiveProperTableNames($tableName, $expTableName)
    {
        self::assertEquals($expTableName, Schemer::getTableName($tableName));
    }
}
