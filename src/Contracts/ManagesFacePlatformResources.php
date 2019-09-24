<?php


namespace Coolseven\FacePlatformSdk\Contracts;


use Coolseven\FacePlatformSdk\Http\Responses\CreateFaceSetResponse;
use Coolseven\FacePlatformSdk\Http\Responses\ImportFacesResponse;
use Coolseven\FacePlatformSdk\Http\Responses\SearchSimilarFacesResponse;

interface ManagesFacePlatformResources
{
    /**
     * @param string $faceSetName
     *
     * @return mixed
     */
    public function createFaceSet(string $faceSetName) : CreateFaceSetResponse;

    public function importFaces(string $faceSetId, string $imageBase64) : ImportFacesResponse;

    public function searchSimilarFaces(string $faceSetId, string $imageBase64, float $similarityThreshold) : SearchSimilarFacesResponse;
}