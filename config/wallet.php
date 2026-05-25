<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Wallet Configuration
    |--------------------------------------------------------------------------
    |
    | Wallet service settings for balance management
    |
    */

    'min_topup' => env('WALLET_MIN_TOPUP', 100),

    'max_topup' => env('WALLET_MAX_TOPUP', 100000),

    'topup_fee_percent' => env('WALLET_TOPUP_FEE', 2.36), // Razorpay fee + GST

    'transfer_fee_percent' => env('WALLET_TRANSFER_FEE', 0),

    'referral_bonus' => env('WALLET_REFERRAL_BONUS', 500), // In paisa (₹5.00)

    'referred_bonus' => env('WALLET_REFERRED_BONUS', 300), // In paisa (₹3.00)

    'enabled' => env('WALLET_ENABLED', true),
];
