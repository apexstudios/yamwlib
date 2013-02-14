<?php
namespace YamwLibs\Infrastructure\Auth;

/**
 * @author AnhNhan <anhnhan@outlook.com>
 * @package YamwLibs
 * @subpackage Auth
 */
class Auth
{
    /**
     * @var Adapters\AbstractAuthAdapter
     */
    private $adapter;

    public function setAdapter(Adapters\AbstractAuthAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function login(Credentials\AbstractAuthCredentials $credentials)
    {
        // Stub
        if (!$this->adapter) {
            // TODO: Set default adapter
            $this->setAdapter();
        }

        try {
            $this->adapter->validateCredentials($credentials);
        } catch (Exceptions\InvalidCredentialsException $e) {
            throw $e;
        }
    }
}
