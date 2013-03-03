<?php
namespace YamwLibs\Infrastructure\Symbols\Nodes;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Symbols
 */
class FunctionNode extends AbstractNode
{
    private $name;
    private $file;

    public function __construct($name, $file)
    {
        $this->name = (string)$name;
        $this->file = $file;
    }

    public function getArrayRepresentation()
    {
        return array($this->name => $this->file);
    }
}
