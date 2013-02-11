<?php
namespace YamwLibs\Infrastructure\Templater\Markup;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Templater
 */
abstract class AbstractTemplateMarkup
{
    /**
     * Gets the name of this markup
     */
    abstract public function getName();

    public function getType()
    {
        return basename(str_replace("\\", "/", get_class($this)));
    }

    /**
     * Gets the pattern according to which it is being replaced
     */
    abstract public function getPattern();

    /**
     * Gets the content with which the pattern is being replaced with
     */
    abstract public function getContent();

    /**
     * Whether this markup is critical or not.
     *
     * A markup is considered critical
     * when it should not be included in a rendered and cached version of the
     * template, since it could change according to several criterias, like
     * whether the user is logged in or not.
     *
     * @return boolean
     */
    abstract public function isCritical();
}
