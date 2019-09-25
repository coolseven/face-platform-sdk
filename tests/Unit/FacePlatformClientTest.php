<?php


namespace Coolseven\FacePlatformSdk\Tests\Unit;


use Coolseven\FacePlatformSdk\FacePlatformClient;
use Coolseven\FacePlatformSdk\Tests\CreateNewFacePlatformClient;
use Orchestra\Testbench\TestCase;

class FacePlatformClientTest extends TestCase
{
    use CreateNewFacePlatformClient;

    /**
     * @test
     */
    public function access_token_should_be_cached(): void
    {
        $client = $this->makeFacePlatformClient();

        $this->assertEquals(
            $client->getValidAccessToken()->getAccessToken(),
            $client->getValidAccessToken()->getAccessToken()
        );
    }

    /**
     * @test
     */
    public function access_token_can_be_refreshed(): void
    {
        $client = $this->makeFacePlatformClient();

        $this->assertNotEquals(
            $client->getValidAccessToken()->getAccessToken(),
            $client->refreshAccessToken()->getAccessToken()
        );
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function client_should_use_correct_uri_for_access_token(): void
    {
        $client = $this->makeFacePlatformClient();

        $getUriForAccessTokenMethod = new \ReflectionMethod(FacePlatformClient::class,'getUriForAccessToken');
        $getUriForAccessTokenMethod->setAccessible(true);
        $this->assertEquals(
            getenv('FACE_PLATFORM_OAUTH_SERVER').'/oauth/token',
            $getUriForAccessTokenMethod->invoke($client)
        );
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function client_should_use_correct_uri_for_face_sets(): void
    {
        $client = $this->makeFacePlatformClient();

        $getUriForFaceSetsMethod = new \ReflectionMethod(FacePlatformClient::class,'getUriForFaceSets');
        $getUriForFaceSetsMethod->setAccessible(true);

        $this->assertEquals(
            getenv('FACE_PLATFORM_RESOURCE_SERVER').'/api/v1/face-sets',
            $getUriForFaceSetsMethod->invoke($client)
        );
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function client_should_use_correct_uri_for_faces(): void
    {
        $client = $this->makeFacePlatformClient();

        $getUriForFacesMethod = new \ReflectionMethod(FacePlatformClient::class,'getUriForFaces');
        $getUriForFacesMethod->setAccessible(true);

        $faceSetId = '12345';
        $this->assertEquals(
            getenv('FACE_PLATFORM_RESOURCE_SERVER').'/api/v1/face-sets/'.$faceSetId.'/faces',
            $getUriForFacesMethod->invokeArgs($client,[$faceSetId])
        );
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function client_should_use_correct_uri_for_face_searches(): void
    {
        $client = $this->makeFacePlatformClient();

        $getUriForFaceSearchesMethod = new \ReflectionMethod(FacePlatformClient::class,'getUriForFaceSearches');
        $getUriForFaceSearchesMethod->setAccessible(true);

        $faceSetId = '12345';

        $this->assertEquals(
            getenv('FACE_PLATFORM_RESOURCE_SERVER').'/api/v1/face-sets/'.$faceSetId.'/face-searches',
            $getUriForFaceSearchesMethod->invokeArgs($client,[$faceSetId])
        );
    }
}