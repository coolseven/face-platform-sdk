<?php


namespace Tests;


use Coolseven\FacePlatformSdk\Auth\AccessTokenStorage;
use Coolseven\FacePlatformSdk\Auth\AuthConfig;
use Coolseven\FacePlatformSdk\FacePlatformClient;
use Illuminate\Support\Facades\Cache;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @return FacePlatformClient
     */
    public function makeFacePlatformClient(): FacePlatformClient
    {
        return new FacePlatformClient(
            $this->getAuthConfig(),
            $this->getAccessTokenStorage()
        );
    }

    /**
     * @return AuthConfig
     */
    public function getAuthConfig(): AuthConfig
    {
        return new AuthConfig(
            getenv('FACE_PLATFORM_URI'),
            getenv('FACE_PLATFORM_CLIENT_ID'),
            getenv('FACE_PLATFORM_CLIENT_SECRET'),
            getenv('FACE_PLATFORM_USERNAME'),
            getenv('FACE_PLATFORM_PASSWORD')
        );
    }

    /**
     * @return AccessTokenStorage
     */
    public function getAccessTokenStorage(): AccessTokenStorage
    {

        return new AccessTokenStorage(
           Cache::store('file'),
            getenv('FACE_PLATFORM_CACHE_KEY')
        );
    }
}