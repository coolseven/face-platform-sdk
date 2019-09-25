<?php


namespace Coolseven\FacePlatformSdk;


use Carbon\Carbon;
use Coolseven\FacePlatformSdk\Auth\AuthConfig;
use Coolseven\FacePlatformSdk\Contracts\Authorize;
use Coolseven\FacePlatformSdk\Contracts\ManagesFacePlatformResources;
use Coolseven\FacePlatformSdk\Contracts\StoresAccessToken;
use Coolseven\FacePlatformSdk\Events\AccessTokenRefreshed;
use Coolseven\FacePlatformSdk\Events\FaceSetCreated;
use Coolseven\FacePlatformSdk\Events\FacesImported;
use Coolseven\FacePlatformSdk\Auth\AccessToken;
use Coolseven\FacePlatformSdk\Events\SimilarFacesSearched;
use Coolseven\FacePlatformSdk\Http\calcUrisForRequests;
use Coolseven\FacePlatformSdk\Http\Responses\CreateFaceSetResponse;
use Coolseven\FacePlatformSdk\Http\Responses\ImportFacesResponse;
use Coolseven\FacePlatformSdk\Http\Responses\SearchSimilarFacesResponse;
use Coolseven\FacePlatformSdk\Resources\Face;
use Coolseven\FacePlatformSdk\Resources\FaceSet;
use Coolseven\FacePlatformSdk\Resources\SimilarFace;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Event;

class FacePlatformClient implements ManagesFacePlatformResources, Authorize
{
    use calcUrisForRequests;

    /**
     * @var AuthConfig
     */
    private $authConfig;

    /**
     * @var StoresAccessToken
     */
    private $accessTokenStorage;
    /**
     * @var GuzzleClient
     */
    private $guzzleClient;


    public function __construct(AuthConfig $authConfig, StoresAccessToken $accessTokenStorage)
    {
        $this->authConfig = $authConfig;

        $this->accessTokenStorage = $accessTokenStorage;

        $this->guzzleClient = new GuzzleClient();
    }

    public function getValidAccessToken(): AccessToken
    {
        $accessToken = $this->accessTokenStorage->getAccessToken();

        if ($accessToken === null || $accessToken->needsRefresh()) {
            return $this->refreshAccessToken();
        }

        return $accessToken;
    }

    public function refreshAccessToken(): AccessToken
    {
        return tap($this->accessTokenStorage->saveAccessToken(
            $this->getAccessToken()
        ),function(string $refreshedToken){
            Event::dispatch(new AccessTokenRefreshed($refreshedToken));
        });
    }

    /**
     * @return AccessToken
     */
    private function getAccessToken(): AccessToken
    {
        $response = $this->guzzleClient->post($this->getUriForAccessToken(), [
            'headers'     => [
                'Accept' => 'application/json',
            ],
            'form_params' => [
                'grant_type'    => 'password',
                'client_id'     => $this->authConfig->getClientId(),
                'client_secret' => $this->authConfig->getClientSecret(),
                'username'      => $this->authConfig->getUsername(),
                'password'      => $this->authConfig->getPassword(),
                'scope'         => '*',
            ],
        ]);

        /**
         * $body:
         * <pre>
         * {
         *    "token_type": "Bearer",
         *    "expires_in": 31622400,
         *    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJ....",
         *    "refresh_token": "ckINjKiOjLphYkIdF..."
         * }
         * </pre>
         */
        $body = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return new AccessToken(
            $body['access_token'],
            Carbon::now()->addSeconds($body['expires_in'])
        );
    }

    /**
     * @param string $faceSetName
     *
     * @return mixed
     */
    public function createFaceSet(string $faceSetName): CreateFaceSetResponse
    {
        $accessToken = $this->getValidAccessToken();

        $rawResponse = $this->guzzleClient->post($this->getUriForFaceSets(), [
            'headers'     => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'form_params' => [
                'name' => $faceSetName,
            ],
        ]);

        /**
         * $body
         * <pre>
         * {
         *   "data": {
         *      "id": "8eba99c1-f8b2-4b16-a46b-2c5eab3d1bc1",
         *      "name": "name-example"
         *   }
         * }
         * </pre>
         */
        $body = tap(\GuzzleHttp\json_decode($rawResponse->getBody()->getContents(), true),function()use($rawResponse){
            $rawResponse->getBody()->rewind();
        });

        $faceSet = new FaceSet($body['data']['id'], $body['data']['name']);

        $createFaceSetResponse = new CreateFaceSetResponse($faceSet, $rawResponse);

        return tap($createFaceSetResponse, function () use ($faceSet,$rawResponse) {
            Event::dispatch(new FaceSetCreated($faceSet, $rawResponse));
        });
    }

    public function importFaces(string $faceSetId, string $imageBase64): ImportFacesResponse
    {
        $accessToken = $this->getValidAccessToken();

        $rawResponse = $this->guzzleClient->post($this->getUriForFaces($faceSetId), [
            'headers'     => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'form_params' => [
                'image_base64' => $imageBase64,
            ],
        ]);

        /**
         * $body
         * <pre>
         * {
         *   "data": [
         *      {"id": "8eba99c1-1234-4b16-a46b-2c5eab3d1bc1"},
         *      {"id": "8eba99c1-4567-4asc-a578-232333222454"},
         *   ]
         * }
         * </pre>
         */
        $body = tap(\GuzzleHttp\json_decode($rawResponse->getBody()->getContents(), true),function()use($rawResponse){
            $rawResponse->getBody()->rewind();
        });

        $importedFaces = [];
        foreach ($body['data'] as $face) {
            $importedFaces[] = new Face($face['id']);
        }

        $importFacesResponse = new ImportFacesResponse($importedFaces, $rawResponse);

        return tap($importFacesResponse, function () use ($importedFaces,$faceSetId,$imageBase64,$rawResponse) {
            Event::dispatch(new FacesImported($importedFaces,$faceSetId,$imageBase64,$rawResponse));
        });
    }

    public function searchSimilarFaces(string $faceSetId, string $imageBase64, float $similarityThreshold): SearchSimilarFacesResponse
    {
        $accessToken = $this->getValidAccessToken();

        $rawResponse = $this->guzzleClient->post($this->getUriForFaceSearches($faceSetId), [
            'headers'     => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'form_params' => [
                'image_base64' => $imageBase64,
                'similarity_threshold' => $similarityThreshold,
            ],
        ]);

        /**
         * $body
         * <pre>
         * {
         *   "data": [
         *      {"id": "8eba99c1-1234-4b16-a46b-2c5eab3d1bc1" , "similarity" : 0.96},
         *      {"id": "8eba99c1-4567-4asc-a578-232333222454" , "similarity" : 0.85},
         *   ]
         * }
         * </pre>
         */
        $body = tap(\GuzzleHttp\json_decode($rawResponse->getBody()->getContents(), true),function()use($rawResponse){
            $rawResponse->getBody()->rewind();
        });

        $similarFaces = [];
        foreach ($body['data'] as $face) {
            $similarFaces[] = new SimilarFace($face['id'],$face['similarity']);
        }

        $searchSimilarFacesResponse = new SearchSimilarFacesResponse($similarFaces, $rawResponse);

        return tap($searchSimilarFacesResponse, function () use ($similarFaces,$faceSetId,$imageBase64,$rawResponse) {
            Event::dispatch(new SimilarFacesSearched($similarFaces,$faceSetId,$imageBase64,$rawResponse));
        });
    }
}