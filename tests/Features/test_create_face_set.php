<?php


namespace Tests\Features;


use Illuminate\Support\Str;
use Tests\TestCase;

class test_create_face_set extends TestCase
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