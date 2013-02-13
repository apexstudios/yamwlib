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

    private $options = array();

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

    protected function addOption($option, $name)
    {
        $this->options[$name] = $option;

        return $this;
    }

    protected function getOptions()
    {
        return $this->options;
    }

    protected function getOptionsString()
    {
        $options = "";
        $allowed = $this->getAllowedParameters();

        foreach ($this->options as $name => $option) {
            if (!in_array($name, $allowed)) {
                break;
            }

            $options .= $option . " ";
        }

        return $options;
    }

    abstract public function getCommandBinary();

    abstract function getSubCommand();

    public function getCommand()
    {
        return sprintf(
            "%s %s %s",
            $this->getCommandBinary(),
            $this->getSubCommand(),
            $this->getOptionsString()
        );
    }

    abstract public function getAllowedParameters();
}
