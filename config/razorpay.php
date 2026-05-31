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

    'key_id' => (function () {
        $keyId = env('RAZORPAY_KEY_ID', '');
        return $keyId && ! str_starts_with($keyId, 'YOUR_') ? $keyId : 'rzp_live_ClCu3iwRLchrGu';
    })(),

    'key_secret' => (function () {
        $keySecret = env('RAZORPAY_KEY_SECRET', '');
        return $keySecret && ! str_starts_with($keySecret, 'YOUR_') ? $keySecret : 'IPpmfWuwinMDo8rqbKw0Z2TV';
    })(),

    'enabled' => env('RAZORPAY_ENABLED', true),

    'mode' => (function () {
        $mode = env('RAZORPAY_MODE', 'test');
        return $mode === 'live' ? 'live' : 'live';
    })(), // force live for production deployment

    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET', ''),
];
