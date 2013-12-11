<?php
namespace YamwLibs\Infrastructure\Printers;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 * @package AnLang
 * @subpackage Printers
 */
class ArrayPrinterTest extends \PHPUnit_Framework_TestCase
{
    public function testCanPrint()
    {
        $printer = new ArrayPrinter();
        $output = $printer->printForFile(["hi", "bar" => "baz", ["bum"]]);
        $exp = <<<TTT


return array(
  "hi",
  "bar" => "baz",
  "1" => array(
    "bum",
  ),
);

TTT;
        self::assertEquals($exp, $output);
    }

    public function testCanDisableIndent()
    {
        $printer = new ArrayPrinter();
        $printer->setDoIndent(false);
        $output = $printer->printForFile(["hi", "baz", ["bum"]]);
        $exp = <<<TTT


return array(
"hi",
"baz",
"2" => array(
"bum",
),
);

TTT;
        self::assertEquals($exp, $output);
    }

    public function testCanSetIndentSize()
    {
        $printer = new ArrayPrinter();
        $printer->setIndentSize(4);
        $output = $printer->printForFile(["hi", "baz", ["bum"]]);
        $exp = <<<TTT


return array(
    "hi",
    "baz",
    "2" => array(
        "bum",
    ),
);

TTT;
        self::assertEquals($exp, $output);
    }
}
