<?php


namespace Coolseven\FacePlatformSdk\Events;

use Coolseven\FacePlatformSdk\Resources\FaceSet;
use Psr\Http\Message\ResponseInterface;

class AccessTokenRefreshed implements \JsonSerializable
{
    /**
     * @var string
     */
    private $refreshedAccessToken;

    public function __construct(string $refreshedAccessToken)
    {
        $this->refreshedAccessToken = $refreshedAccessToken;
    }

    /**
     * @return string
     */
    public function getRefreshedAccessToken(): string
    {
        return $this->refreshedAccessToken;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'refreshed_access_token' => $this->getRefreshedAccessToken(),
        ];
    }
}