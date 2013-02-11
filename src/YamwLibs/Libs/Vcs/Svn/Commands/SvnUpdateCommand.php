<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnUpdateCommand extends AbstractSvnCommand
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
            'path',
            'depth',
            'force',
            'ign-ext',
            'quiet',
            'rev',
            'parent',
        );
    }

    public function getSubCommand()
    {
        return 'up';
    }
}
