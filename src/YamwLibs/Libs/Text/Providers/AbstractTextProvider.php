<?php
namespace YamwLibs\Libs\Text\Providers;

/**
 * An abstract class with shared functionality for TextProviders
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Text
 */
abstract class AbstractTextProvider
{
    /**
     * Returns the name of this TextPRovider
     */
    abstract function getName();

    /**
     * Gets a very specific text
     *
     * @param string $name
     *
     * @param mixed $... The arguments
     *
     * @return \YamwLibs\Libs\Text\Strings\TextString
     */
    abstract public function getSpecificText();

    /**
     * Gets all texts currently loaded by this TextProvider
     *
     * @return array An array containing all currently loaded texts
     */
    abstract public function getTexts();

    /**
     * Gets all texts located in the storage
     *
     * @return array An array holding all text objects
     */
    abstract public function getAllTexts();
}
