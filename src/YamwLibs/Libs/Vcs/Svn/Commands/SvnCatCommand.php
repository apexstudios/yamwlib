<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnCatCommand extends AbstractSvnCommand
{
    public function __construct($file)
    {
        $this->addOption('"' . $file . '"', 'url');
    }

    public function rev($revision)
    {
        $this->overwriteExistingOption(
            'url', $this->getOption('url') . '@' . $revision
        );
    }

    public function getAllowedParameters()
    {
        return array(
            'rev',
            'url'
        );
    }

    public function getSubCommand()
    {
        return 'cat';
    }
}
