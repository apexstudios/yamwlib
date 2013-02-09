<?php
namespace YamwLibs\Libs\Text\Providers;

use YamwLibs\Libs\Text\Storage\MongoStorage;
use YamwLibs\Libs\Text\Strings\TextString;

/**
 * Description of DefaultTextProvider
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Text
 */
class DefaultTextProvider extends AbstractTextProvider
{
    private static $texts = array();
    private static $loaded_all = false;

    /**
     * The storage engine
     *
     * @var YamwLibs\Libs\Text\Storage\MongoStorage
     */
    private static $storage;

    public static function initStorage()
    {
        if (!static::$storage) {
            static::$storage = new MongoStorage(AdvMongo::getConn()->yamw_text);
        }
    }

    public function getSpecificText()
    {
        // Stub
        $args = func_get_args();

        $params = is_array($args[0]) ? $args[0] : $args;

        return new TextString($params);
    }

    public function getAllTexts()
    {
        if (!static::$loaded_all) {
            static::$texts = static::$storage;
        }

        return static::$texts;
    }

    public function getName()
    {
        return __CLASS__;
    }

    public function getTexts()
    {
        return $this->texts;
    }
}
