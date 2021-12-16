<?php
return [
    'mysql' => [
        'host' => env('DB_HOST', '182.92.57.225'),
        'database' => env('DB_DATABASE', 'novel'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', '123456'),
    ],

    'redis' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', '6379'),
        'password' => env('REDIS_PASSWORD', 'root'),
    ]
];