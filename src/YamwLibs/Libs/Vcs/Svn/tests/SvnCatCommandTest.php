<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

require_once 'SharedSvnCommandTests.php';

/**
 * Description of SvnCatCommandTest
 *
 * @author AnhNhan <anhnhan@outlook.com>
 */
class SvnCatCommandTest extends SharedSvnCommandTests
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * We're at rev3
     */
    public function testSimpleCatFile()
    {
        $command1 = new SvnCatCommand($this->getUrl() . "/trunk/TestClass2.php");
        // Run the update command
        $ret_val = -1;
        $output = $command1->runCommand($ret_val);
        self::assertSame(0, $ret_val);

        self::assertEqualsMock("TestClass2.r3.php", $output);
    }

    public function testCatFileFromRevision() {
        $command1 = new SvnCatCommand($this->getUrl() . "/trunk/TestClass.php@2");
        // Run the update command
        $ret_val = -1;
        $output = $command1->runCommand($ret_val);
        self::assertSame(0, $ret_val);

        self::assertEqualsMock("TestClass.r2.php", $output);
    }
}
