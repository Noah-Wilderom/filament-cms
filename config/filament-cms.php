<?php

return [
    'cms' => [

        'path' => 'cms',
        ''
    ],

    'site' => [
        'title' => env("APP_NAME", "Filament CMS"),
        'email' => 'dev@example.com'
    ],

    'user' => [
        'model' => \App\Models\User::class,
        'verified' => true,
    ],

    'post' => [
        'enabled' => true,
        'model' => \NoahWilderom\FilamentCMS\Models\Post::class,
        'id' => 'uuid', // uuid, ulid, id or string
        'route' => [
            'prefix' => 'post',
            'param' => 'slug',
            'self_healing_url' => false,
            'handler' => '',
            'middleware' => [
               //
            ],
        ]
    ],

    'field' => [
        'model' => \NoahWilderom\FilamentCMS\Models\Field::class,
        'id' => 'uuid', // uuid, ulid, id or string
        'resources' => [
            \NoahWilderom\FilamentCMS\Models\Post::class,
            // \App\Models\User::class
        ]
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