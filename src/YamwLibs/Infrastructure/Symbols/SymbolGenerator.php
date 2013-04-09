<?php
namespace YamwLibs\Infrastructure\Symbols;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Symbols
 */
class SymbolGenerator
{
    /**
     * @var array
     */
    private $nodes = array();
    /**
     * @var SymbolParser
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new SymbolParser($this);
    }

    public function parseFiles(array $files)
    {
        foreach ($files as $file) {
            $this->parser->parseFile($file);
        }
    }

    public function addNode(Nodes\AbstractNode $node)
    {
        $this->nodes[] = $node;
    }

    public function getNodes()
    {
        return $this->nodes;
    }
}
