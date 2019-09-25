<?php


namespace Coolseven\FacePlatformSdk\Http\Responses;


use Coolseven\FacePlatformSdk\Resources\SimilarFace;
use Psr\Http\Message\ResponseInterface;

class SearchSimilarFacesResponse extends BaseResponse implements \JsonSerializable
{
    /**
     * @var SimilarFace[]
     */
    private $similarFaces;

    /**
     * SearchSimilarFacesResponse constructor.
     *
     * @param SimilarFace[]     $similarFaces
     * @param ResponseInterface $rawResponse
     */
    public function __construct(array $similarFaces, ResponseInterface $rawResponse)
    {
        parent::__construct($rawResponse);

        $this->similarFaces = $similarFaces;
    }

    /**
     * @return array
     */
    public function getSimilarFaces(): array
    {
        return $this->similarFaces;
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
            'raw_response' => $this->getRawResponseForJsonSerialization(),
        ];
    }
}