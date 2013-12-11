<?php
namespace YamwLibs\Libs\Html;

use YamwLibs\Libs\Html\Interfaces\YamwMarkupInterface;

/**
 *
 * @author AnhNhan
 * @package YamwLibs\Libs\Html
 */
class MarkUpBuilder implements Interfaces\BuilderInterface, \ArrayAccess, \IteratorAggregate
{
    private $data = array();
    private $formatted = false;
    private $built = false;
    private $generated_markup = '';

    public function addMarkUp(YamwMarkupInterface $_markup)
    {
        $this->data[] = $_markup;

        return $this;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }



    public function isPretty()
    {
        return $this->formatted;
    }

    public function makePretty($lvl = 1)
    {
        $this->formatted = ++$lvl;
    }

    public function makeDirty()
    {
        $this->formatted = false;
    }

    public function buildPretty()
    {
        $this->buildFormatted(true);
    }

    public function buildDirty()
    {
        $this->buildFormatted(false);
    }

    private function buildFormatted($formatted)
    {
        $f = $this->formatted;

        $this->formatted = $formatted;
        $this->build();

        // Restore setting
        $this->formatted = $f;
    }

    public function build()
    {
        // Do something
        foreach ($this->data as $markup) {
            $this->pushMarkup($markup);
        }

        // Mark it as built
        $this->markAsBuilt();
    }

    protected function markAsBuilt() {
        $this->built = true;
    }

    public function isBuilt()
    {
        return $this->built;
    }

    protected function pushMarkup($markup) {
        if ($this->isPretty()) {
            $indentation = str_repeat("    ", $this->isPretty());
            $this->generated_markup .= "{$indentation}{$markup}\n";
        } else {
            $this->generated_markup .= $markup;
        }
    }

    public function retrieve()
    {
        if (!$this->isBuilt()) {
            $this->build();
        }

        return $this->generated_markup;
    }

    public function __toString()
    {
        return $this->retrieve();
    }
}

