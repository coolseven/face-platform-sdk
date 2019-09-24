<?php


namespace Coolseven\FacePlatformSdk\Auth;


use Carbon\Carbon;

class AccessToken
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
}