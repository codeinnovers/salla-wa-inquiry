<?php

return [
    'openai_key' => env('OPENAI_API_KEY'),
    'elevenlabs_api_key' => env('ELEVENLABS_API_KEY', 'sk_85e83f662c270acf31a467c2ab3eaa236f761e75ee030024'),
    'salla_client_id' => env('SALLA_CLIENT_ID'),
    'salla_client_secret' => env('SALLA_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Subscription Plans & Monthly Voice Search Limits
    |--------------------------------------------------------------------------
    */
    'plans' => [
        'free' => [
            'name' => 'Free',
            'limit' => 100,
            'days' => 3,
        ],
        'basic' => [
            'name' => 'Basic',
            'limit' => 2000,
            'days' => 30,
        ],
        'pro' => [
            'name' => 'Pro',
            'limit' => 10000,
            'days' => 360,
        ],
    ],
];
