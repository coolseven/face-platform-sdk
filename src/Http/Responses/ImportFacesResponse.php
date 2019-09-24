<?php


namespace Coolseven\FacePlatformSdk\Http\Responses;


use Coolseven\FacePlatformSdk\Resources\Face;
use Psr\Http\Message\ResponseInterface;

class ImportFacesResponse implements \JsonSerializable
{
    /**
     * @var array|Face[]
     */
    private $importedFaces;
    /**
     * @var ResponseInterface
     */
    private $rawResponse;

    /**
     * ImportFacesResponse constructor.
     *
     * @param Face[]            $importedFaces
     * @param ResponseInterface $rawResponse
     */
    public function __construct(array $importedFaces, ResponseInterface $rawResponse)
    {
        $this->importedFaces = $importedFaces;
        $this->rawResponse = $rawResponse;
    }

    /**
     * @return Face[]
     */
    public function getImportedFaces(): array
    {
        return $this->importedFaces;
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
            'faces' => $this->getImportedFaces(),
            'raw_response' => $this->getRawResponse(),
        ];
    }
}