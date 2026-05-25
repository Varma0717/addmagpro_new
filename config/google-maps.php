<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps Configuration
    |--------------------------------------------------------------------------
    |
    | Google Maps API key and settings for location services
    |
    */

    'api_key' => env('GOOGLE_MAPS_API_KEY', ''),

    'enabled' => env('GOOGLE_MAPS_ENABLED', true),

    'client_id' => env('GOOGLE_MAPS_CLIENT_ID', ''),

    'client_secret' => env('GOOGLE_MAPS_CLIENT_SECRET', ''),

    // Default location for fallback
    'default_location' => [
        'latitude' => 17.3850,  // Hyderabad
        'longitude' => 78.4867,
    ],
];
