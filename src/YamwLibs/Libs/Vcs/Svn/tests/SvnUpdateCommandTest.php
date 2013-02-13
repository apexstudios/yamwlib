<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

require_once 'SharedSvnCommandTests.php';

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class SvnUpdateCommandTest extends SharedSvnCommandTests
{
    /**
     * @var SvnUpdateCommand
     */
    private $command;

    public function setUp()
    {
        // Reset checkout path / cwd each time, so we use a separate repository
        // for each new test
        self::setUpBeforeClass();
        self::checkoutRepo();
        $this->command = new SvnUpdateCommand(self::getCwdPath(""));
    }

    /**
     * We update from rev3 to rev4
     */
    public function testCanUpdate()
    {
        // Assert that we are on rev3
        self::assertTrue(file_exists($this->getCwdPath("trunk/TestClass.php")));
        self::assertFileEqualsMock("trunk/TestClass.php", 3);
        self::assertFileEqualsMock("trunk/TestClass2.php", 3);

        // Run the update command
        $ret_val = -1;
        $output = $this->command->runCommand($ret_val);
        self::assertSame(0, $ret_val);

        // Assert output
        self::assertEqualsMock("svn-up-r3-r4.txt", $output);

        // Assert that we are on rev4
        self::assertFalse(file_exists($this->getCwdPath("trunk/TestClass.php")));
        self::assertFileEqualsMock("trunk/TestClass2.php", 3);
    }

    /**
     * We update from rev3 to rev2
     */
    public function testCanUpdateBackwardsInTime()
    {
        // Assert that the file is @REV3
        self::assertFileEqualsMock("trunk/TestClass.php", 3);

        // Run the update command
        $ret_val = -1;
        // Set the revision
        $this->command->rev(2);
        $output = $this->command->runCommand($ret_val);
        self::assertSame(0, $ret_val);

        // Assert output
        self::assertEqualsMock("svn-up-r3-r2.txt", $output);

        // Assert that the file is @REV2
        self::assertFileEqualsMock("trunk/TestClass.php", 2);
    }
}
