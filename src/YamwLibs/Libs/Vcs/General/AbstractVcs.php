<?php
namespace YamwLibs\Libs\Vcs\General;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
abstract class AbstractVcs
{
    /**
     * The current working directory
     *
     * @var string
     */
    private $cwd;

    /**
     * The URL location of the repository
     *
     * @var string
     */
    private $url;

    public function __construct($cwd, $url)
    {
        $this->cwd = $cwd;
        $this->url = $url;
    }

    public function getCwd()
    {
        return $this->cwd;
    }

    public function getUrl()
    {
        return $this->url;
    }

    protected function exec($cmd, array &$output = array(), &$ret_val = null)
    {
        chdir($this->getCwd());
        $command = $cmd;
        exec($command, $output, $ret_val);
        return $ret_val;
    }
}
