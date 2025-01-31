<?php
return [
    'defaults'  => [
        'guard'     => env('AUTH_GUARD', 'api'),
        'passwords' => 'users',
    ],
    'guards'    => [
        'api' => [
            'driver'   => 'jwt',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => \App\Models\User::class,
        ]
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'email'    => 'auth.emails.password',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],
    ],
];
