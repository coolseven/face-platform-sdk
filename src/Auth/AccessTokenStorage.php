<?php


namespace Coolseven\FacePlatformSdk\Auth;


use Coolseven\FacePlatformSdk\Contracts\StoresAccessToken;
use Illuminate\Contracts\Cache\Repository;

class AccessTokenStorage implements StoresAccessToken
{
    /**
     * @var Repository
     */
    private $cacheRepo;

    /**
     * @var string
     */
    private $cacheKey;

    public function __construct(Repository $cache, string $cacheKey)
    {
        $this->cacheRepo = $cache;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @return AccessToken
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAccessToken(): ?AccessToken
    {
        return $this->cacheRepo->get($this->cacheKey);
    }

    /**
     * @param AccessToken $accessToken
     *
     * @return AccessToken|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function saveAccessToken(AccessToken $accessToken) : ?AccessToken
    {
        $this->cacheRepo->put($this->cacheKey,$accessToken);

        return $this->getAccessToken();
    }
}