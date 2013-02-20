<?php
namespace YamwLibs\Libs\Archives;

/**
 * Creates zips for you
 *
 * Taken from the internet. Likely to be php.net, but doubtable.
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Archives
 */
class Zip
{
    /**
     * Creates a compressed zip file
     */
    public static function createZip(
        $files = array(),
        $destination = '',
        $overwrite = false
    ) {
        //if the zip file already exists and overwrite is false, return false
        if (file_exists($destination) && !$overwrite) {
            return false;
        }
        //vars
        $valid_files = array();
        //if files were passed in...
        if (is_array($files)) {
            //cycle through each file
            foreach ($files as $file) {
                //make sure the file exists
                if (file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if (count($valid_files)) {
            //create the archive
            $zip = new \ZipArchive();
            if ($zip->open($destination, $overwrite ? \ZipArchive::OVERWRITE : \ZipArchive::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach ($valid_files as $file) {
                $zip->addFile($file, $file);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        } else {
            return false;
        }
    }

    /**
     * Taken from php.net
     *
     * @param type $folder
     * @param type $zipFile
     * @param type $subfolder
     * @return boolean
     */
    public static function folderToZip($folder, &$zipFile, $subfolder = null)
    {
        if ($zipFile == null) {
            // no resource given, exit
            return false;
        }
        // we check if $folder has a slash at its end, if not, we append one
        $folder .= end(str_split($folder)) == "/" ? "" : "/";
        $subfolder .= end(str_split($subfolder)) == "/" ? "" : "/";
        // we start by going through all files in $folder
        $handle = opendir($folder);
        while ($f = readdir($handle)) {
            if ($f != "." && $f != "..") {
                if (is_file($folder . $f)) {
                    // if we find a file, store it
                    // if we have a subfolder, store it there
                    if ($subfolder != null)
                        $zipFile->addFile($folder . $f, $subfolder . $f);
                    else
                        $zipFile->addFile($folder . $f);
                } elseif (is_dir($folder . $f)) {
                    // if we find a folder, create a folder in the zip
                    $zipFile->addEmptyDir($f);
                    // and call the function again
                    self::folderToZip($folder . $f, $zipFile, $f);
                }
            }
        }
    }
}
