<?php
namespace YamwLibs\Infrastructure\Symbols;

use YamwLibs\Libs\Common\Exceptions\YamwLibsException;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Symbols
 */
class SymbolTreeGenerator
{
    /**
     * @var array
     */
    private $nodes = array();

    /**
     * @var array
     */
    private $functions = array();

    /**
     * @var array
     */
    private $classes = array();

    /**
     * @var array
     */
    private $tmpClasses = array();

    /**
     * @var array
     */
    private $derivs = array();

    /**
     * @var array
     */
    private $impls = array();

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }

    public function generate()
    {
        // Split up
        foreach ($this->nodes as $node) {
            $nodeTypeParts = explode("\\", get_class($node));
            $nodeType = end($nodeTypeParts);
            switch ($nodeType) {
                case "ClassNode":
                    $this->tmpClasses[] = $node;

                    $this->classes += $node->getArrayRepresentation();
                    break;
                case "FunctionNode":
                    $this->functions += $node->getArrayRepresentation();
                    break;
                default:
                    throw new YamwLibsException("Unknown node type!");
                    break;
            }
        }

        // Generate inverse tree for classes
        foreach ($this->tmpClasses as $classNode) {
            $nodeName = $classNode->getName();
            $derivedClass = $classNode->getDerivedClass();
            if ($derivedClass) {
                if (!strlen($derivedClass)) {
                    continue;
                }

                if (!isset($this->derivs[$derivedClass])) {
                    $this->derivs[$derivedClass] = array();
                }

                if (!in_array(
                    $nodeName,
                    $this->derivs[$derivedClass]
                )) {
                    $this->derivs[$derivedClass][] = $nodeName;
                }
            }

            $implementedInterfaces = $classNode->getImplementedInterfaces();
            foreach ($implementedInterfaces as $interface) {
                if (!strlen($interface)) {
                    continue;
                }

                if (!isset($this->impls[$interface])) {
                    $this->impls[$interface] = array();
                }

                if (!in_array(
                    $nodeName,
                    $this->impls[$interface]
                )) {
                    $this->impls[$interface][] = $nodeName;
                }
            }
        }
    }

    public function getGeneratedTree()
    {
        return array(
            "locations" => array(
                "functions" => $this->functions,
                "classes" => $this->classes,
            ),
            "xmap" => array(
                "derivations" => $this->derivs,
                "implementations" => $this->impls,
            ),
        );
    }
}
