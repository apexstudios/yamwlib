<?php
namespace YamwLibs\Infrastructure\Auth\Models;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Auth
 */
abstract class AbstractAuthUserModel
{
    abstract public function getUserId();
    abstract public function getUserName();
    abstract public function getHashedPw();
    abstract public function getSalt();
    abstract public function getEmail();
}
