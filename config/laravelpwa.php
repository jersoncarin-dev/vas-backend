<?php

return [
    'name' => 'Pet\'s Life',
    'manifest' => [
        'name' => env('APP_NAME', 'Pet\'s Life'),
        'short_name' => 'Pet\'s Life',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/dist/img/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/dist/img/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/dist/img/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/dist/img/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/dist/img/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/dist/img/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/dist/img/icons/icon-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/dist/img/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/dist/img/icons/splash-640x1136.png',
            '750x1334' => '/dist/img/icons/splash-750x1334.png',
            '828x1792' => '/dist/img/icons/splash-828x1792.png',
            '1125x2436' => '/dist/img/icons/splash-1125x2436.png',
            '1242x2208' => '/dist/img/icons/splash-1242x2208.png',
            '1242x2688' => '/dist/img/icons/splash-1242x2688.png',
            '1536x2048' => '/dist/img/icons/splash-1536x2048.png',
            '1668x2224' => '/dist/img/icons/splash-1668x2224.png',
            '1668x2388' => '/dist/img/icons/splash-1668x2388.png',
            '2048x2732' => '/dist/img/icons/splash-2048x2732.png',
        ],
        'custom' => []
    ]
];
