<?php
namespace YamwLibs\Libs\Alamo\Dat;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 */
class DatParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DatParser
     */
    private $parser;

    public function setUp()
    {
        $this->parser = new DatParser;
    }

    /**
     * @dataProvider dataLengthBytes
     * @param mixed $byte1
     * @param mixed $byte2
     */
    public function testCanParseLengthBytes($exp, $byte1, $byte2 = null)
    {
        self::assertSame(
            $exp,
            $this->parser->parseLengthBytes(
                "$byte1",
                $byte2 === null ? null : "$byte2"
            )
        );
    }

    public function dataLengthBytes()
    {
        return array(
            array(57, "39"),
            array(57, "00", "39"),
            array(891, "03", "7B"),
            array(11833, "2E", "39"),
            array(18764, "49", "4C"),
            array(52480, "CD", "00"),
        );
    }

    /**
     * @dataProvider dataCounts
     * @param type $expCount
     * @param type $path
     */
    public function testCanReadCountRight($expCount, $path)
    {
        $this->parser->readString(file_get_contents($path));
        $header = $this->parser->parseHeader();

        self::assertSame($expCount, $header->getEntryCount());
    }

    public function dataCounts()
    {
        $basePath = __DIR__ . DIRECTORY_SEPARATOR . "mocks/";

        return array(
            array(1, $basePath . "test1.DAT"),
            array(5, $basePath . "test2.dat"),
            array(18764, $basePath . "MasterTextFile_ENGLISH.DAT"),
        );
    }

    /**
     * @dataProvider dataLengths
     * @param type $path
     * @param array $expLength
     */
    public function testCanReadLengthsRight($path, array $expLength)
    {
        $this->parser->readFile($path);
        $header = $this->parser->parseHeader();

        self::assertEquals($expLength, $header->getEntryLengths());
    }

    public function dataLengths() {
        $basePath = __DIR__ . DIRECTORY_SEPARATOR . "mocks/";

        return array(
            array(
                $basePath . "test1.DAT",
                array(
                    array('body' => 9, 'name' => 5),
                ),
            ),
            array(
                $basePath . "test2.dat",
                array(
                    array('body' => 3, 'name' => 4),
                    array('body' => 9, 'name' => 4),
                    array('body' => 6, 'name' => 4),
                    array('body' => 12, 'name' => 4),
                    array('body' => 15, 'name' => 4),
                ),
            ),
        );
    }

    /**
     * @dataProvider dataEntries
     * @param type $path
     * @param array $expEntries
     */
    public function testCanReadEntriesAlright($path, array $expEntries)
    {
        $this->parser->readFile($path);
        $datFile = $this->parser->parse();

        foreach ($expEntries as $name => $content) {
            self::assertEquals($content, $datFile->$name);
        }
    }

    public function dataEntries()
    {
        $basePath = __DIR__ . DIRECTORY_SEPARATOR . "mocks/";

        return array(
            array(
                $basePath . "test1.DAT",
                array(
                    "TITLE" => "TEXT_BODY",
                ),
            ),
            array(
                $basePath . "test2.dat",
                array(
                    "ABC1" => "ABCABCABCABC",
                    "ABC2" => "ABCABCABC",
                    "ABC3" => "ABC",
                    "ABC4" => "ABCABC",
                    "ABC5" => "ABCABCABCABCABC",
                ),
            ),
        );
    }

    /**
     * @expectedException Exception
     */
    public function testCantReadNonexistingFile()
    {
        $this->parser->readFile("gibberish");
        self::fail("Apparently I have broken the world.");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCantReadFromAnInt()
    {
        $this->parser->readString(42);
        self::fail("The world is broken.");
    }
}
