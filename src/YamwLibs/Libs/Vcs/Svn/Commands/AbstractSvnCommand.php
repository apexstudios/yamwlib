<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

use YamwLibs\Libs\Vcs\General\Commands;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
abstract class AbstractSvnCommand extends Commands\AbstractCommand
{
    public function getCommandBinary()
    {
        return "svn";
    }

    abstract function getSubCommand();

    abstract function getCommandParameters();

    public function getCommand()
    {
        return sprintf(
            "%s %s %s",
            $this->getCommandBinary(),
            $this->getSubCommand(),
            $this->getCommandParameters()
        );
    }
}
