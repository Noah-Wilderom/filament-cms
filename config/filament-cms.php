<?php

return [
    'site' => [
        'title' => env("APP_NAME", "Filament CMS"),
        'email' => 'dev@example.com'
    ],

    'user' => [
        'model' => \App\Models\User::class,
    ],

    'post' => [
        'model' => \NoahWilderom\FilamentCMS\Models\Post::class,
        'id' => 'uuid' // uuid, ulid, id or string
    ],

    'field' => [
        'model' => \NoahWilderom\FilamentCMS\Models\Field::class,
        'id' => 'uuid' // uuid, ulid, id or string
    ],

    'routes' => [
        'api' => [
            'prefix' => '',
            'middleware' => [
                'throttle:api'
            ]
        ],
        'web' => [
            'prefix' => '',
            'middleware' => [
                //
            ]
        ]
    ],

    'events' => [
        'listen' => [
            //
        ]
    ]
];