<?php
namespace YamwLibs\Infrastructure\Symbols;

use \PHPParser_Node_Stmt_Class as PP_Cls;
use \PHPParser_Node_Stmt_Function as PP_Ftn;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Symbols
 */
class SymbolParser
{
    private $parser;
    private $generator;

    /**
     * This is aways set to the current file being parsed.
     *
     * @var string
     */
    private $file;

    public function __construct(SymbolGenerator $generator)
    {
        $this->generator = $generator;
        $this->parser = new \PHPParser_Parser(new \PHPParser_Lexer);
    }

    public function parseFile($file, $basePath = '')
    {
        try {
            $code = file_get_contents($basePath . $file);
            $stmts = $this->parser->parse($code);
        } catch (\PHPParser_Error $exc) {
            echo "\nI suspect there was a syntax error in $file\n";
            echo $exc->getTraceAsString() . PHP_EOL;
            return false;
        }

        $this->file = $file;
        $this->parseNodes($stmts);
    }

    public function parseNodes($stmts, $nmsps = "", array $uses = array())
    {
        foreach ($stmts as $index => $statement) {
            // This avoids cycles when recursing use or namespace statements
            unset($stmts[$index]);
            $symbol = null;

            switch ($this->sanitizeSymbolName(get_class($statement))) {
                case "PHPParser_Node_Stmt_Use":
                    $new_uses = array_merge($uses, $statement->uses);
                    $this->parseNodes($stmts, $nmsps, $new_uses);
                    break;
                case "PHPParser_Node_Stmt_Namespace":
                    $nmsps = $statement->name;
                    $this->parseNodes($statement->stmts, $nmsps, $uses);
                    break;
                case "PHPParser_Node_Stmt_Class":
                case "PHPParser_Node_Stmt_Interface":
                case "PHPParser_Node_Stmt_Trait":
                    $symbol = $this->parseClassNode($statement, $nmsps, $uses);
                    break;
                case "PHPParser_Node_Stmt_Function":
                    $symbol = $this->parseFunctionNode($statement);
                    break;
            }

            if ($symbol) {
                $this->generator->addNode($symbol);
            }
        }
    }

    public function parseClassNode($node, $nmsps, array $uses)
    {
        $className = $nmsps . "\\" . $node->name;

        // We won't parse test files
        if (substr($className, -strlen("Test")) == "Test") {
            return false;
        }

        $derivation = $node->extends ?
            $this->resolveSymbolName($node->extends, $nmsps, $uses) : "";
        $implementations = array();
        if (isset($node->implements)) {
            foreach ($node->implements as $impl) {
                $implementations[] = $this->resolveSymbolName(
                    $impl,
                    $nmsps,
                    $uses,
                    true
                );
            }
        }

        $symbolNode = new Nodes\ClassNode(
            $className,
            $this->file,
            $derivation,
            $implementations
        );

        return $symbolNode;
    }

    private function resolveSymbolName(
        $smblName,
        $namespace,
        array $uses,
        $isInterface = false
    ) {
        $rootName = "\\" . $smblName;
        $cmpFunction = $isInterface ? "interface_exists" : "class_exists";

        try {
            if ($cmpFunction($rootName)) {
                return $this->sanitizeSymbolName($rootName);
            }
        } catch (\Exception $e) {
            // Discard
        }

        $nmspName = $namespace . "\\" . $smblName;
        try {
            if ($cmpFunction($nmspName)) {
                return $this->sanitizeSymbolName($nmspName);
            }
        } catch (\Exception $e) {
            // Discard
        }

        foreach ($uses as $usedNmsp) {
            $derivClassName = implode("\\", $usedNmsp->name->parts);
            try {
                if ($cmpFunction($derivClassName)) {
                    return $this->sanitizeSymbolName($derivClassName);
                }
            } catch (\Exception $e) {
                // Discard
            }

            $derivClassName = implode("\\", $usedNmsp->name->parts) .
                "\\" . $smblName;
            try {
                if ($cmpFunction($derivClassName)) {
                    return $this->sanitizeSymbolName($derivClassName);
                }
            } catch (\Exception $e) {
                // Discard
            }
        }
    }

    private function sanitizeSymbolName($name)
    {
        return ltrim($name, "\\");
    }

    private function parseFunctionNode(PP_Ftn $node)
    {
        $symbolNode = new Nodes\FunctionNode(
            $node->name,
            $this->file
        );

        return $symbolNode;
    }
}
