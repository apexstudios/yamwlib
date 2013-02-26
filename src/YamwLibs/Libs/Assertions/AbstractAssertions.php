<?php
namespace YamwLibs\Libs\Assertions;

/**
 * PRoviding basic functionality for assertions
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package Yamw
 * @subpackage Assertions
 */
abstract class AbstractAssertions
{
    protected static function throwException(
        $msg,
        $msg_default,
        $code = self::CODE_NOT_ARRAY,
        $class = "\InvalidArgumentException"
    ) {
        throw new $class(
            $msg ? $msg :
            $msg_default,
            $code
        );
    }
}
