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

    protected function getOptionsString()
    {
        $string = parent::getOptionsString();
        // $string .= " --non-interactive --trust-server-cert";

        return $string;
    }

    public function rev($revision)
    {
        if (!(is_infinite($revision) && $revision == "HEAD")) {
            throw new \InvalidArgumentException("Bad revision supplied.");
        }

        $this->addOption("--revision $revision", "rev");

        return $this;
    }

    public function quiet()
    {
        $this->addOption("--quiet", "quiet");

        return $this;
    }

    public function ignoreExternals()
    {
        $this->addOption("--ignore-externals", "ign-ext");

        return $this;
    }

    public function depth($depth = "infinity") {
        $this->addOption("--depth $depth", "depth");

        return $this;
    }

    public function force()
    {
        $this->addOption("--force", "force");

        return $this;
    }
}
