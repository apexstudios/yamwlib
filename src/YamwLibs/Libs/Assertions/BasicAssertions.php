<?php
namespace YamwLibs\Libs\Assertions;

/**
 * Abstract class to provide self-checks for parameters, arguments etc.
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package Yamw
 * @subpackage Assertions
 */
abstract class BasicAssertions extends AbstractAssertions {
    const CODE_NOT_STRING = 10;
    const CODE_NOT_NUMERIC = 20;
    const CODE_NOT_ARRAY = 30;
    const CODE_NOT_NUMBER = 40;
    const CODE_NOT_INT = 50;
    const CODE_NOT_FLOAT = 60;

    const CODE_NOT_OBJECT = 90;

    const CODE_NOT_EMPTY = 70;
    const CODE_NOT_SET = 80;

    const CODE_EMPTY_ARRAY = 35;
    const CODE_EMPTY_STRING = 15;

    const CODE_NOT_TYPEOF = 100;

    const CODE_NOT_ENUM = 110;

    const CODE_NOT_EQUAL = 120;
    const CODE_NOT_SAME = 130;

    public static function assertIsString($var, $msg = null)
    {
        if (!is_string($var)) {
            self::throwException(
                $msg,
                "Invalid string given",
                self::CODE_NOT_STRING
            );
        }
    }

    public static function assertIsNumeric($var, $msg = null)
    {
        if (!is_numeric($var)) {
            self::throwException(
                $msg,
                "Invalid numeric given",
                self::CODE_NOT_NUMERIC
            );
        }
    }

    public static function assertIsArray($var, $msg = null)
    {
        if (!is_array($var)) {
            self::throwException(
                $msg,
                "Invalid array given",
                self::CODE_NOT_ARRAY
            );
        }
    }

    public static function assertIsNumber($var, $msg = null)
    {
        if (!is_int($var) && !is_float($var)) {
            self::throwException(
                $msg,
                "Invalid number given",
                self::CODE_NOT_NUMBER
            );
        }
    }

    /**
     * Asserts that the value $var is of the type integer
     *
     * @param mixed $var
     * @param string $msg
     */
    public static function assertIsInt($var, $msg = null)
    {
        if (gettype($var) != 'integer') {
            self::throwException(
                $msg,
                "Invalid integer given",
                self::CODE_NOT_INT
            );
        }
    }

    public static function assertIsFloat($var, $msg = null)
    {
        if (gettype($var) != 'double') {
            self::throwException(
                $msg,
                "Invalid float given",
                self::CODE_NOT_FLOAT
            );
        }
    }

    public static function assertIsObject($var, $msg = null)
    {
        if (!is_object($var)) {
            self::throwException(
                $msg,
                "Invalid object given",
                self::CODE_NOT_OBJECT
            );
        }
    }

    public static function assertIsEmpty($var, $msg = null)
    {
        if (!empty($var)) {
            self::throwException(
                $msg,
                "Invalid empty value given",
                self::CODE_NOT_EMPTY
            );
        }
    }

    public static function assertIsSet($var, $msg = null)
    {
        if (!isset($var)) {
            self::throwException(
                $msg,
                "Invalid unempty value given",
                self::CODE_NOT_SET
            );
        }
    }

    public static function assertIsFilledArray($var, $msg = null)
    {
        if (!is_array($var) || count($var) === 0) {
            self::throwException(
                $msg,
                "Empty array given",
                self::CODE_EMPTY_ARRAY
            );
        }
    }

    public static function assertIsFilledString($var, $msg = null)
    {
        if (!is_string($var) || strlen($var) === 0) {
            self::throwException(
                $msg,
                "Empty string given",
                self::CODE_EMPTY_STRING
            );
        }
    }

    public static function assertIsTypeOf($var, $class, $msg = null)
    {
        if (!is_object($var)) {
            self::throwException(
                $msg,
                "Invalid object given",
                self::CODE_NOT_OBJECT
            );
        }

        if (!($var instanceof $class)) {
            self::throwException(
                $msg,
                get_class($var)." is not of the type $class",
                self::CODE_NOT_TYPEOF
            );
        }
    }

    public static function assertIsEnum($var, array $enums, $msg = null)
    {
        foreach ($enums as $enum) {
            if ($enum === $var) {
                return;
            }
        }

        self::throwException(
            $msg,
            "$var is not one of these values: ".implode($enums, ", "),
            self::CODE_NOT_ENUM
        );
    }

    public static function assertIsEqual($var, $exp, $msg = null)
    {
        if ($var != $exp) {
            self::throwException(
                $msg,
                "$var does not equal $exp",
                self::CODE_NOT_EQUAL
            );
        }
    }

    public static function assertIsSame($var, $exp, $msg = null)
    {
        if ($var !== $exp) {
            self::throwException(
                $msg,
                "$var is not same as $exp",
                self::CODE_NOT_SAME
            );
        }
    }
}
