<?php
namespace YamwLibs\Libs\Alamo\Dat;

/**
 * Parses the .dat text string files
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Alamo
 */
class DatParser
{
    /**
     * @var string
     */
    private $fileContent = "";

    /**
     * @var resource
     */
    private $filePointer;

    /**
     * @var int
     */
    private $stringCursor = 0;

    /**
     * Reads a .dat file from disk
     *
     * @param string $path
     * The path to the file - preferably an absolute one, unless you know where
     * this class is saved on disk
     *
     * @throws \Exception
     * If the file had not been found
     */
    public function readFile($path)
    {
        if (!file_exists($path)) {
            throw new \Exception("File $path does not exist");
        }

        $this->fileContent = "";
        $this->filePointer = fopen($path, 'r');

        while (!feof($this->filePointer)) {
            $this->fileContent .= fread($this->filePointer, 4096);
        }
    }

    /**
     * Loads a .dat file passed over as a string - useful for loading from
     * database
     *
     * @param string $string
     * The .dat file as a string
     *
     * @throws \InvalidArgumentException
     * If it's not a string
     */
    public function readString($string)
    {
        if (!is_string($string) || !strlen($string)) {
            throw new \InvalidArgumentException("Invalid string given");
        }

        $this->fileContent = $string;
    }

    /**
     * Parses the loaded .dat file
     *
     * @return \YamwLibs\Libs\Alamo\Dat\DatObject
     * The parsed .dat file, containing the entries
     */
    public function parse()
    {
        $header = $this->parseHeader();
        $body = $this->parseBody($header);
        $names = $this->parseNames($header);

        $entries = array_combine($names, $body);

        return new DatObject($header, $entries);
    }

    /**
     * Parses the header of a .dat file
     *
     * @return YamwLibs\Libs\Alamo\Dat\Content\DatHeader
     * The header object
     */
    public function parseHeader()
    {
        // First check if the entry count is two bytes or one byte long, and
        // assign it accordingly
        $entryCount = $this->readLength();

        $this->jumpSpacing();

        // Now reading lengths
        $lengths = $this->parseLengths($entryCount);

        return new Content\DatHeader($entryCount, $lengths);
    }

    /**
     * Parses a binary/hexadecimal number into a decimal one
     *
     * @param string $byte1
     * A string containing the hexadecimal representation of the first byte
     *
     * @param type $byte2 [optional]
     * A string containing the hexadecimal representation of the second byte
     *
     * @return int
     * The parsed number
     */
    public function parseLengthBytes($byte1, $byte2 = null)
    {
        if ($byte2 === null) {
            return hexdec($byte1);
        } else {
            return hexdec($byte1 . $byte2);
        }
    }

    /**
     * Fishes the number of entries from the .dat file
     *
     * @return int
     * The number of entries contained in this .dat file
     */
    protected function readLength()
    {
        $b1 = $this->fileContent[$this->stringCursor];
        $b2 = $this->fileContent[$this->stringCursor + 1];

        if (ord($b2) !== 0x00) { // Use second byte
            $length = $this->parseLengthBytes(bin2hex($b1), bin2hex($b2));
            $this->jump(2);
        } else { // Use one byte only
            $length = $this->parseLengthBytes(bin2hex($b1));
            $this->jump(1);
        }

        return $length;
    }

    /**
     * Parses the entry lengths for this .dat file
     *
     * @param type $entryCount
     * The number of entries to parse
     *
     * @return array
     * The array containing the lengths of each entry in this .dat file
     */
    protected function parseLengths($entryCount)
    {
        $lengths = array();

        for ($ii = 0; $ii < $entryCount; $ii++) {
            $length = array();

            // Skip the gibberish
            $this->jumpWeirdThing();

            $length['body'] = $this->readLength();
            $this->jumpSpacing();

            $length['name'] = $this->readLength();
            $this->jumpSpacing();

            $lengths[] = $length;
        }

        return $lengths;
    }

    /**
     * Parses the strings contained in the body
     *
     * @param \YamwLibs\Libs\Alamo\Dat\Content\DatHeader $header
     * The header object
     *
     * @return array
     */
    public function parseBody(Content\DatHeader $header)
    {
        return $this->parseStrings($header, true);
    }

    /**
     * Parses the name strings
     *
     * @param \YamwLibs\Libs\Alamo\Dat\Content\DatHeader $header
     * The header object
     *
     * @return array
     */
    public function parseNames(Content\DatHeader $header)
    {
        return $this->parseStrings($header, false);
    }

    /**
     * Parses the entries
     *
     * @param \YamwLibs\Libs\Alamo\Dat\Content\DatHeader $header
     * The header object of this file
     *
     * @param bool $readBody
     * Whether it is reading the body or the names
     *
     * @return array An array containing the values
     */
    protected function parseStrings(Content\DatHeader $header, $readBody)
    {
        $strings = array();
        $c =& $this->stringCursor;
        $f =& $this->fileContent;

        for ($ii = 0; $ii < $header->getEntryCount(); $ii++) {
            $string = "";
            $length = $header->getEntryLength($ii);

            if ($readBody) {
                // We're using UTF-16LE for the text body
                // Read two bytes for each character
                $bytes = substr($f, $c, $length['body'] * 2);
                $string = mb_convert_encoding($bytes, "UTF8", "UTF-16LE");

                $this->jump($length['body'] * 2);
            } else {
                $string = substr($f, $c, $length['name']);
                $this->jump($length['name']);
            }

            $strings[] = $string;
        }

        return $strings;
    }

    /**
     * Advances the cursor
     *
     * @param int $length
     * How far to advance the cursor, in characters
     *
     * @return int
     * The new cursor position
     */
    public function jump($length)
    {
        $this->stringCursor += $length;
        return $this->stringCursor;
    }

    /**
     * Advances the cursor by the size of a spacing, usually three bytes
     *
     * @return int
     * The new cursor position
     */
    public function jumpSpacing()
    {
        return $this->jump(3);
    }

    /**
     * Advances the cursor by the size of the gibberish four bytes
     *
     * @return int
     * The new cursor position
     */
    public function jumpWeirdThing()
    {
        return $this->jump(4);
    }
}
