# Database Setup & Testing Guide

## Quick Start

### 1. Run Migrations
```bash
# Fresh database setup (recommended for development)
php artisan migrate:fresh --seed

# Or just run pending migrations
php artisan migrate
php artisan db:seed
```

### 2. Test API Endpoints
Use Postman, Insomnia, or curl:

```bash
# Register new user
curl -X POST http://localhost/admagpro/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "9876543210",
    "password": "Password@123",
    "password_confirmation": "Password@123"
  }'

# Response includes token
# {
#   "success": true,
#   "data": {
#     "user": {...},
#     "token": "1|xyz..."
#   }
# }
```

### 3. Use Token for Protected Routes
```bash
# Get wallet balance (requires authentication)
curl -X GET http://localhost/admagpro/api/v1/account/wallet \
  -H "Authorization: Bearer 1|xyz..."
```

---

## Testing Wallet Flow

### Step 1: Create Topup Order
```bash
curl -X POST http://localhost/admagpro/api/v1/account/wallet/topup/create \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 100,
    "payment_method": "razorpay"
  }'

# Response:
# {
#   "order_id": "order_ABC123",
#   "amount": 100,
#   "razorpay_key": "rzp_live_...",
#   "transaction_id": "...",
#   "customer_name": "John Doe",
#   "customer_email": "john@example.com"
# }
```

### Step 2: Payment Processing (On Client)
- Client receives order details
- Shows Razorpay checkout
- User completes payment
- Client receives payment_id + signature

### Step 3: Verify Payment
```bash
curl -X POST http://localhost/admagpro/api/v1/account/wallet/topup/verify \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "razorpay_order_id": "order_ABC123",
    "razorpay_payment_id": "pay_ABC123",
    "razorpay_signature": "signature_hash"
  }'

# Response:
# {
#   "success": true,
#   "data": {
#     "transaction_id": "...",
#     "amount_credited": 100,
#     "new_balance": 100
#   }
# }
```

---

## Testing Search

### Text Search
```bash
curl -X GET "http://localhost/admagpro/api/v1/search/products?q=phone&per_page=10&sort_by=relevance"
```

### Voice Search
```bash
curl -X POST http://localhost/admagpro/api/v1/search/voice \
  -H "Content-Type: application/json" \
  -d '{
    "transcript": "black shoes under 5000",
    "confidence": 0.95
  }'
```

### Barcode Search
```bash
curl -X GET "http://localhost/admagpro/api/v1/search/barcode?barcode=8901234567890"
```

### Suggestions
```bash
curl -X GET "http://localhost/admagpro/api/v1/search/suggestions?q=ph&type=all&limit=10"
```

---

## Testing Shopping Cart

### Add to Cart
```bash
curl -X POST http://localhost/admagpro/api/v1/cart/add \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1,
    "quantity": 2
  }'
```

### Apply Coupon
```bash
curl -X POST http://localhost/admagpro/api/v1/cart/apply-coupon \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "coupon_code": "SAVE10"
  }'
```

### Create Order
```bash
curl -X POST http://localhost/admagpro/api/v1/orders/create \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "shipping_address": "123 Main St",
    "shipping_city": "Hyderabad",
    "shipping_state": "Telangana",
    "shipping_postal_code": "500001",
    "shipping_phone": "9876543210",
    "payment_method": "wallet"
  }'
```

---

## Testing Referrals

### Get Referral Code
```bash
curl -X GET http://localhost/admagpro/api/v1/account/referrals/profile \
  -H "Authorization: Bearer YOUR_TOKEN"

# Response includes:
# {
#   "referral_code": "REF12345ABC",
#   "referral_link": "http://localhost/admagpro/referral/REF12345ABC",
#   ...
# }
```

### Share Referral
```bash
curl -X POST http://localhost/admagpro/api/v1/account/referrals/share \
  -H "Authorization: Bearer YOUR_TOKEN"

# Response includes social share URLs
```

### Register with Referral Code
When new user registers:
```bash
curl -X POST http://localhost/admagpro/api/v1/account/referrals/register \
  -H "Authorization: Bearer NEW_USER_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "referral_code": "REF12345ABC"
  }'
```

---

## Database Seeding

### What Gets Seeded
Running `php artisan db:seed` creates:

**Locations (12 cities)**
- Hyderabad, Bangalore, Mumbai, Chennai
- Delhi, Lucknow, Ahmedabad, Surat
- Visakhapatnam, Vijayawada, Mangalore, Coimbatore

**Services (11 categories)**
- Beauty, Wedding Planning, Gym
- Education, Packers & Movers
- Repairs, Rent & Hire, Jobs
- Loans, Real Estate, PG/Hostel

**Banners (3 promotional)**
- Festive Vibes, Up to 80% Sale, New Launches

**Categories (8 main)**
- Fashion, Beauty, Footwear, Home & Living
- Accessories, Electronics, Sports, Books

### Custom Seeders
```bash
# Seed only locations
php artisan db:seed --class=LocationSeeder

# Seed only categories
php artisan db:seed --class=CategorySeeder
```

---

## Sample Data for Testing

### Add Test Products
```bash
php artisan tinker

# Create a test product
>>> Product::create([
  'name' => 'Test Phone',
  'slug' => 'test-phone',
  'description' => 'A great phone',
  'category_id' => 1,
  'price' => 25000,
  'discount_percent' => 10,
  'stock_quantity' => 50,
  'sku' => 'PHONE001',
  'is_active' => true,
  'is_featured' => true
]);

# Create images
>>> $product = Product::first();
>>> $product->images()->create([
  'image_url' => 'https://via.placeholder.com/500',
  'is_primary' => true,
  'alt_text' => 'Product image'
]);
```

### Create Test Coupons
```bash
>>> Coupon::create([
  'code' => 'SAVE10',
  'discount_type' => 'percent',
  'discount_value' => 10,
  'minimum_order_value' => 500,
  'max_usage' => 100,
  'max_usage_per_user' => 1,
  'is_active' => true
]);
```

---

## Common Issues & Solutions

### Full-Text Search Not Working
**Problem**: Search returns no results  
**Solution**: Ensure products table has FULLTEXT index

```bash
# Check indexes
php artisan tinker
>>> DB::select('SHOW INDEX FROM products WHERE Key_name LIKE "%search%"')

# If missing, run migration
php artisan migrate --path=database/migrations/2026_05_25_000022_add_search_fields_to_products.php
```

### Payment Signature Invalid
**Problem**: Razorpay topup verify fails  
**Solution**: Ensure correct key_id and key_secret in .env

```bash
# In .env, verify:
RAZORPAY_KEY_ID=rzp_live_ClCu3iwRLchrGu
RAZORPAY_KEY_SECRET=IPpmfWuwinMDo8rqbKw0Z2TV
```

### Cart Calculations Wrong
**Problem**: Tax/discount not calculating correctly  
**Solution**: Check config/wallet.php for tax rate

```php
// config/wallet.php
'tax_rate' => 0.18, // 18% GST
'topup_fee_percent' => 2.36, // Razorpay + GST
```

### Search Logs Not Saving
**Problem**: Analytics not recording searches  
**Solution**: Ensure search_logs table exists

```bash
# Create table if missing
php artisan migrate --path=database/migrations/2026_05_25_000021_create_search_logs_table.php
```

---

## Performance Testing

### Load Test Search
```bash
# Using Apache Bench
ab -n 1000 -c 10 "http://localhost/admagpro/api/v1/search/products?q=phone"

# Results should be:
# - Requests/sec: > 100
# - Mean time: < 100ms
# - Failed requests: 0
```

### Monitor Database Queries
```bash
# Enable query logging in .env
APP_DEBUG=true

# In tinker:
>>> DB::connection()->enableQueryLog();
>>> // Run API request
>>> DB::getQueryLog();
```

---

## Useful Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear database cache
php artisan db:seed --force

# Tinker interactive shell
php artisan tinker

# View all routes
php artisan route:list

# Check migrations status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback

# Migrate and seed fresh
php artisan migrate:fresh --seed

# Optimize for production
php artisan optimize
php artisan view:cache
php artisan route:cache
```

---

## Environment Variables Checklist

```env
# App
APP_NAME=AddMagPro
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost/admagpro

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=addmagpro
DB_USERNAME=root
DB_PASSWORD=

# Authentication
SANCTUM_STATEFUL_DOMAINS=localhost
SANCTUM_TOKEN_EXPIRATION=10080

# Payment
RAZORPAY_KEY_ID=rzp_live_ClCu3iwRLchrGu
RAZORPAY_KEY_SECRET=IPpmfWuwinMDo8rqbKw0Z2TV
RAZORPAY_MODE=live

# Wallet Configuration
WALLET_MIN_TOPUP=100
WALLET_MAX_TOPUP=100000
WALLET_ENABLED=true

# Google Maps (Optional)
GOOGLE_MAPS_API_KEY=your-api-key-here
GOOGLE_MAPS_ENABLED=false
```

---

## Next Steps

1. ✅ Run migrations
2. ✅ Seed test data
3. ✅ Test all endpoints
4. ✅ Verify Razorpay integration
5. ✅ Check search functionality
6. → Start Flutter development

Good luck! 🚀
