<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Razorpay Configuration
    |--------------------------------------------------------------------------
    |
    | Razorpay API credentials for payment processing
    |
    */

    'key_id' => env('RAZORPAY_KEY_ID', ''),

    'key_secret' => env('RAZORPAY_KEY_SECRET', ''),

    'enabled' => env('RAZORPAY_ENABLED', true),

    'mode' => env('RAZORPAY_MODE', 'test'), // 'test' or 'live'

    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET', ''),
];
