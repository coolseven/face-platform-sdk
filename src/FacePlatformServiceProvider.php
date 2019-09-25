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
            __DIR__.'/../config/face-platform.php' => $this->app->configPath('face-platform'),
        ]);
    }

    public function register() : void
    {
        $this->app->singleton(AuthConfig::class,function($app){
            $oauthServer = $app['config']->get('face-platform.oauth_server');
            $resourceServer = $app['config']->get('face-platform.resource_server');
            $clientId = $app['config']->get('face-platform.client_id');
            $clientSecret = $app['config']->get('face-platform.client_secret');
            $username = $app['config']->get('face-platform.username');
            $password = $app['config']->get('face-platform.password');

            return new AuthConfig($oauthServer,$resourceServer,$clientId,$clientSecret,$username,$password);
        });

        $this->app->singleton(StoresAccessToken::class,function($app){
            $cacheRepo = Cache::store($app['config']->get('face-platform.access_token_cache.store'));
            $cacheKey = $app['config']->get('face-platform.access_token_cache.key');
            return new AccessTokenStorage($cacheRepo,$cacheKey);
        });

        $this->app->singleton(FacePlatformClient::class, function ($app) {
            $authConfig = $app[AuthConfig::class];

            $accessTokenStorage = $app[StoresAccessToken::class];

            return new FacePlatformClient($authConfig,$accessTokenStorage);
        });
    }
}