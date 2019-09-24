<?php


namespace Coolseven\FacePlatformSdk\Resources;


class SimilarFace implements \JsonSerializable
{
    /**
     * @var string
     */
    private $faceId;
    /**
     * @var float
     */
    private $similarity;

    public function __construct(string $faceId, float $similarity)
    {
        $this->faceId     = $faceId;
        $this->similarity = $similarity;
    }

    /**
     * @return string
     */
    public function getFaceId(): string
    {
        return $this->faceId;
    }

    /**
     * @return float
     */
    public function getSimilarity(): float
    {
        return $this->similarity;
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
            'face_id' => $this->getFaceId(),
            'similarity' => $this->getSimilarity(),
        ];
    }
}