<?php
namespace YamwLibs\Infrastructure\Symbols;

use YamwLibs\Libs\Common\Exceptions\YamwLibsException;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Loaders
 */
class SymbolLoader
{
    /**
     * @var SymbolLoader
     */
    private static $instance;

    /**
     * @var array
     */
    private $locClasses;

    /**
     * @var array
     */
    private $locFunctions;

    /**
     * @var array
     */
    private $treeDerivs;

    /**
     * @var array
     */
    private $treeImpls;

    /**
     * @return SymbolLoader
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            $class = __CLASS__;
            self::$instance = new $class;
        }
        return self::$instance;
    }

    public function __construct()
    {
        $symbolMap = include path('__symbol_map__.php');
        $this->locClasses = $symbolMap["locations"]["classes"];
        $this->locFunctions = $symbolMap["locations"]["functions"];
        $this->treeDerivs = $symbolMap["xmap"]["derivations"];
        $this->treeImpls = $symbolMap["xmap"]["implementations"];
    }

    public function loadClass($fqClassName)
    {
        if (isset($this->locClasses[$fqClassName])) {
            $classLocation = path($this->locClasses[$fqClassName]);
            if (file_exists($classLocation)) {
                include_once path($classLocation);
                return true;
            } else {
                throw new YamwLibsException(
                    "$fqClassName could not be found at $classLocation! Maybe" .
                    " __symbol_map__.php is out of date?"
                );
            }
        } else {
            throw new YamwLibsException(
                "Symbol $fqClassName does not exist! Did you forget to update" .
                " the __symbol_map__.php?"
                );
        }
    }

    public function getClassesThatDeriveFromThisOne($parentClass)
    {
        if (isset($this->treeDerivs[$parentClass])) {
            return $this->treeDerivs[$parentClass];
        } else {
            throw new YamwLibsException(
                "No classes derive from $parentClass!"
            );
        }
    }
}
