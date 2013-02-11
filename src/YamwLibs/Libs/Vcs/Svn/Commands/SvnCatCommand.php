<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

/**
 * Description of CheckoutCommand
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnCatCommand extends AbstractSvnCommand
{
    public function __construct($cwd, $file)
    {
        parent::__construct($cwd);
        $this->addOption('"' . $file . '"', 'url');
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
