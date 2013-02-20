<?php
namespace YamwLibs\Functions;

/**
 * Provides functions for file handling
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Functions
 */
class FileFunc
{
    public static function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}
