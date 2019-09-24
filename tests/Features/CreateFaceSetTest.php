<?php


namespace Coolseven\FacePlatformSdk\Tests\Features;


use Coolseven\FacePlatformSdk\Tests\TestCase;
use Illuminate\Support\Str;

class CreateFaceSetTest extends TestCase
{
    /**
     * @test
     */
    public function create_face_set()
    {
        $facePlatformClient = $this->makeFacePlatformClient();

        $faceSetName = 'unit_testing_'.Str::random(12);

        $response = $facePlatformClient->createFaceSet($faceSetName);

        $this->assertEquals(201,$response->getRawResponse()->getStatusCode());
        $this->assertEquals($faceSetName,$response->getFaceSet()->getName());
    }
}