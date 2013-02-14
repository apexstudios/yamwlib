<?php
namespace YamwLibs\Infrastructure\Auth\Credentials;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Auth
 */
class DefaultAuthCredentials extends AbstractAuthCredentials
{
    public function __construct($userName, $password, $sessionId, $csrfKey)
    {
        $this->addToEnvelope("username", $userName);
        $this->addToEnvelope("password", $password);
        $this->addToEnvelope("sessionid", $sessionId);
        $this->addToEnvelope("csrf", $csrfKey);
    }

    public function getLoginCredentials()
    {
        $envelope = $this->retrieveEnvelope();
        return array(
            "username" => $envelope["username"],
            "password" => $envelope["password"],
        );
    }

    public function getCsrfKey()
    {
        $envelope = $this->retrieveEnvelope();

        return $envelope["csrf"];
    }

    public function getSessionId()
    {
        $envelope = $this->retrieveEnvelope();

        return $envelope["sessionId"];
    }
}
