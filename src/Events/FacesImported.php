<?php


namespace Coolseven\FacePlatformSdk\Events;

use Coolseven\FacePlatformSdk\Resources\Face;
use Psr\Http\Message\ResponseInterface;

class FacesImported implements \JsonSerializable
{
    /**
     * @var Face[]
     */
    private $importedFaces;
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

    public function __construct(array $importedFaces,string $faceSetId, string $imageBase64, ResponseInterface $rawResponse)
    {
        $this->importedFaces = $importedFaces;
        $this->faceSetId = $faceSetId;
        $this->imageBase64 = $imageBase64;
        $this->rawResponse   = $rawResponse;
    }

    /**
     * @return Face[]
     */
    public function getImportedFaces(): array
    {
        return $this->importedFaces;
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
        $this->rawResponse->getBody()->rewind();

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
            'faces' => $this->getImportedFaces(),
            'face_set_id' => $this->getFaceSetId(),
            'image_base64' => $this->getImageBase64(),
            'raw_response' => [
                'status_code' => $this->getRawResponse()->getStatusCode(),
                'reason_phrase' => $this->getRawResponse()->getReasonPhrase(),
                'headers' => $this->getRawResponse()->getHeaders(),
                'body' => \GuzzleHttp\json_decode($this->getRawResponse()->getBody()->getContents(),true),
            ],
        ];
    }
}