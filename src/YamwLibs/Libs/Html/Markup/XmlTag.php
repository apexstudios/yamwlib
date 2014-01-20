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
                    $this->options[$k] = $v === null ? null : new TextNode($v);
                }
            }
        } else {
            $attr = htmlspecialchars($attr);
            $this->options[$attr] = $val === null ? null : new TextNode($val);
        }

        return $this;
    }

    public function getOption($name)
    {
        return idx($this->options, $name);
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

        $generated_options = "";
        if ($this->options) {
            ob_start();
            foreach ($this->options as $attr => $val) {
                if ($val === null) {
                    continue;
                }
                echo " $attr";
                if ($val) {
                    echo "=\"$val\"";
                }
            }
            $generated_options = ob_get_clean();
        }

        $end = " /";
        if (count($contents)) {
            $end = ">".$contents."</{$name}";
        }

        return "<{$name}{$generated_options}{$end}>";
    }
}
