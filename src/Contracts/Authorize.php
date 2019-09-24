<?php


namespace Coolseven\FacePlatformSdk\Contracts;


use Coolseven\FacePlatformSdk\Auth\AccessToken;

interface Authorize
{
    public function getValidAccessToken() : AccessToken;

    public function refreshAccessToken() : AccessToken;
}