<?php
namespace YamwLibs\Infrastructure\Templater;

/**
 * The MarkupManager manages all markup related to the template
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Templater
 */
class MarkupManager implements \IteratorAggregate
{
    private $markup = array();

    /**
     * Adds a template markup instance to the markup stack
     *
     * @param \YamwLibs\Infrastructure\Templater\Markup\AbstractTemplateMarkup $markup
     * The markup instance
     *
     * @return \YamwLibs\Infrastructure\Templater\MarkupManager
     */
    public function registerMarkup(Markup\AbstractTemplateMarkup $markup)
    {
        $name = $markup->getName();
        $this->markup[$name] = $markup;

        return $this;
    }

    /**
     * Gets a registered markup by name
     *
     * @param string $name
     * The name of the registered markup
     *
     * @return \YamwLibs\Infrastructure\Templater\Markup\AbstractTemplateMarkup | null
     * Returns the markup instance if found, else returns null
     */
    public function getMarkup($name)
    {
        if (isset($this->markup[$name])) {
            return $this->markup[$name];
        } else {
            return null;
        }
    }

    /**
     * Gets the number of markup registered
     *
     * @return int
     */
    public function getMarkupCount()
    {
        return count($this->markup);
    }

    /**
     * Returns an iterator for all registered markups
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->markup);
    }
}
