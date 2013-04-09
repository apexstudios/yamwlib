<?php
namespace YamwLibs\Infrastructure\Symbols;

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

    private $allSymbols;
    private $allLocations;
    private $allFunctions;
    private $allClasses;

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

        $this->allFunctions = array_unique(array_values($this->locFunctions));
        $this->allClasses = array_unique(array_values($this->locClasses));
        $this->allLocations = array_unique(
            array_merge($this->allClasses, $this->allFunctions)
        );
    }

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'), true, true);
    }

    public function loadAllSymbols()
    {
        if (!$this->allSymbols) {
            $this->allSymbols = array_unique(
                array_merge($this->locClasses, $this->locFunctions)
            );
        }

        if (!$this->allLocations) {
            $this->allLocations = array_unique($this->allSymbols);
        }

        $root = path();
        foreach ($this->allLocations as $location) {
            include_once $root . $location;
        }
    }

    public function loadAllFunctions()
    {
        $root = path();
        foreach ($this->allFunctions as $function) {
            include_once $root . $function;
        }
    }

    public function loadAllClasses()
    {
        $root = path();
        foreach ($this->allClasses as $class) {
            include_once $root . $class;
        }
    }

    public function loadClass($fqClassName)
    {
        // Don't throw, since we may have other autoloaders in the stack
        if (isset($this->locClasses[$fqClassName])) {
            $classLocation = path($this->locClasses[$fqClassName]);
            if (file_exists($classLocation)) {
                include_once $classLocation;
                return true;
            } else {
                /*throw new \Exception(
                    "$fqClassName could not be found at $classLocation! Maybe" .
                    " __symbol_map__.php is out of date?"
                );*/
            }
        } else {
            /*throw new \Exception(
                "Symbol $fqClassName does not exist! Did you forget to update" .
                " the __symbol_map__.php?"
            );*/
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
