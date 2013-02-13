<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

require_once 'SharedSvnCommandTests.php';

/**
 * Description of SvnCheckoutCommandTest
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @covers YamwLibs\Libs\Vcs\Svn\Commands\SvnCheckoutCommand
 */
class SvnCheckoutCommandTest extends SharedSvnCommandTests
{
    public function testCanCheckoutRepository()
    {
        // Check that the repo does not exist yet
        self::assertFalse(file_exists($this->getCwdPath("trunk/TestClass2.php")));

        // Construct the command
        $command = new SvnCheckoutCommand($this->getCwd(), $this->getUrl());

        // Run the command
        $ret_val = -1;
        $command->runCommand($ret_val);

        // Assert that the command was successfully run
        self::assertSame(0, $ret_val);

        // Assert that the Repo was successfully checked out
        self::assertTrue(file_exists($this->getCwdPath("trunk/TestClass2.php")));
        // Assert that it is the right file
        self::assertFileMatches("trunk/TestClass2.php");
    }
}
