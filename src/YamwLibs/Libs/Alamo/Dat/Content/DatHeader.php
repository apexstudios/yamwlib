<?php
namespace YamwLibs\Libs\Alamo\Dat\Content;

/**
 * Containing the information from the header
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Alamo
 */
class DatHeader
{
    /**
     * The number of entries
     *
     * @var int
     */
    private $entryCount = 0;

    /**
     * The length information for all entries
     *
     * @var array
     */
    private $entryLengths = array();

    /**
     * Constructs a DatHeader
     *
     * @param int $entryCount
     * The number of entries
     *
     * @param array $entryLengths
     * The lengths of all entries
     */
    public function __construct($entryCount, array $entryLengths)
    {
        $this->entryCount = $entryCount;
        $this->entryLengths = $entryLengths;
    }

    /**
     * Gets the number of entries
     *
     * @return int
     */
    public function getEntryCount()
    {
        return $this->entryCount;
    }

    /**
     * Returns an array containing the lengths for each .dat file
     *
     * @return array
     */
    public function getEntryLengths()
    {
        return $this->entryLengths;
    }

    /**
     * Returns a single entry length info for an entry of a given index
     *
     * @param int $entryNumber
     * The index of the entry
     *
     * @return array
     * An array containing the length of the body and the name of the entry in
     * the .dat file
     */
    public function getEntryLength($entryNumber)
    {
        return isset($this->entryLengths[$entryNumber]) ?
            $this->entryLengths[$entryNumber] : null;
    }
}
