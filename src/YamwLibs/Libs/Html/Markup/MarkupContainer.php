<?php
namespace YamwLibs\Libs\Html\Markup;

use \YamwLibs\Libs\Html\Interfaces\YamwMarkupInterface;

class MarkupContainer implements YamwMarkupInterface
{
    private $data = array();
    private $pretty = true;
    
    public function __construct(YamwMarkupInterface $_markup = null)
    {
        if ($_markup !== null) {
            $this->push();
        }
    }
    
    public function isPretty()
    {
        return $this->pretty;
    }
    
    public function makePretty($lvl = 1)
    {
        $this->pretty = ++$lvl;
        return $this;
    }
    
    public function makeDirty()
    {
        $this->pretty = false;
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
        $data = '';
        foreach ($this->data as $markup) {
            if ($this->isPretty()) {
                $indentation = str_repeat("    ", $this->isPretty());
                if (is_object($markup)) {
                    $markup->makeDirty($this->isPretty());
                }
            } else {
                $indentation = "";
            }
            
            $data .= $indentation.$markup."\n";
        }
        return $data;
    }
}
