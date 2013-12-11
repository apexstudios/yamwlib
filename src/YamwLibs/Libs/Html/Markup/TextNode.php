<?php
namespace YamwLibs\Libs\Html\Markup;

use YamwLibs\Libs\Html\Interfaces\YamwMarkupInterface;
use YamwLibs\Libs\View\ViewInterface;

/**
 * For automatically escaping text and HTML and stuff
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 */
class TextNode implements YamwMarkupInterface, ViewInterface
{
    private $content;

    public function __construct($text = null)
    {
        $this->content = $text;
    }

    public function setText($text)
    {
        $this->content = $text;

        return $this;
    }

    public function getText()
    {
        return $this->content;
    }

    public function render()
    {
        return $this;
    }

    public function __toString()
    {
        return htmlentities((string)$this->content);
    }

    /**
     * No effect
     */
    public function isPretty()
    {
        return;
    }

    /**
     * No effect
     */
    public function makeDirty()
    {
        return;
    }

    /**
     * No effect
     */
    public function makePretty()
    {
        return;
    }
}
