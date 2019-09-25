<?php


namespace Coolseven\FacePlatformSdk\Http;

use Coolseven\FacePlatformSdk\Auth\AuthConfig;

/**
 * Trait getUrisForRequests
 *
 * @property-read AuthConfig $authConfig
 * @package Coolseven\FacePlatformSdk\Http
 */
trait calcUrisForRequests
{
    private function getUriForAccessToken()
    {
        return $this->authConfig->getOauthServerUriBase() . '/oauth/token';
    }

    private function getUriForFaceSets()
    {
        return $this->authConfig->getResourceServerUriBase() . '/api/v1/face-sets';
    }

    private function getUriForFaces(string $faceSetId)
    {
        return $this->authConfig->getResourceServerUriBase() . '/api/v1/face-sets/'.$faceSetId.'/faces';
    }

    private function getUriForFaceSearches(string $faceSetId)
    {
        return $this->authConfig->getResourceServerUriBase() . '/api/v1/face-sets/'.$faceSetId.'/face-searches';
    }
}