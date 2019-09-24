<?php


namespace Coolseven\FacePlatformSdk\Contracts;


use Coolseven\FacePlatformSdk\Auth\AccessToken;

interface StoresAccessToken
{
    public function getAccessToken() : ?AccessToken ;

    public function saveAccessToken(AccessToken $accessToken) : ?AccessToken ;
}