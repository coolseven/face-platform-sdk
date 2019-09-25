<?php


namespace Coolseven\FacePlatformSdk\Tests\Features;


use Coolseven\FacePlatformSdk\Tests\CreateNewFacePlatformClient;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;

class CreateFaceSetTest extends TestCase
{
    use CreateNewFacePlatformClient;

    /**
     * @test
     */
    public function create_face_set(): void
    {
        $facePlatformClient = $this->makeFacePlatformClient();

        $faceSetName = 'unit_testing_'.Str::random(12);

        $response = $facePlatformClient->createFaceSet($faceSetName);

        $this->assertEquals(201,$response->getRawResponse()->getStatusCode());
        $this->assertEquals($faceSetName,$response->getFaceSet()->getName());
    }
}