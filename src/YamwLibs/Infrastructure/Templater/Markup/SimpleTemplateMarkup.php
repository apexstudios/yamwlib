<?php
namespace YamwLibs\Infrastructure\Templater\Markup;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Templater
 */
class SimpleTemplateMarkup extends AbstractTemplateMarkup
{
    private $name;
    private $pattern;
    private $content;
    private $critical;

    public function __construct($name, $pattern, $content, $critical = false)
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->content = $content;
        $this->critical = $critical;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function isCritical()
    {
        return $this->critical;
    }
}
