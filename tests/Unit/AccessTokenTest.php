<?php


namespace Coolseven\FacePlatformSdk\Tests\Unit;




use Carbon\Carbon;
use Coolseven\FacePlatformSdk\Auth\AccessToken;
use Orchestra\Testbench\TestCase;

class AccessTokenTest extends TestCase
{
    /**
     * @test
     */
    public function access_token_needs_refresh_when_expired(): void
    {
        /** @var Carbon $expiresAt */
        $expiresAt = Carbon::now()->subMinutes();

        $accessToken = new AccessToken('abc',$expiresAt);

        $this->assertTrue($accessToken->needsRefresh());
    }
}