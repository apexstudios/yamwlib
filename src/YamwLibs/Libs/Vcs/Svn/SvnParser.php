<?php
namespace YamwLibs\Libs\Vcs\Svn;

/**
 * Parses the output of several of the SVN commands into an understandable PHP
 * format for further processing
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Vcs
 */
class SvnParser
{
    /**
     * Parses a `changed list` output. Greps out the lines "worth a look".
     * Fishes out files considering their status in the `changed list`
     *
     * @param array $output
     * An array containing the inidivual lines
     *
     * @return array
     */
    public static function parseChangelistOutput(array $output)
    {
        $files_conflicting = preg_grep("/^[C]\s/", $output);
        $files_updated = preg_grep("/^[U]\s/", $output);
        $files_added = preg_grep("/^[A]\s/", $output);
        $files_deleted = preg_grep("/^[D]\s/", $output);
        $files_merged = preg_grep("/^[G]\s/", $output);

        $result = array(
            'added' => $files_added,
            'conflicting' => $files_conflicting,
            'deleted' => $files_deleted,
            'merged' => $files_merged,
            'updated' => $files_updated,
        );

        foreach ($result as &$array) {
            foreach ($array as $key => $value) {
                $array[$key] = trim(substr($value, 1));
            }
        }

        return $result;
    }

    /**
     * Parses a diff output, generating the left-side and right-side of a file
     * (presumably without context).
     *
     * @param array $output
     * An array with the individual lines of the diff
     *
     * @return array
     * A two-element array, with the first element containing the left-side of
     * a file in a diff, and the second element containing the right-side.
     */
    public static function parseDiffForSingleFile(array $diff)
    {
        $leftSide = array();
        $rightSide = array();

        foreach ($diff as $line) {
            if (preg_match("/^\+/", $line)) {
                $leftSide[] = $line;
            } elseif (preg_match("/^-/", $line)) {
                $rightSide[] = $line;
            } else {
                $leftSide[] = $line;
                $rightSide[] = $line;
            }
        }

        return array($leftSide, $rightSide);
    }

    /**
     * Parses the output of a single `svn info` entry
     *
     * @param array $output
     * An array containing the individual lines
     *
     * @return array
     * An array containing the info contained
     */
    public static function parseInfoOutput(array $output)
    {
        $info = array();

        foreach ($output as $line) {
            if (!$line) {
                continue;
            }

            $split = explode(":", $line);
            $key = trim($split[0]);
            $value = trim($split[1]);

            $info[$key] = $value;
        }

        return $info;
    }
}
