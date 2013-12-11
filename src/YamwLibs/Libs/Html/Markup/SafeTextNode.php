<?php
namespace YamwLibs\Libs\Html\Markup;

/**
 * Text Node which does not escape HTML
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 */
class SafeTextNode extends TextNode
{
    public function render()
    {
        return $this->getText();
    }

    public function __toString()
    {
        return (string)$this->getText();
    }
}
