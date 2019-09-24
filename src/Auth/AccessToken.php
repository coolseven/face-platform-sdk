<?php


namespace Coolseven\FacePlatformSdk\Auth;


use Carbon\Carbon;

class AccessToken implements \JsonSerializable
{
    /**
     * @var string
     */
    private $accessToken;
    /**
     * @var Carbon
     */
    private $expiresAt;

    public function __construct(string $accessToken, Carbon $expiresAt)
    {
        $this->accessToken  = $accessToken;
        $this->expiresAt    = $expiresAt;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return Carbon
     */
    public function getExpiresAt(): Carbon
    {
        return $this->expiresAt;
    }

    public function needsRefresh() : bool
    {
        return $this->getExpiresAt()->subMinutes(10)->lessThan(Carbon::now());
    }

    public function __toString()
    {
        return $this->accessToken;
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
            'access_token' => $this->getAccessToken(),
            'expires_at'   => $this->getExpiresAt()->toDateTimeString(),
        ];
    }
}