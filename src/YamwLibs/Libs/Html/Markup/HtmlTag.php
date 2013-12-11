<?php
namespace YamwLibs\Libs\Html\Markup;

/**
 *
 * @author AnhNhan
 * @package YamwLibs\Libs\Html
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

        $string = $this->getOption('class');
        $current_classes = $string ? substr($string, 0, strlen($string) - 1) : null;

        foreach ($class as $name) {
            if (!strpos($current_classes, $name." ")) {
                $current_classes .= " $name";
            }
        }

        $this->addOption('class', $current_classes. " ");

        return $this;
    }

    public function removeClass($name)
    {
        $name = $name . " ";
        $string = $this->getOption('class');
        $current_classes = $string ? substr($string, 0, strlen($string) - 1) : null;

        if (strpos($current_classes, $name)) {
            $current_classes = preg_replace("/$name/i", "", $current_classes);
        }

        $this->addOption('class', $current_classes. " ");
    }

    public function getClasses()
    {
        return $this->getOption('class');
    }

    public function setId($name)
    {
        return $this->addOption('id', $name);
    }

    public function getId()
    {
        return $this->getOption('id');
    }
}
