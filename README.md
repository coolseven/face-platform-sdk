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
FACE_PLATFORM_OAUTH_SERVER=http://face-platform.localhost
FACE_PLATFORM_RESOURCE_SERVER=http://face-platform.localhost
FACE_PLATFORM_CLIENT_ID=1
FACE_PLATFORM_CLIENT_SECRET=4nr8rS6XY5ExjGFzkbtsTc2YWXsn1fCx3zpGAhg5
FACE_PLATFORM_USERNAME=wilfrid69@example.net
FACE_PLATFORM_PASSWORD=password

# the cache store should be one of the stores you defined in config/cache.php
FACE_PLATFORM_CACHE_STORE=file
FACE_PLATFORM_CACHE_KEY=cache:face-platform:access_token
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