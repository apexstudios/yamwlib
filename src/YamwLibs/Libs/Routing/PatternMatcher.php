<?php
namespace YamwLibs\Libs\Routing;

/**
 * Matches patterns for routes
 *
 * Url:
 * /lsf/home
 *
 * Pattern:
 * /:app/:module
 *
 * Result:
 * [
 *   "app" => "lsf",
 *   "module" => "home"
 * ]
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package RZWebStack
 * @subpackage PatternMatchers
 */
class PatternMatcher
{
    public static function extract($string, $pattern)
    {
        // Note: we assume that ::doesMatch applies
        // hence we barely do any checks


        // Strip beginning and trailing slashes and spaces
        $pattern = self::sanitize($pattern);
        $string = self::sanitize($string);

        $patternParts = explode("/", $pattern);
        $stringParts = explode("/", $string);
        // Not same amount of elements, thus never could match
        // We now hereby save a lot of resources by skipping this loop sequence
        if (count($patternParts) != count($stringParts)) {
            return false;
        }

        $extractedVariables = array();

        foreach ($patternParts as $partIndex => $partContent) {
            if (preg_match('/^:.*?/', $partContent)) {
                // It's a variable
                $extractedVariables[ltrim($partContent, ':')] = $stringParts[$partIndex];
            }
        }

        return $extractedVariables;
    }

    /**
     * Checks whether the requirements are met
     *
     * Requirements:
     * 1. Number of parts (separated by slashes) are the same
     * 2. Non-variable content the same
     *
     * @param type $string
     * @param type $pattern
     */
    public static function isMatching($string, $pattern)
    {
        // Strip beginning and trailing slashes and spaces
        $pattern = self::sanitize($pattern);
        $string = self::sanitize($string);

        $patternParts = explode("/", $pattern);
        $stringParts = explode("/", $string);

        // Not same amount of elements, thus never could match
        // We now hereby save a lot of resources by skipping this loop sequence
        if (count($patternParts) != count($stringParts)) {
            return false;
        }

        foreach ($patternParts as $partIndex => $partContent) {
            if (preg_match('/^:.*?/', $partContent)) {
                // It's a variable
                // No need to compare, just continue to the next part
                continue;
            } else {
                // It's not a variable
                if ($partContent !== $stringParts[$partIndex]) {
                    // String does not match
                    return false;
                }
            }
        }

        return true;
    }

    private static function sanitize($string)
    {
        return trim($string, "/ ");
    }
}
