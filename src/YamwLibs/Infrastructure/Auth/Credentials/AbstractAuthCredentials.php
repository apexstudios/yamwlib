<?php
namespace YamwLibs\Infrastructure\Auth\Credentials;

/**
 * An abstract envelope for authentication credentials
 *
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Auth
 */
abstract class AbstractAuthCredentials
{
    private $envelope = array();

    protected function addToEnvelope($key, $value)
    {
        $this->envelope[$key] = $value;
    }

    protected function retrieveEnvelope()
    {
        return $this->envelope;
    }

    abstract public function getLoginCredentials();
}
