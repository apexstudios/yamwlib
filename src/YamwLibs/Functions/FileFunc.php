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
    /**
     * Taken from php.net, rmdir()
     * @param type $dir
     * @return type
     */
    public static function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
    
    /**
     * 
     * @param string $dirName The directory to start from
     * @param string $extension
     * @return array All files matching with the specified extension (or any)
     * in a directory and its subdirectories
     */
    function recursiveScanForDirectories($dirName, $extension = '.*')
    {
        $dirList = scandir($dirName);
        $files = array();

        foreach ($dirList as $entry) {
            if (in_array($entry, array('.', '..'))) {
                continue;
            }

            $name = $dirName . '/' . $entry;
            if (is_dir($name)) {
                $files = array_merge($files, self::recursiveScanForDirectories($name));
            } else {
                if (
                    !strpos($entry, '.') !== 0 &&
                    preg_match('/'.$extension.'$/', $entry)
                ) {
                    $files[] = $name;
                }
            }
        }

        return $files;
    }

    /**
     * 
     * @param array $paths
     * @param type $prefix
     * @return type
     */
    function sanitizeStringsFromPrefix(array $paths, $prefix)
    {
        $files = array();

        // Sanitize file names to be relative instead of absolute
        foreach ($paths as $file) {
            $newFileName = str_replace(
                "\\",
                "/",
                ltrim(
                    preg_replace('/^'.preg_quote($prefix, '/').'/', "", $file),
                    " \\/"
                )
            );

            $files[] = $newFileName;
        }

        return $files;
    }

}
