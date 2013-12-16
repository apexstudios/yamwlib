<?php
namespace YamwLibs\Libs\Html\Markup;

use \YamwLibs\Libs\Html\Interfaces\YamwMarkupInterface;

class MarkupContainer implements YamwMarkupInterface, \Countable
{
    private $data = array();
    private $pretty = false;

    public function __construct(YamwMarkupInterface $_markup = null)
    {
        if ($_markup !== null) {
            $this->push($_markup);
        }
    }

    public function isEmpty()
    {
        return (bool)array_filter($this->data);
    }

    public function isPretty()
    {
        return $this->pretty;
    }

    public function makePretty($lvl = 1)
    {
        // No effect
        return $this;
    }

    public function makeDirty()
    {
        // No effect
        return $this;
    }

    public function replace($_markup)
    {
        if (!is_array($_markup) && !($_markup instanceof YamwMarkupInterface)) {
            throw new \InvalidArgumentException();
        }

        if (is_array($_markup)) {
            $this->data = $_markup;
        } else {
            $this->data = array($_markup);
        }
    }

    public function shift()
    {
        return array_shift($this->data);
    }

    public function unshift(YamwMarkupInterface $_markup = null)
    {
        array_unshift($this->data, $_markup);
        return $this;
    }

    public function push(YamwMarkupInterface $_markup = null)
    {
        array_push($this->data, $_markup);
        return $this;
    }

    public function pop()
    {
        return array_pop($this->data);
    }

    public function getMarkupData()
    {
        return $this->data;
    }

    public function __toString()
    {
        if (!count($this->data)) {
            return '';
        }

        foreach ($this->data as &$x) {
            is_object($x) && $x = $x->__toString();
        }

        return implode("", $this->data);
    }

    public function count()
    {
        return count($this->data);
    }
}
