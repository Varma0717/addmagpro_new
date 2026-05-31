# 🔧 FLUTTER APP FIXES - IMPLEMENTATION GUIDE

**Status:** Phase 1 & 2 Fixes In Progress  
**Date:** May 31, 2026

---

## ✅ COMPLETED FIXES

### Phase 1: Critical API Integration Fixes

#### 1. **✅ Fixed Token Authentication in Repositories**
All repositories now accept and pass bearer tokens to API calls.

**Files Fixed:**
- `lib/features/home/data/home_repository.dart`
  - Added `token` parameter to `fetch()`, `fetchStates()`, `fetchDistricts()`
  - Now sends: `await _apiClient.get(path, bearerToken: token)`

- `lib/features/catalog/data/catalog_repository.dart`
  - Added `token` parameter to all fetch methods
  - Products, listings, and details now authenticated

- `lib/features/search/data/search_repository.dart`
  - Added `token` parameter to `search()`

#### 2. **✅ Fixed Home Screen to Pass Tokens**
- Updated `_DashboardView._load()` to pass token to repository
- Updated `_openLocationSheet()` to pass token to `fetchStates()`
- Updated `_LocationPickerSheet` to accept and use token for `fetchDistricts()`
- Updated `ProductListScreen._load()` to pass token

#### 3. **✅ Created Missing Laravel API Endpoints**
- **Added to `LocationApiController`:**
  - `getStates()` - Returns all states
  - `getDistricts($stateId)` - Returns districts for state

- **Added to `routes/api.php`:**
  - `GET /v1/locations/states`
  - `GET /v1/locations/districts/{stateId}`

---

## 🔄 IN PROGRESS / TODO

### Phase 2: API Response Format & Data Model Fixes

**Issue:** Laravel returns different response structures than Flutter expects.

**Laravel Response Format:**
```json
{
  "success": true,
  "data": [{...}],
  "message": "Success"
}
```

**Flutter Expected Format:**
```json
{
  "data": [{...}],
  "meta": {
    "pagination": {...},
    "filters": {...}
  }
}
```

**Action Required:**
- [ ] Update Laravel API responses to match Flutter expectations OR
- [ ] Update Flutter data models to parse Laravel format correctly

**Best Approach:** Update Flutter models (less backend changes)

---

### Phase 3: Image URL Resolution

**Issue:** Images not showing because URLs not properly resolved.

**Current Problem:**
- Laravel returns: `/storage/products/123.jpg`
- Flutter tries to load: `https://addmagpro.pmratnam.com/storage/products/123.jpg` ✓
- But `AppConfig.resolveImageUrl()` not being used consistently

**Solution:** Ensure all image URLs in models use `AppConfig.resolveImageUrl()`

**Files to Update:**
- All model classes that have image URLs must call `AppConfig.resolveImageUrl()`

---

### Phase 4: Verify All Features

**Features to Test:**
- [ ] Products listing with images
- [ ] Search functionality
- [ ] Home feed with banners, categories, products
- [ ] Wallet display and transactions
- [ ] Cart operations
- [ ] Checkout and orders
- [ ] Referrals
- [ ] Wishlist
- [ ] Notifications

---

### Phase 5: UI Redesign (Amazon-like)

**Current State:** Very basic orange design
**Target:** Amazon-like UI with:
- [ ] Location selector with delivery info
- [ ] Advanced search and filters
- [ ] Deals/lightning deals
- [ ] Category grid with icons
- [ ] Product cards with ratings/reviews
- [ ] Seller information
- [ ] Recommended section
- [ ] Better color palette (not just orange)
- [ ] Proper spacing and typography
- [ ] Loading states and animations

---

## 📋 NEXT STEPS (IMMEDIATE)

### Step 1: Fix API Response Parsing
Update Flutter models to properly parse Laravel's response format.

**Example - Current (Broken):**
```dart
factory ProductListResponse.fromJson(Map<String, dynamic> json) {
  final data = json['data'];
  final meta = json['meta'];           // ❌ Laravel doesn't have this
  final pagination = meta['pagination']; // ❌ Will crash
  // ...
}
```

**Should Be:**
```dart
factory ProductListResponse.fromJson(Map<String, dynamic> json) {
  // Handle both formats for compatibility
  final data = json['data'] ?? json;
  final items = data is List 
    ? data.whereType<Map<String, dynamic>>().map(ProductListItem.fromJson).toList()
    : <ProductListItem>[];
  
  return ProductListResponse(items: items);
}
```

### Step 2: Fix Image URLs in Models
Ensure all models resolve image URLs properly.

**Example - Current:**
```dart
class ProductListItem {
  final String? primaryImageUrl;
  // Image used directly without resolution
}
```

**Should Be:**
```dart
class ProductListItem {
  final String? primaryImageUrl;
  
  String? get imageUrl => AppConfig.resolveImageUrl(primaryImageUrl);
}
```

### Step 3: Test Each Feature
Run Flutter app and verify:
1. Login works
2. Home feed loads with images
3. Products display correctly
4. Search works
5. Cart operations work
6. Wallet displays balance
7. Orders show correctly

### Step 4: Begin UI Redesign
Once data is flowing, start redesigning screens to match Amazon-like standard.

---

## 🛠️ DETAILED CHANGES MADE

### Changes to Flutter Code

#### 1. `lib/features/home/data/home_repository.dart`
```dart
// BEFORE
Future<HomeFeed> fetch({...}) async {
  final path = params.isEmpty ? '/home' : '/home?${params.join('&')}';
  final payload = await _apiClient.get(path);  // ❌ No token
  return HomeFeed.fromJson(payload);
}

// AFTER
Future<HomeFeed> fetch({
  String? token,  // ✅ Added token
  ...
}) async {
  final path = params.isEmpty ? '/home' : '/home?${params.join('&')}';
  final payload = await _apiClient.get(path, bearerToken: token);  // ✅ Pass token
  return HomeFeed.fromJson(payload);
}
```

#### 2. `lib/features/catalog/data/catalog_repository.dart`
```dart
// BEFORE
Future<ProductListResponse> fetchProducts({
  int page = 1,
  ...
}) async {
  final payload = await _apiClient.get('/products?...');  // ❌ No token
  return ProductListResponse.fromJson(payload);
}

// AFTER
Future<ProductListResponse> fetchProducts({
  String? token,  // ✅ Added
  int page = 1,
  ...
}) async {
  final payload = await _apiClient.get('/products?...', bearerToken: token);  // ✅ Pass token
  return ProductListResponse.fromJson(payload);
}
```

#### 3. `lib/features/home/home_screen.dart`
```dart
// BEFORE - DashboardView._load()
final response = await _repository.fetch(
  stateId: widget.stateId,
  // ❌ No token sent
);

// AFTER
final response = await _repository.fetch(
  token: widget.token,  // ✅ Pass token
  stateId: widget.stateId,
);
```

### Changes to Laravel Code

#### 1. `app/Http/Controllers/Api/V1/LocationApiController.php`
Added two new public methods:
```php
public function getStates(Request $request)
public function getDistricts($stateId)
```

#### 2. `routes/api.php`
Added routes:
```php
Route::get('states', [LocationApiController::class, 'getStates']);
Route::get('districts/{stateId}', [LocationApiController::class, 'getDistricts']);
```

---

## 🧪 TESTING CHECKLIST

### Pre-Testing Setup
- [ ] Deploy Laravel API updates
- [ ] Build Flutter app with fixes
- [ ] Clear Flutter app cache

### Authentication Tests
- [ ] User can login
- [ ] Token is properly stored
- [ ] Subsequent API calls include token

### Data Fetching Tests
- [ ] Home feed loads successfully
- [ ] Products display in list
- [ ] Product images load correctly
- [ ] Search returns results
- [ ] States dropdown populates
- [ ] Districts dropdown populates

### Feature Tests
- [ ] Add to cart works
- [ ] Wallet displays balance
- [ ] Orders load with details
- [ ] Referrals show correctly
- [ ] Wishlist operations work
- [ ] Notifications display

### UI/UX Tests
- [ ] Loading states show properly
- [ ] Errors display with retry
- [ ] Images have fallback handling
- [ ] Pull-to-refresh works
- [ ] Pagination works for lists
- [ ] Filters apply correctly

---

## 📱 TESTING PROCEDURE

### 1. Run Flutter App
```bash
cd mobile-apps/addmagpro_mobile
flutter clean
flutter pub get
flutter run
```

### 2. Test Login
- Use test credentials
- Verify token in secure storage

### 3. Test Home Screen
- Should see banner carousel
- Should see categories
- Should see products with images
- Should be able to select location

### 4. Test Product Listing
- Browse products
- Apply filters
- Search products
- View product details

### 5. Test Cart & Checkout
- Add products to cart
- Update quantities
- Apply coupons
- Place order

### 6. Test Wallet
- Check balance display
- View transactions
- Request withdrawal

---

## 🎯 SUCCESS CRITERIA

| Feature | Status | Expected |
|---------|--------|----------|
| Authentication | | ✓ Login/token storage works |
| Home Feed | | ✓ Data loads with images |
| Products | | ✓ Browse and filter working |
| Images | | ✓ All display correctly |
| Cart | | ✓ Add/update/remove items |
| Wallet | | ✓ Balance and transactions display |
| Search | | ✓ Find products and services |
| Orders | | ✓ List and detail view working |
| Responsive | | ✓ Works on different screen sizes |
| Performance | | ✓ Loads quickly, no janks |

---

## 🚀 DEPLOYMENT PLAN

### Stage 1: Backend Fixes (Today)
- Deploy LocationApiController changes
- Deploy route updates
- Test endpoints with Postman

### Stage 2: Flutter Fixes (Today)
- Build with token fixes
- Test locally
- Fix data models
- Test data loading

### Stage 3: QA Testing (Tomorrow)
- Full feature testing
- Performance testing
- Edge case handling
- Error scenarios

### Stage 4: UI Redesign (This Week)
- Design new screens (Amazon-like)
- Update components
- Add animations
- Polish UX

### Stage 5: Release (Next Week)
- Beta testing
- User feedback
- Final adjustments
- Production release

---

## 📞 SUPPORT & DEBUGGING

### Common Issues & Solutions

**Issue: 401 Unauthorized**
- Check token is being passed to API calls
- Verify token is valid in secure storage
- Check bearerToken parameter in all API calls

**Issue: Images not showing**
- Check image URL is being resolved with `AppConfig.resolveImageUrl()`
- Verify image path is correct in database
- Check storage permissions on device

**Issue: Data not loading**
- Check network connectivity
- Verify API endpoints are correct
- Check response format is being parsed correctly
- Look at error messages in logs

**Issue: Search returning empty**
- Check search query is at least 2 characters
- Verify products exist in database
- Check search index is updated

---

**Next Review:** After Phase 1 & 2 testing complete  
**Last Updated:** May 31, 2026
