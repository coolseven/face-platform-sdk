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
add following environments to your .env file
```dotenv
FACE_PLATFORM_OAUTH_SERVER=
FACE_PLATFORM_RESOURCE_SERVER=
FACE_PLATFORM_CLIENT_ID=
FACE_PLATFORM_CLIENT_SECRET=
FACE_PLATFORM_USERNAME=
FACE_PLATFORM_PASSWORD=

# the cache store should be one of the stores you defined in config/cache.php
FACE_PLATFORM_CACHE_STORE=
FACE_PLATFORM_CACHE_KEY=
```
Or you can setup environments directly by config file
```bash
php artisan vendor:publish --tag=face-platform-sdk
```
the config file will be copied to your config dir with filename "face-platform.php"


## Usage
```php
// Laravel Example

$facePlatformClient = app(Coolseven\FacePlatformSdk\FacePlatformClient::class);

$faceSetName = 'your-demo-face-set';

$response = $facePlatformClient->createFaceSet($faceSetName);

$faceSetId = $response->getFaceSet()->getId();

$statusCode = $response->getRawResponse()->getStatusCode();
```
