<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
abstract class SharedSvnCommandTests extends \PHPUnit_Framework_TestCase
{
    private static $cwd;
    private static $url;

    public static function setUpBeforeClass()
    {
        // Construct the cwd - a random path in /tmp
        self::$cwd = \YamwLibs\Functions\TmpFunc::tempdir(sys_get_temp_dir(), 'svnTmp');

        // Build the URL for the testrepo
        $repo_dir = "file:///" . __DIR__ . DIRECTORY_SEPARATOR . "mocks" .
            DIRECTORY_SEPARATOR . "testrepo";
        self::$url = str_replace("\\", "/", $repo_dir);
    }

    public static function getCwd()
    {
        return self::$cwd;
    }

    public static function getCwdPath($path)
    {
        return self::getCwd() . DIRECTORY_SEPARATOR . "testrepo" .
            DIRECTORY_SEPARATOR . $path;
    }

    public static function getUrl()
    {
        return self::$url;
    }

    protected static function checkoutRepo($rev = 3)
    {
        $command = new SvnCheckoutCommand(self::$cwd, self::$url);

        if ($rev) {
            $command->rev($rev);
        }

        $ret_val = -1;
        $output = $command->runCommand($ret_val);
        self::assertSame(
            0,
            $ret_val,
            "Could not check out repository - return code $ret_val\n\n" .
                "Message:\n" . $output
        );
    }

    public static function assertFileEqualsMock($file, $rev = 3)
    {
        $mockFilePath = __DIR__ . "/mocks/" .
            str_replace('.php', '.r'.$rev.'.php', basename($file));
        $repoFilePath = self::getCwdPath($file);

        self::assertEquals(
            trim(file_get_contents($mockFilePath)),
            trim(file_get_contents($repoFilePath)),
            "File {$file}@{$rev} did not match the mock file!"
        );
    }

    public static function assertEqualsMock($mockFileName, $actual)
    {
        $mockFilePath = __DIR__ . "/mocks/" . $mockFileName;

        if (is_array($actual)) {
            $actual = implode("\n", $actual);
        }

        self::assertEquals(
            trim(file_get_contents($mockFilePath)),
            trim($actual)
        );
    }
}
