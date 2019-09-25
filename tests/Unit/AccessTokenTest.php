<?php


namespace Coolseven\FacePlatformSdk\Tests\Unit;


use Coolseven\FacePlatformSdk\Auth\AccessToken;
use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    /**
     * @test
     */
    public function access_token_needs_refresh_when_expired(): void
    {
        $accessToken = new AccessToken('abc',5);

        $this->assertFalse($accessToken->needsRefresh());

        sleep(3);
        $this->assertFalse($accessToken->needsRefresh());

        sleep(1); // access token should be refreshed a little earlier than it's expiration time
        $this->assertTrue($accessToken->needsRefresh());

        sleep(1);
        $this->assertTrue($accessToken->needsRefresh());
    }
}