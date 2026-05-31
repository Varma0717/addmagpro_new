# Payment Integration Testing & Live Deployment Guide

## Payment Integration Testing (Razorpay)

### Current Status ✅
- **Razorpay Account**: Live (production keys configured)
- **RAZORPAY_KEY_ID**: rzp_live_ClCu3iwRLchrGu
- **RAZORPAY_KEY_SECRET**: IPpmfWuwinMDo8rqbKw0Z2TV
- **Mode**: LIVE (Production)

---

## Testing Checklist

### 1. Environment Verification
```bash
# Check .env file
cat .env | grep RAZORPAY

# Should show:
# RAZORPAY_KEY_ID=rzp_live_ClCu3iwRLchrGu
# RAZORPAY_KEY_SECRET=IPpmfWuwinMDo8rqbKw0Z2TV
# RAZORPAY_MODE=live
```

### 2. Test API Connection
```bash
php artisan tinker

# Test Razorpay API connectivity
>>> $razorpay = app('Razorpay\Api\Api');
>>> $razorpay->utility->verifyPaymentSignature(['razorpay_order_id' => 'test', 'razorpay_payment_id' => 'test', 'razorpay_signature' => 'test']);
// Should throw signature error (expected)
```

### 3. Wallet Topup Flow Testing

#### Step 1: Create Topup Order (Backend)
```bash
curl -X POST http://localhost/admagpro/api/v1/account/wallet/topup/create \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 500,
    "payment_method": "razorpay"
  }'

# Response:
{
  "success": true,
  "data": {
    "order_id": "order_ABC123XYZ789",
    "amount": 500,
    "currency": "INR",
    "razorpay_key": "rzp_live_ClCu3iwRLchrGu",
    "customer_name": "John Doe",
    "customer_email": "john@example.com",
    "customer_phone": "9876543210",
    "transaction_id": "uuid-1234-5678"
  }
}
```

#### Step 2: Show Razorpay Checkout (Frontend)
```javascript
// In Flutter / Web
const options = {
    "key": response.data.razorpay_key,
    "amount": response.data.amount * 100, // Convert to paise
    "currency": "INR",
    "name": "AddMagPro",
    "description": "Wallet Topup",
    "order_id": response.data.order_id,
    "customer_details": {
        "name": response.data.customer_name,
        "email": response.data.customer_email,
        "contact": response.data.customer_phone
    },
    "handler": function(paymentResponse) {
        // Verify payment with backend
        verifyPayment(paymentResponse);
    },
    "prefill": {
        "name": response.data.customer_name,
        "email": response.data.customer_email,
        "contact": response.data.customer_phone
    }
};

// Open Razorpay Checkout
new Razorpay(options).open();
```

#### Step 3: Verify Payment Signature (Backend)
```bash
curl -X POST http://localhost/admagpro/api/v1/account/wallet/topup/verify \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "razorpay_order_id": "order_ABC123XYZ789",
    "razorpay_payment_id": "pay_ABC123XYZ789",
    "razorpay_signature": "signature_hash_from_razorpay"
  }'

# Response:
{
  "success": true,
  "data": {
    "transaction_id": "uuid-1234-5678",
    "amount_credited": 500,
    "new_balance": 1500,
    "message": "Wallet topup successful"
  }
}
```

---

## Test Scenarios

### Scenario 1: Successful Topup (₹500)
1. User goes to Wallet > Add Money
2. Enters amount: 500
3. Clicks "Proceed to Payment"
4. Backend creates order (order_id = ABC123)
5. Razorpay checkout opens
6. User completes payment (test card: 4111111111111111, any future date, any CVV)
7. Payment succeeds
8. Frontend sends payment_id + signature to backend
9. Backend verifies signature
10. Wallet balance increases by 500 (minus fees if applicable)
11. User sees success message + updated balance

### Scenario 2: Failed Payment
1. User enters ₹100 (less than minimum ₹100? Or test with invalid card)
2. Razorpay checkout opens
3. User uses declined card (test card: 4000000000000002)
4. Payment fails
5. Razorpay shows error to user
6. User can retry or cancel

### Scenario 3: Invalid Signature
1. User completes payment
2. Frontend is compromised and modifies signature
3. Backend receives: order_id, payment_id, invalid_signature
4. RazorpayService::verifyPaymentSignature() rejects
5. Wallet is NOT credited
6. User sees error message
7. Transaction remains in pending status

### Scenario 4: Order from Wallet
1. User adds products to cart
2. Proceeds to checkout
3. Selects payment method: "Wallet"
4. Backend checks wallet balance >= order total
5. Deducts amount from wallet
6. Creates order with payment_status = completed
7. Wallet transaction recorded
8. User sees order confirmation

---

## Test Cards (For Testing - NOT for live transactions)

| Card | Status | CVV | Date |
|------|--------|-----|------|
| 4111111111111111 | Success | Any 3 digits | Any future |
| 4000000000000002 | Declined | Any 3 digits | Any future |
| 4000000000000069 | 3D Secure | Any 3 digits | Any future |

**Important**: These test cards only work in Razorpay TEST mode. In LIVE mode, only real card transactions will work.

---

## Testing Payment Signature Verification

### How HMAC-SHA256 Works
```php
// Razorpay sends:
{
    "razorpay_order_id": "order_123",
    "razorpay_payment_id": "pay_456",
    "razorpay_signature": "abc123xyz"  // HMAC-SHA256 hash
}

// Backend verifies:
$expected_signature = hash_hmac(
    'sha256',
    'order_123|pay_456',
    'IPpmfWuwinMDo8rqbKw0Z2TV'  // KEY_SECRET
);

if ($expected_signature === 'abc123xyz') {
    // Signature valid - payment is authentic
} else {
    // Fraud detected - reject payment
}
```

### Testing Signature Verification
```bash
php artisan tinker

# Simulate signature verification
>>> $orderId = 'order_ABC123';
>>> $paymentId = 'pay_ABC456';
>>> $keySecret = config('razorpay.key_secret');
>>> $signature = hash_hmac('sha256', "$orderId|$paymentId", $keySecret);
>>> echo $signature;  // This should match Razorpay's signature

# Test with RazorpayService
>>> $service = app(\App\Services\RazorpayService::class);
>>> $valid = $service->verifyPaymentSignature($orderId, $paymentId, $signature);
>>> echo $valid ? 'Valid' : 'Invalid';
```

---

## Webhook Testing (Optional for Production)

### Setup Webhook Endpoint
```php
// routes/api.php
Route::post('/webhooks/razorpay', [WebhookController::class, 'razorpay']);
```

### WebhookController
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserWalletTransaction;
use App\Services\RazorpayService;

class WebhookController extends Controller
{
    public function razorpay(Request $request, RazorpayService $razorpayService)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        
        // Verify webhook signature
        if (!$razorpayService->validateWebhook($payload, $signature)) {
            return response('Invalid signature', 400);
        }
        
        $event = $request->json('event');
        $data = $request->json('payload.payment.entity');
        
        // Handle payment.authorized event
        if ($event === 'payment.authorized') {
            // Process payment
        }
        
        return response('Webhook processed', 200);
    }
}
```

---

## Production Deployment Checklist

### Pre-Launch Testing
- [ ] All 76 API endpoints tested
- [ ] Wallet topup flow tested end-to-end
- [ ] Payment signature verification tested
- [ ] Order creation with wallet payment tested
- [ ] Referral bonus credit tested
- [ ] Search functionality tested
- [ ] All database migrations run
- [ ] All seeders executed
- [ ] Images optimized and served via CDN
- [ ] Error logging configured
- [ ] Rate limiting tested
- [ ] Security headers configured

### Database Setup
```bash
# Run fresh migrations with seeders
php artisan migrate:fresh --seed

# Verify tables created
php artisan migrate:status

# Check data seeded
php artisan tinker
>>> User::count()
>>> Product::count()
>>> Order::count()
```

### Configuration Verification
```bash
# Check all required .env variables
cat .env | grep -E "RAZORPAY|API|APP_"

# Should include:
APP_DEBUG=false
APP_ENV=production
RAZORPAY_KEY_ID=rzp_live_...
RAZORPAY_KEY_SECRET=...
SANCTUM_TOKEN_EXPIRATION=10080
```

### Performance Testing
```bash
# Test API response times
time curl http://localhost/admagpro/api/v1/search/products?q=phone

# Target: < 100ms for search
# Target: < 50ms for product detail
# Target: < 200ms for order creation
```

### Security Checklist
- [ ] HTTPS enabled
- [ ] SSL certificate installed
- [ ] CORS configured for frontend domain
- [ ] Rate limiting enabled (prevent brute force)
- [ ] SQL injection prevention verified
- [ ] XSS protection enabled
- [ ] CSRF tokens configured
- [ ] Password hashing verified
- [ ] API keys in .env (not in code)
- [ ] Sensitive logs excluded from public

### Monitoring Setup
```bash
# Enable Laravel telescope (development only)
php artisan telescope:install

# Configure logging
# In config/logging.php:
# - Set default channel to 'daily' for production
# - Rotate logs after 14 days
# - Store logs in storage/logs/

# Setup error tracking
# - Sentry for crash reporting
# - Or Bugsnag for error monitoring
```

---

## Going Live Checklist

### 1 Week Before Launch
- [ ] Final testing of all features
- [ ] Load test with 1000+ concurrent users
- [ ] Security audit
- [ ] Performance optimization
- [ ] Backup strategy configured
- [ ] Monitoring alerts set up
- [ ] Support documentation ready

### Day Before Launch
- [ ] Final database backup
- [ ] Staging deployment successful
- [ ] All team members briefed
- [ ] Rollback plan documented
- [ ] Razorpay support contact ready
- [ ] Emergency contacts updated

### Launch Day
- [ ] Deploy to production
- [ ] Verify all endpoints working
- [ ] Monitor error logs in real-time
- [ ] Test payment flow with real transaction
- [ ] Confirm user registrations working
- [ ] Verify emails sending
- [ ] Check push notifications

### Post-Launch Monitoring
- [ ] Response time monitoring
- [ ] Error rate monitoring
- [ ] User signups tracking
- [ ] Transaction tracking
- [ ] Database performance
- [ ] Payment success rate
- [ ] Customer support tickets

---

## Troubleshooting

### Issue: Payment Signature Invalid
**Symptoms**: User completes payment but verification fails
**Solution**:
1. Verify KEY_SECRET is correct in .env
2. Check Razorpay dashboard for payment details
3. Manually verify signature using tinker
4. Contact Razorpay support if needed

### Issue: Wallet Not Credited
**Symptoms**: Payment verified but balance unchanged
**Solution**:
1. Check UserWalletTransaction table
2. Verify wallet_balance in users table
3. Check database transaction logs
4. Run: `php artisan tinker` → `UserWalletTransaction::latest()->get()`

### Issue: Search Not Working
**Symptoms**: /api/v1/search returns empty results
**Solution**:
1. Verify full-text indexes created: `SHOW INDEX FROM products`
2. Check products have data: `SELECT COUNT(*) FROM products WHERE is_active = 1`
3. Verify search query: Try `/api/v1/search/products?q=test`
4. Rebuild indexes: `php artisan tinker` → `Product::query()->get()`

### Issue: High API Response Times
**Symptoms**: Requests taking > 500ms
**Solution**:
1. Check database indexes: `SHOW INDEXES FROM products`
2. Enable query logging: `APP_DEBUG=true`
3. Check slow query log in MySQL
4. Optimize images (serve via CDN)
5. Enable caching for frequently accessed data

---

## Live Transaction Testing

### Real Test (Small Amount)
1. Create test user account
2. Add ₹1 to wallet
3. Verify payment flow
4. Confirm wallet credited
5. Check transaction log

### Full Order Testing
1. Add products to cart
2. Proceed to checkout
3. Select wallet payment
4. Complete order
5. Verify order status
6. Check transaction history
7. Test order cancellation & refund

---

## Razorpay Dashboard

### Important Checks
1. **Dashboard**: Monitor daily transactions
2. **Settlements**: Verify daily payouts to bank account
3. **Webhooks**: Check webhook delivery status
4. **API Keys**: Rotate keys every 6 months
5. **Rate Limits**: Set up alerts for suspicious activity

### Contact Razorpay Support
- **Email**: support@razorpay.com
- **Dashboard**: https://dashboard.razorpay.com
- **Documentation**: https://razorpay.com/docs

---

## Success Criteria

✅ All 76 API endpoints working  
✅ Payment integration 100% success rate  
✅ Signature verification preventing fraud  
✅ Wallet transactions atomic & reliable  
✅ Search < 100ms response time  
✅ 99.9% uptime target  
✅ Zero payment failures (except user-cancelled)  
✅ Full audit trail of all transactions  

---

Generated: May 25, 2026
