<?php


namespace Coolseven\FacePlatformSdk\Http\Responses;


use Psr\Http\Message\ResponseInterface;

class SearchSimilarFacesResponse implements \JsonSerializable
{
    /**
     * @var array
     */
    private $similarFaces;
    /**
     * @var ResponseInterface
     */
    private $rawResponse;

    public function __construct(array $similarFaces, ResponseInterface $rawResponse)
    {
        $this->similarFaces = $similarFaces;
        $this->rawResponse = $rawResponse;
    }

    /**
     * @return array
     */
    public function getSimilarFaces(): array
    {
        return $this->similarFaces;
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
            'raw_response' => [
                'status_code' => $this->getRawResponse()->getStatusCode(),
                'reason_phrase' => $this->getRawResponse()->getReasonPhrase(),
                'headers' => $this->getRawResponse()->getHeaders(),
                'body' => $this->getRawResponse()->getBody()->getContents(),
            ],
        ];
    }
}