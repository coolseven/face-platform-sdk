<?php


namespace Coolseven\FacePlatformSdk\Http\Responses;


use Coolseven\FacePlatformSdk\Resources\FaceSet;
use Psr\Http\Message\ResponseInterface;

class CreateFaceSetResponse extends BaseResponse implements \JsonSerializable
{
    /**
     * @var FaceSet
     */
    private $faceSet;

    public function __construct(FaceSet $faceSet, ResponseInterface $rawResponse)
    {
        parent::__construct($rawResponse);

        $this->faceSet = $faceSet;
    }

    /**
     * @return FaceSet
     */
    public function getFaceSet(): FaceSet
    {
        return $this->faceSet;
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
            'raw_response' => $this->getRawResponseForJsonSerialization(),
        ];
    }
}