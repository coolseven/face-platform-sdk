# face-platform-sdk
Face Platform Api client for Laravel

## Requirement
- php >= 7.2
- laravel >= 6.0

## Installation
### Install package
```bash
composer require coolseven/face-platform-sdk
```

### Setup environments
- add following environments to your .env file
```dotenv
FACE_PLATFORM_OAUTH_SERVER=
FACE_PLATFORM_RESOURCE_SERVER=
FACE_PLATFORM_CLIENT_ID=
FACE_PLATFORM_CLIENT_SECRET=
FACE_PLATFORM_USERNAME=
FACE_PLATFORM_PASSWORD=

# the cache store should be one of the stores you defined in config/cache.php
# will use 'file' as cache store if not set
FACE_PLATFORM_CACHE_STORE=file
# the cache key to store your face platform access token, 
# will use 'cache:face-platform:access_token' as cache key if not set 
FACE_PLATFORM_CACHE_KEY=cache:face-platform:access_token
```

- publish config file
```bash
php artisan vendor:publish --tag=face-platform-sdk.config
```
the config file will be copied to your config dir with filename "face-platform-sdk.php"


## Manage Resources
- create a new face set
```php
$facePlatformClient = app(Coolseven\FacePlatformSdk\FacePlatformClient::class);
$faceSetName = 'your-demo-face-set';
$response = $facePlatformClient->createFaceSet($faceSetName);
$faceSetId = $response->getFaceSet()->getId();
$statusCode = $response->getRawResponse()->getStatusCode();
```

- import faces into a face set
```php
$facePlatformClient = app(Coolseven\FacePlatformSdk\FacePlatformClient::class);
$faceSetId = 'your-demo-face-set-id';
$imagePath = 'your_imgae_file_path';
$response = $facePlatformClient->importFaces($faceSetId, base64_encode(file_get_contents($imagePath)));
$importedFaces = $response->getImportedFaces();
```

- search similar faces in a face set
```php
$facePlatformClient = app(Coolseven\FacePlatformSdk\FacePlatformClient::class);
$faceSetId = 'your-demo-face-set-id';
$imagePath = 'your_imgae_file_path';
$similarityThreshold = 0.93;
$response = $facePlatformClient->searchSimilarFaces($faceSetId, base64_encode(file_get_contents($imagePath)), $similarityThreshold);
$similarFaces = $response->getSimilarFaces();
```

## Events
- a `Coolseven\FacePlatformSdk\Events\AccessTokenRefreshed` Event will be fired after access token been refreshed.
```php
$accessToken = $accessTokenRefreshedEvent->getRefreshedAccessToken();
```

- a `Coolseven\FacePlatformSdk\Events\FaceSetCreated` Event will be fired after a new face set been created.
```php
$faceSetId = $faceSetCreatedEvent->getFaceSet()->getId();
$rawResponse = $faceSetCreatedEvent->getRawResponse();
```

- a `Coolseven\FacePlatformSdk\Events\FacesImported` Event will be fired after new faces been imported
```php
$importedFaces = $facesImported->getImportedFaces();
$faceSetId = $facesImported->getFaceSetId();
$imageBase64 = $facesImported->getImageBase64();
$rawResponse = $faceSetCreatedEvent->getRawResponse();
```

- a `Coolseven\FacePlatformSdk\Events\SimilarFacesSearched` Event will be fired after similar faces been searched
```php
$similarFaces = $similarFacesSearchedEvent->getSimilarFaces();
$faceSetId = $similarFacesSearchedEvent->getFaceSetId();
$imageBase64 = $similarFacesSearchedEvent->getImageBase64();
$rawResponse = $similarFacesSearchedEvent->getRawResponse();
```
