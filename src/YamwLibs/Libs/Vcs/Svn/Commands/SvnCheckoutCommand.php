<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

/**
 * Description of CheckoutCommand
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnCheckoutCommand extends AbstractSvnCommand
{
    public function __construct($cwd, $url)
    {
        parent::__construct($cwd);
        $this->addOption('"'.$url.'"', 'url');
    }

    public function getSubCommand()
    {
        return 'co';
    }

    public function getAllowedParameters()
    {
        return array(
            'quiet',
            'ign-ext',
            'force',
            'depth',
            'rev',
            'url'
        );
    }
}
