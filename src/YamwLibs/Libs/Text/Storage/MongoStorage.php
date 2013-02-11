<?php
namespace YamwLibs\Libs\Text\Storage;

/**
 * STUB
 *
 * Description of MongoStorage
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Text
 */
class MongoStorage extends AbstractTextStorage
{
    private $collection;

    public function __construct(\MongoCollection $col)
    {
        $this->collection = $col;
    }

    public function getName()
    {
        return __CLASS__;
    }

    public function getStorage()
    {
        return $this->collection;
    }

    public function retrieveAll()
    {
        $cursor = $this->getStorage()->find();
        $data = array();

        foreach ($cursor as $text) {
            // PENDING: Create TextString class and instantiate it here
            $data[] = $text;
        }
    }

    public function retrieveFromStorage($name)
    {

    }

    public function saveToStorage($name, $value)
    {

    }
}
