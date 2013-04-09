<?php
namespace YamwLibs\Infrastructure\Symbols\Nodes;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Symbols
 */
class ClassNode extends AbstractNode
{
    private $name;
    private $file;
    private $derivs;
    private $impls = array();

    public function __construct(
        $name,
        $file,
        $derivation,
        array $implementations
    ) {
        $impls = array();
        foreach ($implementations as $imp) {
            $impls[] = (string) $imp;
        }

        $this->name   = $name;
        $this->file   = $file;
        $this->derivs = (string)$derivation;
        $this->impls  = $impls;
    }

    public function getArrayRepresentation()
    {
        return array(
            $this->name => $this->file
        );
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDerivedClass()
    {
        return $this->derivs;
    }

    public function getImplementedInterfaces()
    {
        return $this->impls;
    }
}
