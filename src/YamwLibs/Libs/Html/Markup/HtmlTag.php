<?php
namespace YamwLibs\Libs\Html\Markup;

/**
 * An extension to XmlTag, adding some common usages for HTML tags, like classes
 * and ids
 *
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 * @package YamwLibs
 * @see XmlTag
 */
class HtmlTag extends XmlTag
{
    public function addClass($class)
    {
        if (!is_string($class) && !is_array($class)) {
            throw new \Exception('$class is not a valid class!');
        }

        if (is_string($class)) {
            $class = array($class);
        }

        $string = " ".$this->getOption('class')." ";

        foreach ($class as $name) {
            if (!strpos($string, $name." ")) {
                $string = trim($string)." $name";
            }
        }

        $this->addOption('class', trim($string));

        return $this;
    }

    public function removeClass($name)
    {
        $name = $name . " ";
        $string = $this->getOption('class');
        $current_classes = $string ?
            substr($string, 0, strlen($string) - 1) : null;

        if (strpos($current_classes, $name)) {
            $current_classes = preg_replace("/$name/i", "", $current_classes);
        }

        $this->addOption('class', $current_classes. " ");
    }

    public function getClasses()
    {
        return (string)$this->getOption('class');
    }

    /**
     * I'd rather have it if you were to use classes...
     *
     * @param string $name
     *
     * @return $this
     */
    public function setId($name)
    {
        return $this->addOption('id', $name);
    }

    public function getId()
    {
        return (string)$this->getOption('id');
    }
}
