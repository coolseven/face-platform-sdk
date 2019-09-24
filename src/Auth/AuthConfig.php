<?php


namespace Coolseven\FacePlatformSdk\Auth;


class AuthConfig implements \JsonSerializable
{
    /**
     * @var string
     */
    private $uri;
    /**
     * @var string
     */
    private $clientId;
    /**
     * @var string
     */
    private $clientSecret;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    public function __construct(
        string $uri,
        string $clientId,
        string $clientSecret,
        string $username,
        string $password
    )
    {
        $this->uri = $uri;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'uri' => $this->getUri(),
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
        ];
    }
}