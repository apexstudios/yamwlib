<?php
namespace YamwLibs\Libs\Cli;

/**
 * Handles the $argv thingy
 *
 * @author AnhNhan <anhnhan@outlook.com>
 */
class CliArgs
{

    public static function parseArgv(array $argv)
    {
        if (!$argv) {
            return array(array(), array());
        }
        array_map('trim', $argv);

        // $key => $value
        $opts = array();

        // $i   => $value
        $nonopts = array();

        foreach ($argv as $i => $arg) {
            if ($arg[0] == '-') {
                $key = trim(array_shift($argv), '-');

                switch ($key) {
                    case 'color':
                    case 'cli':
                    case 'action':
                    case 'only':
                        // Std value, dummy
                        $val = true;
                        break;
                    default:
                        $val = array_shift($argv);
                        break;
                }

                $opts[$key] = $val;
            } else {
                $nonopts[] = array_shift($argv);
            }
        }

        return array($nonopts, $opts);
    }
}
