<?php
namespace YamwLibs\Libs\Vcs\Svn;

use YamwLibs\Libs\Vcs\General;

/**
 * Handles Svn stuff - uses the Cli binaries
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class Svn extends General\AbstractVcs
{
    public function cat($file, $rev = null)
    {
        $command = new Commands\SvnCatCommand(
            $this->getCwd(),
            $this->getUrl() . $file
        );

        if ($rev) {
            $command->rev($rev);
        }

        return $command;
    }

    public function checkout($rev = null)
    {
        $command = new Commands\SvnCheckoutCommand(
            $this->getCwd(),
            $this->getUrl()
        );

        if ($rev) {
            $command->rev($rev);
        }

        return $command;
    }

    public function update($rev = null)
    {
        $command = new Commands\SvnUpdateCommand(
            $this->getCwd()
        );

        if ($rev) {
            $command->rev($rev);
        }

        return $command;
    }

    public function export($rev = null)
    {
        $command = "svn export";
        $command .= " --non-interactive";
        $command .= ' "' . $this->getUrl() . '"';
        if ($rev !== null && is_int($rev)) {
            $command .= " -r $rev";
        }

        $this->exec($command, $output, $return);
        echo implode("\n", $output);
        return $return;
    }

    public function listFiles($rev = null, $rec = false)
    {
        $command = new Commands\SvnListCommand(
            $this->getCwd()
        );

        if ($rev) {
            $command->rev($rev);
        }

        if ($rec) {
            $command->recursive();
        }

        return $command;
    }
}
