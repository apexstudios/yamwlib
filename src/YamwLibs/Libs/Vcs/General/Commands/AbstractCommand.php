<?php
namespace YamwLibs\Libs\Vcs\General\Commands;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
abstract class AbstractCommand
{
    private $cwd;

    public function __construct($cwd)
    {
        chdir($cwd);
        $this->cwd = $cwd;
    }

    public function getName()
    {
        return get_class($this);
    }

    public function runCommand(&$ret_val = null)
    {
        $output = array();
        exec($this->getCommand(), $output, $ret_val);
        return $output;
    }

    public function getCwd()
    {
        return $this->cwd;
    }

    abstract public function getCommandBinary();

    abstract public function getCommand();
}
