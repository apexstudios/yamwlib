<?php
namespace YamwLibs\Infrastructure\Auth\Adapters;

use YamwLibs\Infrastructure\Auth\Models;
use YamwLibs\Infrastructure\Auth\Credentials;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Auth
 */
abstract class AbstractAuthAdapter
{
    abstract public function validateCredentials(Credentials\AbstractAuthCredentials $credentials);

    abstract public function insertNewUser(Models\AbstractAuthUserModel $user);

    abstract public function getCookieList();

    abstract public function setCookies();
}
