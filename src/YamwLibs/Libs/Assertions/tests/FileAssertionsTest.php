<?php
namespace YamwLibs\Libs\Assertions;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class FileAssertionsTest extends \PHPUnit_Framework_TestCase
{
    public function testWorksOnExistingFiles()
    {
        // Stub
        $file = __DIR__ . "/mocks/existing_file";
        $this->assertTrue(FileAssertions::assertFileExists($file));
    }

    /**
     * @expectedException YamwLibs\Libs\Assertions\Exceptions\FileNotFoundException
     */
    public function testTyposInPathHaveHorrendousEffects()
    {
        // Stub
        $file = __DIR__ . "/mocks/ekusiszingu_fairu";
        FileAssertions::assertFileExists($file);
    }
}
