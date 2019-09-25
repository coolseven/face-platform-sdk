<?php


namespace Coolseven\FacePlatformSdk\Tests\Unit;


use Coolseven\FacePlatformSdk\Auth\AccessToken;
use Coolseven\FacePlatformSdk\Tests\CreateNewFacePlatformClient;
use Orchestra\Testbench\TestCase;

class AccessTokenStorageTest extends TestCase
{
    use CreateNewFacePlatformClient;

    /**
     * @test
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function access_token_storage_can_use_cache(): void
    {
        $storage = $this->getAccessTokenStorage();

        $ttlInSeconds = 3;
        $accessToken = new AccessToken('abc',$ttlInSeconds);

        $storage->saveAccessToken($accessToken);
        $accessTokenFromCache = $storage->getAccessToken();

        $this->assertNotNull($accessTokenFromCache);
        $this->assertIsObject($accessTokenFromCache);
        $this->assertEquals($accessToken,$accessTokenFromCache);
    }

    /**
     * @test
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function access_token_cache_should_be_deleted_after_a_ttl(): void
    {
        $storage = $this->getAccessTokenStorage();

        $ttlInSeconds = 1;
        $accessToken = new AccessToken('abc',$ttlInSeconds);

        $storage->saveAccessToken($accessToken);

        $this->assertNotNull($storage->getAccessToken());

        sleep($ttlInSeconds);
        $this->assertNull($storage->getAccessToken());
    }
}