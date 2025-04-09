<?php

return [
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'sanctum' => [
            'driver' => 'sanctum',
            'provider' => null,
        ],
        'package_guard' => [
            'driver' => 'session',
            'provider' => 'package_users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \Mudtec\Ezimeeting\Models\User::class,
        ],
    ],
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    'password_timeout' => 10800,
];
return [
    

    'providers' => [
        'package_users' => [
            'driver' => 'eloquent',
            'model' => \Mudtec\Ezimeeting\Models\User::class,
        ],
    ],
];