<?php


namespace Coolseven\FacePlatformSdk\Events;

use Coolseven\FacePlatformSdk\Resources\FaceSet;
use Psr\Http\Message\ResponseInterface;

class FaceSetCreated implements \JsonSerializable
{
    /**
     * @return FaceSet
     */
    public function getFaceSet(): FaceSet
    {
        return $this->faceSet;
    }

    /**
     * @return ResponseInterface
     */
    public function getRawResponse(): ResponseInterface
    {
        return $this->rawResponse;
    }
    /**
     * @var FaceSet
     */
    private $faceSet;
    /**
     * @var ResponseInterface
     */
    private $rawResponse;

    public function __construct(FaceSet $faceSet, ResponseInterface $rawResponse)
    {
        $this->faceSet = $faceSet;
        $this->rawResponse = $rawResponse;
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
            'face_set' => $this->getFaceSet(),
            'raw_response' => [
                'status_code' => $this->getRawResponse()->getStatusCode(),
                'reason_phrase' => $this->getRawResponse()->getReasonPhrase(),
                'headers' => $this->getRawResponse()->getHeaders(),
                'body' => $this->getRawResponse()->getBody()->getContents(),
            ],
        ];
    }
}