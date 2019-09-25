<?php

return [
    'oauth_server' => env('FACE_PLATFORM_OAUTH_SERVER'),
    'resource_server' => env('FACE_PLATFORM_RESOURCE_SERVER'),
    'client_id' => env('FACE_PLATFORM_CLIENT_ID'),
    'client_secret' => env('FACE_PLATFORM_CLIENT_SECRET'),
    'username' => env('FACE_PLATFORM_USERNAME'),
    'password' => env('FACE_PLATFORM_PASSWORD'),

    'access_token_cache' => [
        'store' => env('FACE_PLATFORM_CACHE_STORE','file') ,
        'key' => env('FACE_PLATFORM_CACHE_KEY','cache:face-platform:access_token'),
    ],
];