<?php


namespace Coolseven\FacePlatformSdk;


use Coolseven\FacePlatformSdk\Auth\AuthConfig;
use Coolseven\FacePlatformSdk\Contracts\StoresAccessToken;
use Coolseven\FacePlatformSdk\Auth\AccessTokenStorage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class FacePlatformServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/face-platform-sdk.php' => $this->app->configPath('face-platform-sdk.php'),
        ],'face-platform-sdk.config');
    }

    public function register() : void
    {
        $this->app->singleton(AuthConfig::class,function($app){
            $oauthServer = $app['config']->get('face-platform-sdk.oauth_server');
            $resourceServer = $app['config']->get('face-platform-sdk.resource_server');
            $clientId = $app['config']->get('face-platform-sdk.client_id');
            $clientSecret = $app['config']->get('face-platform-sdk.client_secret');
            $username = $app['config']->get('face-platform-sdk.username');
            $password = $app['config']->get('face-platform-sdk.password');

            return new AuthConfig($oauthServer,$resourceServer,$clientId,$clientSecret,$username,$password);
        });

        $this->app->singleton(StoresAccessToken::class,function($app){
            $cacheRepo = Cache::store($app['config']->get('face-platform-sdk.access_token_cache.store'));
            $cacheKey = $app['config']->get('face-platform-sdk.access_token_cache.key');
            return new AccessTokenStorage($cacheRepo,$cacheKey);
        });

        $this->app->singleton(FacePlatformClient::class, function ($app) {
            $authConfig = $app[AuthConfig::class];

            $accessTokenStorage = $app[StoresAccessToken::class];

            return new FacePlatformClient($authConfig,$accessTokenStorage);
        });
    }
}