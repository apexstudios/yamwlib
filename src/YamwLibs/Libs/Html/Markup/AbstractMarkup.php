<?php
namespace YamwLibs\Libs\Html\Markup;

use YamwLibs\Libs\Html\Interfaces\YamwMarkupInterface;
use YamwLibs\Libs\View\ViewInterface;

/**
 * An abstract class for specific Markup
 *
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 * @package YamwLibs
 */
abstract class AbstractMarkup implements YamwMarkupInterface, ViewInterface
{
    private $name;

    /**
     * @var MarkupContainer
     */
    private $content;

    private $pretty = false;

    public function __construct($name, $content = null)
    {
        if (!is_string($name) || !$name) {
            throw new \InvalidArgumentException();
        }
        $this->name = $name;
        $this->setContent($content);
    }

    /**
     * The current name of this markup
     *
     * @return string
     */
    public function getTagName()
    {
        return $this->name;
    }

    /**
     * Protected only, to prevent abuse in code
     *
     * @param string $name
     * @return AbstractMarkup
     */
    protected function setTagName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * The current content of this markup
     *
     * @return MarkupContainer
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Replaces the current content with $content
     *
     * @param Ambigous <string, NULL, YamwMarkupInterface> $content
     * @throws \InvalidArgumentException
     *
     * @return \YamwLibs\Libs\Html\Markup\AbstractMarkup
     */
    public function setContent($content)
    {
        if (
            !is_scalar($content) &&
            $content !== null &&
            !($content instanceof MarkupInterface)
        ) {
            throw new \InvalidArgumentException();
        }

        if (!$this->content) {
            $this->content = new MarkupContainer();
        }

        if (is_null($content)) {
            return $this;
        }

        if (is_scalar($content)) {
            $this->content->push(new TextNode($content));
        } else { // Is an instance of MarkupInterface
            $this->content->push($content);
        }

        return $this;
    }

    /**
     * Appends content to the existing content, possibly mergins them together
     *
     * @param Ambigous <string, NULL, YamwMarkupInterface> $content
     * @throws \InvalidArgumentException
     *
     * @return \YamwLibs\Libs\Html\Markup\AbstractMarkup
     */
    public function appendContent($content)
    {
        // ViewInterface objects produce safe HTML
        if (is_object($content) && !($content instanceof MarkupInterface) &&
            $content instanceof ViewInterface) {
            $content = new SafeTextNode($content);
        }

        if (!is_scalar($content) && !($content instanceof MarkupInterface)) {
            throw new \InvalidArgumentException();
        }

        if (is_object($content)) {
            $this->content->push($content);
        } else {
            $this->content->push(new TextNode($content));
        }

        return $this;
    }

    /**
     * Wipes the current content
     *
     * @return $this
     */
    public function removeContent()
    {
        $this->content = new MarkupContainer();

        return $this;
    }

    /**
     * @see YamwMarkupInterface::isPretty()
     */
    public function isPretty()
    {
        return $this->pretty;
    }

    /**
     * @see YamwMarkupInterface::makePretty()
     */
    public function makePretty($lvl = 1)
    {
        $this->content->makePretty(++$lvl);
        $this->pretty = ++$lvl;
        return $this;
    }

    /**
     * disables formatting
     * @see YamwMarkupInterface::makeDirty()
     */
    public function makeDirty()
    {
        $this->content->makeDirty();
        $this->pretty = false;
        return $this;
    }

    /**
     * @see YamwMarkupInterface::__toString()
     */
    abstract public function __toString();

    public function render()
    {
        return $this;
    }
}
