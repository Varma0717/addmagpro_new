# 🧪 FLUTTER APP TESTING QUICK GUIDE

**Purpose:** Verify all fixes are working correctly  
**Estimated Time:** 30 minutes  
**Date:** May 31, 2026

---

## ✅ PRE-TEST CHECKLIST

- [ ] All code changes deployed to Laravel
- [ ] Flutter app rebuilt with all fixes
- [ ] Device/emulator has internet connection
- [ ] Test user account created in Laravel

---

## 🔄 STEP-BY-STEP TESTING

### TEST 1: Authentication & Token ⭐ CRITICAL
**Expected:** User can login and token is stored

**Steps:**
1. Open Flutter app
2. Tap "Login" if not already logged in
3. Enter test credentials (phone: 9876543210, password: password)
4. Tap "Sign In"
5. Wait for loading

**Expected Results:**
- ✅ User logged in successfully
- ✅ Redirected to home screen
- ✅ No 401 Unauthorized errors in logs
- ✅ Token stored in secure storage

**If Failed:**
- Check Laravel login endpoint returns proper token
- Verify secure storage is working on device
- Check bearerToken is being sent in subsequent calls

---

### TEST 2: Home Feed Loading ⭐ CRITICAL
**Expected:** Home screen loads with all content

**Steps:**
1. You should be on home screen (from Test 1)
2. Look at top of screen
3. Wait 2-3 seconds for data to load
4. Scroll down

**Expected Results:**
- ✅ Banner carousel appears with images
- ✅ Categories section loads
- ✅ Featured products show with images
- ✅ Services section visible
- ✅ No error messages
- ✅ Pull-to-refresh works

**If Failed:**
- Check console for API errors
- Verify `/api/v1/home` returns data
- Ensure token is being passed to home API call
- Check image URLs are resolving properly

---

### TEST 3: Location Selection
**Expected:** Can select state and district

**Steps:**
1. On home screen, find location chip (near top with location icon)
2. Tap location chip
3. Bottom sheet should appear with "Choose location" title

**In Location Sheet:**
1. Tap "State" dropdown (should show "All India")
2. Select any state from list

**Expected Results:**
- ✅ States dropdown shows multiple states
- ✅ Selecting a state works
- ✅ Districts dropdown populates for selected state
- ✅ Can select a district
- ✅ "Apply" button works

**If Failed:**
- Check `/api/v1/locations/states` returns data
- Check `/api/v1/locations/districts/1` returns data
- Verify token is being passed to location endpoints
- Check State and District models have data in database

---

### TEST 4: Product Listing
**Expected:** Products load with images and prices

**Steps:**
1. Scroll down on home screen to "Featured Products" section
2. Look at product cards

**Expected Results:**
- ✅ Product images load (not blank)
- ✅ Product names display
- ✅ Prices show (with ₹ symbol)
- ✅ Rating (if available) shows
- ✅ Can scroll through products

**If Failed:**
- Check `/api/v1/products` response includes primary_image_url
- Verify image URLs are being resolved correctly
- Check storage folder has images
- Verify effective_price is being calculated in Laravel

---

### TEST 5: Product Search
**Expected:** Can search and find products

**Steps:**
1. Tap search icon (magnifying glass in top bar)
2. Type product name (e.g., "test")
3. Wait for results
4. See search results

**Expected Results:**
- ✅ Search box accepts input
- ✅ Results load after typing
- ✅ Products show with images
- ✅ Can tap product to view details

**If Failed:**
- Check search API endpoint exists
- Verify token is passed to search endpoint
- Check database has test products

---

### TEST 6: Browse Categories
**Expected:** Can view all categories

**Steps:**
1. Tap "Categories" in bottom navigation
2. See grid of categories

**Expected Results:**
- ✅ Category grid shows 8+ categories
- ✅ Each category has image and name
- ✅ Can tap category to filter products

**If Failed:**
- Check `/api/v1/products/categories` endpoint
- Verify categories exist in database
- Check category images are uploaded

---

### TEST 7: Cart Operations
**Expected:** Can add items to cart

**Steps:**
1. Go to any product (from home screen or search)
2. Tap "Add to Cart"
3. Tap cart icon in bottom navigation
4. See item in cart

**Expected Results:**
- ✅ Item added to cart successfully
- ✅ Cart badge shows count
- ✅ Cart screen shows item with image, name, price
- ✅ Can update quantity
- ✅ Can remove item

**If Failed:**
- Check cart API endpoint works
- Verify token is being passed to cart endpoints
- Check cart database tables exist

---

### TEST 8: Wallet Display
**Expected:** Wallet balance shows

**Steps:**
1. Tap "Account" in bottom navigation
2. Look for wallet balance

**Expected Results:**
- ✅ Wallet section visible
- ✅ Balance displays (₹ symbol)
- ✅ Transactions list shows (if any)

**If Failed:**
- Check `/api/v1/account/wallet` endpoint
- Verify wallet table has data for user
- Check token is passed to wallet endpoint

---

### TEST 9: Orders
**Expected:** Can see orders

**Steps:**
1. On Account screen, find "Orders" section
2. Tap to view orders

**Expected Results:**
- ✅ Order list shows (if user has orders)
- ✅ Each order shows: order number, status, total, date
- ✅ Can tap order to see details

**If Failed:**
- Check `/api/v1/account/orders` endpoint
- Create test order for user
- Verify token passed to orders endpoint

---

### TEST 10: Image Loading (Critical for UI)
**Expected:** All images load correctly

**Verification Across All Screens:**
- [ ] Home: Banners load ✓
- [ ] Home: Category images load ✓
- [ ] Home: Product images load ✓
- [ ] Products: Product thumbnails load ✓
- [ ] Products: Product detail image loads ✓
- [ ] Cart: Item images load ✓

**If Images Don't Load:**
```
Problem: Image URLs not resolving
Solution: 
1. Check AppConfig.resolveImageUrl() is being called
2. Verify image path format in Laravel response
3. Check storage folder permissions
4. Try accessing image URL directly in browser
```

---

## 🐛 COMMON ISSUES & SOLUTIONS

### Issue: 401 Unauthorized Errors
**Symptoms:** API calls failing with 401 error
**Solution:**
```
1. Check token is being stored in secure storage
2. Verify token is included in all API headers
3. Test token manually:
   curl -H "Authorization: Bearer TOKEN" \
     https://addmagpro.pmratnam.com/api/v1/home
4. Check token expiration (if implemented)
```

### Issue: No Data Loading (Empty Screens)
**Symptoms:** Screens show "Loading..." then blank
**Solution:**
```
1. Check network connectivity
2. Test API endpoints in Postman:
   - GET /api/v1/home
   - GET /api/v1/products
   - GET /api/v1/locations/states
3. Check response format in Laravel (should have 'success': true)
4. Verify Flutter parsing is correct
```

### Issue: Images Not Showing
**Symptoms:** Placeholder or blank images everywhere
**Solution:**
```
1. Check image URLs in Laravel response
2. Verify AppConfig.resolveImageUrl() is working
3. Test image URL in browser directly
4. Check storage folder has images
5. Verify database paths are correct
```

### Issue: Location Dropdown Empty
**Symptoms:** State dropdown shows but is empty
**Solution:**
```
1. Check State table has data in database
2. Test endpoint: GET /api/v1/locations/states
3. Verify response format matches model expectations
4. Check token is passed (if authenticated)
```

---

## 📊 SUCCESS CRITERIA

| Feature | Test | Pass/Fail |
|---------|------|-----------|
| Login & Token | Authentication works | ☐ |
| Home Feed | Data loads with images | ☐ |
| Location Select | States/districts load | ☐ |
| Products | List loads, images show | ☐ |
| Search | Can find products | ☐ |
| Categories | Grid displays | ☐ |
| Cart | Add/remove items work | ☐ |
| Wallet | Balance displays | ☐ |
| Orders | List/details show | ☐ |
| Images | All load correctly | ☐ |

---

## 📱 TESTING ON DEVICE

### Android Testing
```bash
# Build debug APK
flutter build apk --debug

# Install on device
adb install build/app/outputs/flutter-apk/app-debug.apk

# View logs
adb logcat | grep "flutter"
```

### iOS Testing
```bash
# Build and run
flutter run -d <device_id>

# View logs
flutter logs
```

---

## 🔍 VERIFICATION COMMANDS

Test each endpoint from command line to ensure Laravel side is working:

```bash
# Get token first (replace with actual user credentials)
TOKEN=$(curl -X POST https://addmagpro.pmratnam.com/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"phone":"9876543210","password":"password"}' \
  | jq -r '.data.token')

# Test Home Feed
curl -X GET "https://addmagpro.pmratnam.com/api/v1/home" \
  -H "Authorization: Bearer $TOKEN"

# Test Products
curl -X GET "https://addmagpro.pmratnam.com/api/v1/products" \
  -H "Authorization: Bearer $TOKEN"

# Test States
curl -X GET "https://addmagpro.pmratnam.com/api/v1/locations/states"

# Test Districts
curl -X GET "https://addmagpro.pmratnam.com/api/v1/locations/districts/1"

# Test Wallet
curl -X GET "https://addmagpro.pmratnam.com/api/v1/account/wallet" \
  -H "Authorization: Bearer $TOKEN"
```

---

## 📋 TEST REPORT TEMPLATE

Use this to document your testing:

```
Date: ___________
Tester: ___________
App Version: ___________
Device: ___________
OS Version: ___________

TESTS PASSED:
☐ Authentication
☐ Home Feed
☐ Location Selection
☐ Product Listing
☐ Search
☐ Categories
☐ Cart
☐ Wallet
☐ Orders
☐ Images Loading

ISSUES FOUND:
1. _____________
2. _____________
3. _____________

NOTES:
_____________
_____________
```

---

## ✅ SIGN-OFF

Once all tests pass, you can proceed to:
1. UI/UX Redesign (Amazon-like)
2. Add missing features
3. Performance optimization
4. Production release

---

*Testing Quick Guide - v1.0*  
*Last Updated: May 31, 2026*
