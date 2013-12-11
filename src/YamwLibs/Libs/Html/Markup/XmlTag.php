<?php
namespace YamwLibs\Libs\Html\Markup;

/**
 * Object for XmlTags, used by the BuilderFramework
 *
 * @author AnhNhan
 * @package YamwLibs\Libs\Html
 */
class XmlTag extends AbstractMarkup
{
    private $options = array();

    public function __construct($name, $content=null, array $options=array())
    {
        parent::__construct($name, $content);

        $this->addOption($options);
    }

    public function addOption($attr, $val=null)
    {
        if(
            is_object($attr) || is_object($val) ||
            (is_array($attr) && $val !== null) ||
            is_array($val)
        ) {
            throw new \InvalidArgumentException();
        }

        if (is_array($attr)) {
            foreach ($attr as $k => $v) {
                if(is_numeric($k)) {
                    $this->options[$v] = '';
                } else {
                    $this->options[$k] = $v;
                }
            }
        } else {
                $this->options[$attr] = $val;
        }

        return $this;
    }

    public function getOption($name)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        } else {
            return null;
        }
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function isSelfClosing()
    {
        return $this->getContent() === null;
    }

    public function __toString()
    {
        $name = $this->getName();
        $content = $this->getContent();

        if ($this->options) {
            $generated_options = '';

            foreach ($this->options as $attr => $val) {
                $generated_options .= " $attr";
                if ($val) {
                    $generated_options .= "=\"$val\"";
                }
            }
        } else {
            $generated_options = '';
        }

        if ($content === null) {
            $end = " /";
        } else {
            $end = ">";
            $end .= $content;
            $end .= "</{$name}";
        }

        if ($this->isPretty()) {
            $indentation = str_repeat("    ", $this->isPretty());
            if (is_object($content)) {
                $content->makeDirty();
            }
        } else {
            $indentation = "";
        }

        return "{$indentation}<{$name}{$generated_options}{$end}>\n";
    }
}
