<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnLogCommand extends AbstractSvnCommand
{
    public function getAllowedParameters()
    {
        return array(
            'depth',
            'diff',
            'incremental',
            'limit',
            'quiet',
            'rev',
            'verbose',
            'xml',
        );
    }

    public function getSubCommand()
    {
        return 'log';
    }
}
