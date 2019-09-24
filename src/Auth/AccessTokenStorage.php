<?php


namespace Coolseven\FacePlatformSdk\Auth;


use Coolseven\FacePlatformSdk\Contracts\StoresAccessToken;
use Psr\SimpleCache\CacheInterface;

class AccessTokenStorage implements StoresAccessToken
{
    /**
     * @var CacheInterface
     */
    private $cacheRepo;

    /**
     * @var string
     */
    private $cacheKey;

    public function __construct(CacheInterface $cache, string $cacheKey)
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
        return unserialize($this->cacheRepo->get($this->cacheKey));
    }

    /**
     * @param AccessToken $accessToken
     *
     * @return AccessToken|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function saveAccessToken(AccessToken $accessToken) : ?AccessToken
    {
        $this->cacheRepo->set($this->cacheKey,serialize($accessToken));

        return $this->getAccessToken();
    }
}