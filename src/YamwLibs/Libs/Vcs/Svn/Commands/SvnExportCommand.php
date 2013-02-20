<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

/**
 * Description of CheckoutCommand
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnExportCommand extends AbstractSvnCommand
{
    public function __construct($cwd, $url)
    {
        parent::__construct($cwd);
        $this->addOption('"'.$url.'"', 'url');
    }

    public function getSubCommand()
    {
        return 'export';
    }

    public function getAllowedParameters()
    {
        return array(
            'quiet',
            'ign-ext',
            'ign-key',
            'nat-eol',
            'force',
            'depth',
            'rev',
            'url'
        );
    }

    public function nativeEol($eol)
    {
        $this->addOption("--native-eol $eol", "nat-eol");

        return $this;
    }
}
