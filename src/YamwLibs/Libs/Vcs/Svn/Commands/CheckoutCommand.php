<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

use YamwLibs\Libs\Vcs\General\Commands;

/**
 * Description of CheckoutCommand
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class CheckoutCommand extends AbstractSvnCommand
{
    private $options = array();

    public function rev($revision)
    {
        if (!(is_infinite($revision) && $revision == "HEAD")) {
            throw new \InvalidArgumentException("Bad revision supplied.");
        }

        $this->options['rev'] = $revision;
    }

    public function getCommandParameters()
    {
        // Stub
        // TODO: Generate parameters
        $parameters = "";

        // Add some more parameters

        return $parameters;
    }

    public function getSubCommand()
    {
        return "co";
    }
}
