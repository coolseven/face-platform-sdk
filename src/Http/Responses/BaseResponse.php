<?php


namespace Coolseven\FacePlatformSdk\Http\Responses;


use Psr\Http\Message\ResponseInterface;

class BaseResponse
{
    /**
     * @var ResponseInterface
     */
    private $rawResponse;

    public function __construct(ResponseInterface $rawResponse)
    {
        $this->rawResponse = $rawResponse;
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
     * @return array
     */
    protected function getRawResponseForJsonSerialization(): array
    {
        return [
            'status_code' => $this->rawResponse->getStatusCode(),
            'reason_phrase' => $this->rawResponse->getReasonPhrase(),
            'headers' => $this->rawResponse->getHeaders(),
            'body' => \GuzzleHttp\json_decode($this->getRawResponse()->getBody()->getContents(),true),
        ];
    }
}