<?php


namespace Coolseven\FacePlatformSdk\Tests\Unit;


use Coolseven\FacePlatformSdk\Http\Responses\CreateFaceSetResponse;
use Coolseven\FacePlatformSdk\Resources\FaceSet;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;

class CreateFaceSetResponseTest extends TestCase
{
    /**
     * @test
     */
    public function response_can_be_json_encoded_more_than_once(): void
    {
        $createFaceSetResponse = new CreateFaceSetResponse(
            new FaceSet('123','name-example'),
            new Response(
                200,
                [],
                json_encode(['id' => '123', 'name' => 'name-example'])
            )
        );

        $this->assertEquals(
            json_encode($createFaceSetResponse),
            json_encode($createFaceSetResponse)
        );
    }
}