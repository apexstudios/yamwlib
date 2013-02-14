<?php
namespace YamwLibs\Libs\Alamo\Dat;

/**
 * Represents a .dat string file
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Alamo
 */
class DatObject
{
    /**
     * The header of the .dat file
     *
     * @var Content\DatHeader
     */
    private $header;

    /**
     * The entries in the .dat file
     *
     * @var array
     */
    private $entries = array();

    /**
     * Constructs a DatObject - how obvious, Captain
     *
     * @param \YamwLibs\Libs\Alamo\Dat\Content\DatHeader $header
     * The header object
     *
     * @param array $entries
     * The entries in the .dat file
     */
    public function __construct(Content\DatHeader $header, array $entries)
    {
        $this->header = $header;
        $this->entries = $entries;
    }

    /**
     * Gets the header of the .dat file
     *
     * @return Content\DatHeader
     */
    public function getHeader()
    {
        return $this->header;
    }

    public function __get($name)
    {
        return isset($this->entries[$name]) ? $this->entries[$name] : null;
    }

    public function __set($name, $value)
    {
        if (isset($this->entries[$name])) {
            $this->entries[$name] = $value;
        } else {
            throw new \RuntimeException("No entry $name exists!");
        }
    }
}
