<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnInfoCommand extends AbstractSvnCommand
{
    public function __construct($cwd, $path = null)
    {
        parent::__construct($cwd);

        if ($path) {
            $this->addOption('"' . $path . '"', 'path');
        }
    }

    public function getAllowedParameters()
    {
        return array(
            'rev',
            'rec',
            'xml',
            'inc',
            'depth',
            'path',
        );
    }

    public function getSubCommand()
    {
        return 'info';
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
}
