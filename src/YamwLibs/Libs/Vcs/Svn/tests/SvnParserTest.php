<?php
namespace YamwLibs\Libs\Vcs\Svn;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class SvnParserTest extends \PHPUnit_Framework_TestCase
{
    public function getPreparedMock($name)
    {
        $path = __DIR__ . "/mocks/" . $name;
        $content = file_get_contents($path);
        return preg_split("/\n/", $content);
    }

    public function testChangelistOutputParsing()
    {
        $output = $this->getPreparedMock("svn-up-r3-r2.txt");

        $expResult = array(
            "deleted" => array(
                "trunk\TestClass2.php"
            ),
            "updated" => array(
                "trunk\TestClass.php"
            )
        );

        $result = SvnParser::parseChangelistOutput($output);
        
        self::assertTrue(in_array($expResult["deleted"][0], $result["deleted"]));
        self::assertTrue(in_array($expResult["updated"][0], $result["updated"]));
        self::assertCount(1, $result["deleted"]);
        self::assertCount(1, $result["updated"]);

        self::assertCount(0, $result["added"]);
        self::assertCount(0, $result["conflicting"]);
        self::assertCount(0, $result["merged"]);
    }
}
