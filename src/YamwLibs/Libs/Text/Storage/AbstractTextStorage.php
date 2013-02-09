<?php
namespace YamwLibs\Libs\Text\Storage;

/**
 * STUB
 *
 * Abstract storage class for text providers shared by text storages
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Text
 */
abstract class AbstractTextStorage
{
    abstract public function getName();

    abstract public function retrieveFromStorage($name);
    abstract public function retrieveAll();

    abstract public function saveToStorage($name, $value);

    abstract public function getStorage();
}
