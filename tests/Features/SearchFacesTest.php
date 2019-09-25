<?php


namespace Coolseven\FacePlatformSdk\Tests\Features;


use Coolseven\FacePlatformSdk\Tests\CreateNewFacePlatformClient;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;

class SearchFacesTest extends TestCase
{
    use CreateNewFacePlatformClient;

    /**
     * @var \Coolseven\FacePlatformSdk\FacePlatformClient
     */
    private $facePlatformClient;
    /**
     * @var string
     */
    private $faceSetName;
    /**
     * @var string
     */
    private $faceSetId;

    public function setUp() :void
    {
        parent::setUp();

        $this->create_face_set();

        $this->import_faces_by_image_base64();
    }

    private function create_face_set(): void
    {
        $this->facePlatformClient = $this->makeFacePlatformClient();

        $this->faceSetName = 'unit_testing_'.Str::random(12);

        $this->faceSetId = $this->facePlatformClient->createFaceSet($this->faceSetName)->getFaceSet()->getId();
    }

    private function import_faces_by_image_base64() :void
    {
        $image = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'images/donald_trump.jpeg';

        $imageBase64 = base64_encode(file_get_contents($image));

        $this->facePlatformClient->importFaces($this->faceSetId,$imageBase64);
    }

    /**
     * @test
     */
    public function search_similar_faces_by_image_base64(): void
    {
        $image = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'images/donald_trump.jpeg';

        $imageBase64 = base64_encode(file_get_contents($image));

        $response = $this->facePlatformClient->searchSimilarFaces($this->faceSetId,$imageBase64,0.93);

        $this->assertEquals(200,$response->getRawResponse()->getStatusCode());
        $this->assertGreaterThanOrEqual(0,count($response->getSimilarFaces()));
    }
}