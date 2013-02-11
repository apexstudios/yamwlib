<?php
namespace YamwLibs\Libs\Vcs\Svn;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class SvnTest extends \PHPUnit_Framework_TestCase
{
    private static $cwd = "/tmp/";
    private static $url = "https://subversion.assembla.com/svn/yamw.vendor/trunk/monolog";

    /**
     * @var Svn
     */
    private $svn;

    public static function setUpBeforeClass()
    {
        self::$cwd = self::tempdir(sys_get_temp_dir(), 'svnTmp');
    }

    public function setUp()
    {
        $this->svn = new Svn(self::$cwd, self::$url);
    }

    private static function tempdir($dir, $prefix = '', $mode = 0700)
    {
        if (substr($dir, -1) != '/')
            $dir .= '/';

        do {
            $path = $dir . $prefix . mt_rand(0, 9999999);
        } while (!mkdir($path, $mode));

        return $path;
    }

    public function testCanCheckout()
    {
        $command = $this->svn->checkout();
        $return_code = null;
        $command->runCommand($return_code);

        self::assertSame(0, $return_code);

        self::assertTrue(file_exists(self::$cwd . "/monolog/monolog/src/Monolog/Logger.php"));
    }

    public function testCanCatFile()
    {
        $this->testCanCheckout();

        $command = $this->svn->cat("/monolog/src/Monolog/Logger.php");
        $return_code = null;
        $output = implode("\n", $command->runCommand($return_code));

        self::assertSame(0, $return_code);

        $cmpPath = self::$cwd . "/monolog/monolog/src/Monolog/Logger.php";
        self::assertEquals(
            trim(file_get_contents($cmpPath)),
            trim($output)
        );
    }
}
