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
        $string .= " --non-interactive";

        return $string;
    }

    public function rev($revision)
    {
        if (!self::validateRevision($revision)) {
            throw new \InvalidArgumentException("Bad revision supplied.");
        }

        $this->addOption("--revision $revision", "rev");

        return $this;
    }

    public static function validateRevision($rev)
    {
        if (!is_scalar($rev)) {
            return false;
        }

        if (!strlen($rev)) {
            return false;
        }

        if (is_int($rev) || ctype_digit($rev)) {
            return true;
        } else {
            if (!strpos($rev, ':')) {
                return false;
            }

            $rev_parts = explode(':', $rev);
            if (count($rev_parts) != 2) {
                return false;
            }

            if (ctype_digit($rev_parts[0]) && ctype_digit($rev_parts[1]) &&
                strlen($rev_parts[0]) && strlen($rev_parts[1])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function recursive()
    {
        $this->addOption("--recursive", "rec");
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

    public function parents()
    {
        $this->addOption("--parents", "parent");

        return $this;
    }

    public function targets($file)
    {
        $this->addOption("--targets $file", "target");

        return $this;
    }

    public function incremental()
    {
        $this->addOption("--incremental", "inc");

        return $this;
    }

    public function xml()
    {
        $this->addOption("--xml", "xml");

        return $this;
    }

    public function verbose()
    {
        $this->addOption("--verbose", "verbose");

        return $this;
    }

    public function diff()
    {
        $this->addOption("--diff", "diff");

        return $this;
    }

    public function limit($limit)
    {
        $this->addOption("--limit $limit", "limit");

        return $this;
    }
}
