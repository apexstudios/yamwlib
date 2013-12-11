<?php
namespace YamwLibs\Infrastructure\Printers;

/**
 * @author Anh Nhan Nguyen <anhnhan@outlook.com>
 * @package AnLang
 * @subpackage Printers
 */
class ArrayPrinter
{
    private $indent = true;
    private $indentSize = 2;

    public function setDoIndent($indent = true)
    {
        $this->indent = $indent;
    }

    public function setIndentSize($size = 2)
    {
        $this->indentSize = $size;
    }

    public function printForFile(array $array)
    {
        ob_start();
        echo str_repeat("\n", 2);

        echo "return ";
        $this->printArray($array);

        $printedOutput = substr(ob_get_clean(), 0, -2) . ";\n";
        return $printedOutput;
    }

    public function printArray(array $array, $lvl = 0)
    {
        $this->printSpacedLine("array(");

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->printSpacing($lvl + 1);
                echo sprintf('"%s" => ', $key);
                $this->printArray($value, $lvl + 1);
            } else {
                $this->printArrayEntry($key, $value, $lvl + 1);
            }
        }

        $this->printSpacedLine("),", $lvl);
    }

    private function printArrayEntry($key, $value, $lvl = 0)
    {
        if (is_numeric($key)) {
            $this->printSpacedLine(
                sprintf('"%s",', $value),
                $lvl
            );
        } else {
            $this->printSpacedLine(
                sprintf('"%s" => "%s",', $key, $value),
                $lvl
            );
        }
    }

    private function printSpacing($lvl = 0)
    {
        if ($this->indent) {
            echo str_repeat(" ", $this->indentSize * $lvl);
        }
    }

    private function printSpacedLine($text, $lvl = 0)
    {
        $this->printSpacing($lvl);
        echo $text;
        echo "\n";
    }
}
