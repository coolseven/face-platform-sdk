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
     * @var int
     */
    private $expiresIn;
    /**
     * @var Carbon
     */
    private $expiresAt;

    public function __construct(string $accessToken, int $expiresInSeconds)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn   = $expiresInSeconds;
        $this->expiresAt   = Carbon::now()->addSeconds($expiresInSeconds);
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @return Carbon
     */
    public function getExpiresAt(): Carbon
    {
        return $this->expiresAt->clone();
    }

    public function needsRefresh(): bool
    {
        $safeSeconds = ceil($this->expiresIn * 0.2);

        return Carbon::now()->greaterThanOrEqualTo($this->getExpiresAt()->subSeconds($safeSeconds)) ;
    }

    public function __toString()
    {
        return $this->accessToken;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'access_token' => $this->getAccessToken(),
            'expires_in'   => $this->getExpiresIn(),
            'expires_at'   => $this->getExpiresAt()->toDateTimeString(),
        ];
    }
}