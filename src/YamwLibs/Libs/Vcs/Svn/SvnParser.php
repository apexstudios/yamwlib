<?php
namespace YamwLibs\Libs\Vcs\Svn;

/**
 * Handles Svn stuff - uses the Cli binaries
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnParser
{
    public static function parseChangelistOutput(array $output)
    {
        $files_conflicting = preg_grep("/^[C]/", $output);
        $files_updated = preg_grep("/^[U]/", $output);
        $files_added = preg_grep("/^[A]/", $output);
        $files_deleted = preg_grep("/^[D]/", $output);
        $files_merged = preg_grep("/^[G]/", $output);

        return array(
            'added' => $files_added,
            'conflicting' => $files_conflicting,
            'deleted' => $files_deleted,
            'merged' => $files_merged,
            'updated' => $files_updated,
        );
    }

    public static function parseInfoOutput(array $output)
    {
        $info = array();

        foreach ($output as $line) {
            $split = explode(":", $line);
            $key = trim($split[0]);
            $value = trim($split[1]);

            $info[$key] = $value;
        }

        return $info;
    }
}
