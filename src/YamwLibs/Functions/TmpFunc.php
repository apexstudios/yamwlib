<?php
namespace YamwLibs\Functions;

/**
 * Provides functions for temporary stuff
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Functions
 */
class TmpFunc
{
    /**
     * Taken from php.net, sys_get_tmp_dir()?
     * @param string $dir
     * @param type $prefix
     * @param type $mode
     * @return string
     */
    public static function tempdir($dir, $prefix = '', $mode = 0700)
    {
        if (substr($dir, -1) != DIRECTORY_SEPARATOR) {
            $dir .= DIRECTORY_SEPARATOR;
        }

        do {
            $path = $dir . $prefix . mt_rand(0, 9999999);
        } while (!mkdir($path, $mode));

        return $path;
    }
}
