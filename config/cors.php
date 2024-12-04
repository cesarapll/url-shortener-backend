<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Allowed origins, headers, methods, and more.
    |
    */

    'defaults' => [
        'supports_credentials' => false,
        'allowed_origins' => ['http://localhost:5173'],
        'allowed_headers' => ['*'],
        'allowed_methods' => ['*'],
        'exposed_headers' => [],
        'max_age' => 0,
        'hosts' => [],
    ],

    'paths' => [
        'api/*', // This will apply CORS to your API routes
    ],
];