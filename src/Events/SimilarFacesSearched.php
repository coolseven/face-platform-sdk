<?php


namespace Coolseven\FacePlatformSdk\Events;

use Coolseven\FacePlatformSdk\Resources\Face;
use Coolseven\FacePlatformSdk\Resources\SimilarFace;
use Psr\Http\Message\ResponseInterface;

class SimilarFacesSearched implements \JsonSerializable
{
    /**
     * @var SimilarFace[]
     */
    private $similarFaces;
    /**
     * string
     */
    private $faceSetId;
    /**
     * @var string
     */
    private $imageBase64;
    /**
     * @var ResponseInterface
     */
    private $rawResponse;

    public function __construct(array $similarFaces,string $faceSetId, string $imageBase64, ResponseInterface $rawResponse)
    {
        $this->similarFaces = $similarFaces;
        $this->faceSetId    = $faceSetId;
        $this->imageBase64  = $imageBase64;
        $this->rawResponse  = $rawResponse;
    }

    /**
     * @return Face[]
     */
    public function getSimilarFaces(): array
    {
        return $this->similarFaces;
    }

    public function getFaceSetId(): string
    {
        return $this->faceSetId;
    }

    /**
     * @return string
     */
    public function getImageBase64(): string
    {
        return $this->imageBase64;
    }

    /**
     * @return ResponseInterface
     */
    public function getRawResponse(): ResponseInterface
    {
        return $this->rawResponse;
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
            'similar_faces' => $this->getSimilarFaces(),
            'face_set_id' => $this->getFaceSetId(),
            'image_base64' => $this->getImageBase64(),
            'raw_response' => \GuzzleHttp\json_encode($this->getRawResponse()),
        ];
    }
}