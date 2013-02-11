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
    public function checkout($rev = null)
    {
        $command = "svn co";
        $command .= " --non-interactive";
        $command .= ' "' . $this->getUrl() . '"';
        if ($rev !== null && is_int($rev)) {
            $command .= " -r $rev";
        }

        $output = array();
        $this->exec($command, $output, $return);
        echo implode("\n", $output);
        return $return;
    }

    public function update($rev = null)
    {
        $command = "svn up";
        $command .= " --non-interactive";
        if ($rev !== null && is_int($rev)) {
            $command .= " -r $rev";
        }

        $this->exec($command, $output, $return);
        echo implode("\n", $output);
        return $return;
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
        $command = "svn list";
        $command .= " --non-interactive";
        $command .= ' "' . $this->getUrl() . '"';
        if ($rev !== null && is_int($rev)) {
            $command .= " -r $rev";
        }
        if ($rec) {
            $command .= " -R";
        }

        $this->exec($command, $output, $return);
        echo implode("\n", $output);
        return $return;
    }
}
