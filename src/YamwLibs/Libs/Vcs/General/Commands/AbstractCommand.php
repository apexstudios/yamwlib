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
        $this->cwd = $cwd;
    }

    public function getName()
    {
        return get_class($this);
    }

    public function runCommand(&$ret_val = null)
    {
        if (file_exists($this->cwd)) {
            chdir($this->cwd);
        }

        $output = array();
        exec($this->getCommand(), $output, $ret_val);
        return $output;
    }

    public function getCwd()
    {
        return $this->cwd;
    }

    public function setCwd($cwd)
    {
        $this->cwd = $cwd;

        return $this;
    }

    protected function addOption($option, $name)
    {
        $this->options[$name] = $option;

        return $this;
    }

    protected function overwriteExistingOption($name, $newOption)
    {
        if (isset($this->options[$name])) {
            $this->options[$name] = $newOption;

            return $this;
        } else {
            throw new \RuntimeException("Error: Can not overwrite nonexisting option $name");
        }
    }

    protected function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
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

    public function path($path)
    {
        return $this->addOption('"' . $path . '"', 'path');
    }

    public function url($url)
    {
        return $this->addOption('"' . $url . '"', 'url');
    }
}
