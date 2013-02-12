<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnListCommand extends AbstractSvnCommand
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
            'depth',
            'inc',
            'rev',
            'rec',
            'verbose',
            'xml',
        );
    }

    public function getSubCommand()
    {
        return 'list';
    }
}
