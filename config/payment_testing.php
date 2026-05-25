<?php

/**
 * Payment Testing Configuration
 * 
 * This file contains comprehensive payment testing procedures for Razorpay integration
 * Used before production deployment to verify payment flows are working correctly
 */

return [
    // Test Environment
    'test_mode' => env('PAYMENT_TEST_MODE', true),
    'environment' => env('APP_ENV', 'testing'),

    // Razorpay Test Credentials
    'razorpay' => [
        'key_id' => env('RAZORPAY_TEST_KEY_ID', 'rzp_test_ClCu3iwRLchrGu'),
        'key_secret' => env('RAZORPAY_TEST_KEY_SECRET', 'IPpmfWuwinMDo8rqbKw0Z2TV'),
    ],

    // Test Cards for Different Scenarios
    'test_cards' => [
        'success' => [
            'number' => '4111111111111111',
            'expiry' => '12/25',
            'cvv' => '123',
            'name' => 'Test User',
            'description' => 'Standard card - payment will be successful',
        ],
        'failed_generic' => [
            'number' => '4000000000000002',
            'expiry' => '12/25',
            'cvv' => '123',
            'name' => 'Test User',
            'description' => 'Generic error - payment will fail',
        ],
        'failed_insufficient_funds' => [
            'number' => '4000000000000069',
            'expiry' => '12/25',
            'cvv' => '123',
            'description' => 'Insufficient funds - declined',
        ],
        'failed_lost_card' => [
            'number' => '4000000000000036',
            'expiry' => '12/25',
            'cvv' => '123',
            'description' => 'Lost card - declined',
        ],
        'failed_stolen_card' => [
            'number' => '4000000000000044',
            'expiry' => '12/25',
            'cvv' => '123',
            'description' => 'Stolen card - declined',
        ],
    ],

    // Test Amounts
    'test_amounts' => [
        'small' => 10,      // ₹10
        'medium' => 100,    // ₹100
        'large' => 1000,    // ₹1000
    ],

    // Webhook Testing
    'webhooks' => [
        'test_url' => env('PAYMENT_WEBHOOK_URL', 'https://yourdomain.com/webhook/razorpay'),
        'secret_key' => env('RAZORPAY_WEBHOOK_SECRET', 'your_webhook_secret'),
        'events' => [
            'payment.authorized',
            'payment.failed',
            'payment.captured',
            'payment.completed',
            'order.paid',
            'refund.created',
        ],
    ],

    // Test Scenarios
    'test_scenarios' => [
        [
            'name' => 'Successful Payment Flow',
            'description' => 'User creates order, pays with test card, payment succeeds',
            'steps' => [
                'Create order with amount ₹100',
                'Open Razorpay checkout',
                'Use test card: 4111111111111111',
                'Verify signature on backend',
                'Check wallet credit',
            ],
            'expected_result' => 'Order marked as completed, wallet credited',
        ],
        [
            'name' => 'Failed Payment',
            'description' => 'User attempts payment with failing card',
            'steps' => [
                'Create order with amount ₹100',
                'Open Razorpay checkout',
                'Use test card: 4000000000000002',
                'Payment fails in Razorpay',
                'User shown error message',
            ],
            'expected_result' => 'Order remains pending, wallet not credited, user notified',
        ],
        [
            'name' => 'Invalid Signature',
            'description' => 'Verify signature verification prevents fraud',
            'steps' => [
                'Intercept payment response',
                'Modify payment amount',
                'Send modified response',
                'Backend validates signature',
            ],
            'expected_result' => 'Invalid signature error, payment rejected',
        ],
        [
            'name' => 'Webhook Delivery',
            'description' => 'Webhook endpoint correctly processes payment notifications',
            'steps' => [
                'Complete payment',
                'Wait for webhook delivery',
                'Verify order status updated',
                'Verify wallet transaction logged',
            ],
            'expected_result' => 'All webhooks processed, no duplicate transactions',
        ],
        [
            'name' => 'Refund Processing',
            'description' => 'User requests refund and funds are returned to wallet',
            'steps' => [
                'Complete a payment',
                'Request order cancellation',
                'Verify refund is initiated',
                'Check wallet receives refund',
                'Verify transaction logged',
            ],
            'expected_result' => 'Refund completed, wallet updated, transaction logged',
        ],
        [
            'name' => 'P2P Transfer',
            'description' => 'User transfers money to another user',
            'steps' => [
                'Load wallet with ₹1000',
                'Send ₹100 to another user',
                'Verify sender wallet decreased',
                'Verify receiver wallet increased',
                'Check transaction logged for both users',
            ],
            'expected_result' => 'Transfer completed atomically, both wallets updated',
        ],
        [
            'name' => 'Referral Bonus Credit',
            'description' => 'User shares referral code and bonus is credited',
            'steps' => [
                'Get referral code',
                'Share with another user',
                'New user registers with code',
                'Both users get bonus',
                'Check wallet transactions',
            ],
            'expected_result' => 'Both users credited, transactions logged',
        ],
    ],

    // Pre-Launch Checklist
    'launch_checklist' => [
        'payment_gateway' => [
            'Razorpay API credentials configured',
            'Live keys set in production .env',
            'Webhook endpoint configured in Razorpay dashboard',
            'Webhook secret stored securely',
            'Payment gateway is reachable',
        ],
        'security' => [
            'HMAC-SHA256 signature verification enabled',
            'All payment responses validated',
            'HTTPS enabled on all payment pages',
            'Rate limiting configured',
            'SQL injection prevention verified',
        ],
        'database' => [
            'All migrations executed successfully',
            'Database indices created for performance',
            'Backup strategy implemented',
            'Rollback procedures documented',
        ],
        'api' => [
            'All 76 endpoints tested',
            'Error handling works correctly',
            'Response formats validated',
            'Authentication tokens working',
            'Rate limiting functional',
        ],
        'frontend' => [
            'Login/Register working',
            'Product listing functional',
            'Cart operations working',
            'Checkout flow complete',
            'Payment completion page displays',
            'Order tracking working',
            'Wallet management functional',
        ],
        'monitoring' => [
            'Error logging configured',
            'Payment success/failure tracked',
            'Database backup automated',
            'Uptime monitoring enabled',
            'Alert system configured',
        ],
        'load_testing' => [
            'Tested with 100 concurrent users',
            'Tested with 1000 concurrent users',
            'Response time < 100ms at 100 concurrent',
            'No errors at 1000 concurrent load',
            'Database handles load correctly',
        ],
        'documentation' => [
            'API documentation complete',
            'Payment flow documented',
            'Troubleshooting guide created',
            'Support procedures documented',
            'Runbook for common issues',
        ],
        'team_readiness' => [
            'Support team trained',
            'Escalation procedures defined',
            'On-call rotation established',
            'Communication channels setup',
            'Issue tracking system configured',
        ],
    ],

    // Common Issues & Solutions
    'troubleshooting' => [
        [
            'issue' => 'Payment signature verification fails',
            'causes' => [
                'Incorrect webhook secret',
                'Modified payment data',
                'Clock skew between servers',
                'Wrong key being used',
            ],
            'solutions' => [
                'Verify webhook secret in Razorpay dashboard',
                'Ensure NTP is synced on server',
                'Check key_secret is correct in .env',
                'Enable signature logging in debug mode',
            ],
        ],
        [
            'issue' => 'Wallet not credited after payment',
            'causes' => [
                'Webhook not being delivered',
                'Webhook processing failed',
                'Database transaction rolled back',
                'Race condition in concurrent requests',
            ],
            'solutions' => [
                'Check webhook delivery in Razorpay dashboard',
                'Review server error logs',
                'Check database transaction logs',
                'Implement retry mechanism for webhook',
            ],
        ],
        [
            'issue' => 'Search functionality returns no results',
            'causes' => [
                'Full-text indexes not created',
                'Products not seeded',
                'Search query format incorrect',
                'MATCH/AGAINST not working',
            ],
            'solutions' => [
                'Run: php artisan migrate:fresh --seed',
                'Verify FULLTEXT indexes: SHOW INDEX FROM products',
                'Test with simple queries first',
                'Check MySQL version (5.7+ required)',
            ],
        ],
        [
            'issue' => 'API returns 401 Unauthorized',
            'causes' => [
                'Token expired',
                'Token not passed in header',
                'Invalid token format',
                'User logged out',
            ],
            'solutions' => [
                'Refresh token: POST /api/v1/auth/refresh',
                'Check Authorization header format',
                'Verify token format: "Bearer TOKEN"',
                'Re-login user',
            ],
        ],
    ],
];
