<?php


namespace Coolseven\FacePlatformSdk\Http\Responses;


use Coolseven\FacePlatformSdk\Resources\FaceSet;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class CreateFaceSetResponse implements \JsonSerializable
{
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
     * @return FaceSet
     */
    public function getFaceSet(): FaceSet
    {
        return $this->faceSet;
    }

    /**
     * @return Response
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
            'faceSet' => $this->getFaceSet(),
            'rawResponse' => \GuzzleHttp\json_encode($this->getRawResponse()),
        ];
    }
}