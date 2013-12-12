<?php
namespace YamwLibs\Libs\Html\Markup;

/**
 * Object for XmlTags, used by the BuilderFramework
 *
 * @author AnhNhan
 * @package YamwLibs
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
                    $k = htmlspecialchars($k);
                    $this->options[$k] = $v;
                }
            }
        } else {
            $attr = htmlspecialchars($attr);
            $this->options[$attr] = new TextNode($val);
        }

        return $this;
    }

    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function isSelfClosing()
    {
        return count($this->getContent()) === 0;
    }

    public function __toString()
    {
        $name = $this->getTagName();
        $contents = $this->getContent();

        $indentation = "";
        $pretty = $this->isPretty();
        $contents->makePretty($pretty);
        if ($pretty) {
            $indentation = str_repeat("    ", $pretty);
        }

        $generated_options = "";
        if ($this->options) {
            foreach ($this->options as $attr => $val) {
                $generated_options .= " $attr";
                if ($val) {
                    $generated_options .= "=\"$val\"";
                }
            }
        }

        $end = " /";
        if (count($contents)) {
            $end = ">".trim((string)$contents)."</{$name}";
        }

        return "{$indentation}<{$name}{$generated_options}{$end}>";
    }
}