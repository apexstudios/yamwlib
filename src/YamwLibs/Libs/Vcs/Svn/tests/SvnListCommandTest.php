<?php
namespace YamwLibs\Libs\Vcs\Svn\Commands;

require_once 'SharedSvnCommandTests.php';

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class SvnListCommandTest extends SharedSvnCommandTests
{
    /**
     * @var SvnUpdateCommand
     */
    private $command;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // Unlike SvnUpdateCommandTest, we only need to check out the working
        // copy once, since we do not change the state of the wc during the test
        self::checkoutRepo();
    }

    public function setUp()
    {
        $this->command = new SvnListCommand(self::getCwdPath(""));
    }

    public function testCanDoSimpleList()
    {
        // Run the update command
        $ret_val = -1;
        $output = $this->command->runCommand($ret_val);
        self::assertSame(0, $ret_val);

        // Assert output
        self::assertEqualsMock("svn-list.txt", $output);
    }

    public function testCanDoRecursiveList()
    {
        // Set the recursive flag
        $this->command->recursive();

        // Run the update command
        $ret_val = -1;
        $output = $this->command->runCommand($ret_val);
        self::assertSame(0, $ret_val);

        // Assert output
        self::assertEqualsMock("svn-list-recursive.txt", $output);
    }

    public function testCanDoRecursiveListForASpecificRevision()
    {
        // Set the recursive flag
        $this->command->recursive();

        // Set the revision
        $this->command->rev(2);

        // Run the update command
        $ret_val = -1;
        $output = $this->command->runCommand($ret_val);
        self::assertSame(0, $ret_val);

        // Assert output
        self::assertEqualsMock("svn-list-recursive-r2.txt", $output);
    }
}
