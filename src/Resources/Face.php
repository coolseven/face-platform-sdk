<?php


namespace Coolseven\FacePlatformSdk\Resources;


class Face implements \JsonSerializable
{
    /**
     * @var string
     */
    private $faceId;

    public function __construct(string $faceId)
    {
        $this->faceId = $faceId;
    }

    /**
     * @return string
     */
    public function getFaceId(): string
    {
        return $this->faceId;
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
            'id' => $this->getFaceId(),
        ];
    }
}