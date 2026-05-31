# User Flow Testing Guide

## Three User Perspective Testing

This document guides you through testing AddMagPro from three different user perspectives:
1. **Visitor** - Anonymous user browsing products
2. **Customer** - Logged-in user accessing account features
3. **Admin** - Administrator managing the platform

---

## Test Environment Setup

**Local URL:** http://localhost/admagpro/
**Production URL:** https://addmagpro.pmratnam.com/

**Browser DevTools:** F12 (to check console errors and localStorage)

---

## Test 1: VISITOR PERSPECTIVE ✅ (No Authentication)

### Objective
Verify that visitors can browse the website, view products, and access authentication pages without needing to log in.

### Test Steps

1. **Homepage Access**
   - [ ] Open: http://localhost/admagpro/
   - [ ] Expected: Homepage loads with categories, trending products, new arrivals
   - [ ] Check: No errors in browser console (F12 → Console tab)
   - [ ] Visual: Tailwind CSS styling applied, responsive layout

2. **Header Navigation**
   - [ ] Look at header section
   - [ ] Expected: 
     - Search bar visible
     - Cart icon with badge showing (0) items
     - Wishlist icon visible
     - **Guest State:** "Login" button | "Sign Up" button
   - [ ] NOT Expected: User profile dropdown (should appear after login)

3. **Products Page**
   - [ ] Click: Products link or navigate to http://localhost/admagpro/products
   - [ ] Expected: Product listing page loads with product grid
   - [ ] Features: Category filters, price range slider, product cards
   - [ ] Check: No 404 errors

4. **Login Page**
   - [ ] Click: "Login" button in header
   - [ ] Navigate to: http://localhost/admagpro/login
   - [ ] Expected: Login form displays with:
     - Email input field
     - Password input field  
     - "Sign In" button
     - "Don't have an account? Sign Up" link
   - [ ] Check: Tailwind styling applied, form looks modern

5. **Registration Page**
   - [ ] Click: "Sign Up" button or link in header
   - [ ] Navigate to: http://localhost/admagpro/register
   - [ ] Expected: Registration form displays with:
     - Full Name input
     - Email input
     - Password input
     - Confirm Password input
     - "Create Account" button
   - [ ] Check: Password confirmation validation works

6. **Browser Console Check**
   - [ ] Press F12 to open DevTools
   - [ ] Go to Console tab
   - [ ] Expected: No red error messages
   - [ ] Note down any warnings (yellow) for later investigation

---

## Test 2: CUSTOMER PERSPECTIVE ✅ (API Token Authentication)

### Objective
Verify that customers can log in, access protected pages, and use account features. Authentication uses API tokens stored in localStorage, not sessions.

### Prerequisite
- Ensure you have valid test customer credentials
- Clear localStorage before testing: `localStorage.clear()` in console

### Test Steps

1. **Customer Login**
   - [ ] Navigate to: http://localhost/admagpro/login
   - [ ] Enter credentials:
     - Email: [Use test customer email from database]
     - Password: [Use test customer password]
   - [ ] Click "Sign In"
   - [ ] Expected: 
     - Redirected to homepage (/)
     - No errors in console
     - Page loads successfully
   
2. **Verify Token Saved**
   - [ ] Open DevTools (F12)
   - [ ] Go to Console tab
   - [ ] Type: `localStorage.getItem('auth_token')`
   - [ ] Expected: Long JWT token string appears (not null or empty)
   - [ ] Copy token for API testing if needed

3. **Header Update After Login**
   - [ ] Look at header section after login
   - [ ] Expected: Header now shows:
     - **User Menu** with:
       - ✓ Profile option
       - ✓ Orders option
       - ✓ Wallet option
       - ✓ Referrals option
       - ✓ Logout option
     - NOT showing: Generic "Login" and "Sign Up" buttons

4. **Cart Page**
   - [ ] Navigate to: http://localhost/admagpro/cart
   - [ ] Expected: Shopping cart page loads
   - [ ] Display: Empty cart message OR existing cart items
   - [ ] Cart count in header updates correctly
   - [ ] Check: No 404 errors

5. **Orders Page**
   - [ ] Navigate to: http://localhost/admagpro/orders
   - [ ] Expected: Order history page loads
   - [ ] Display: List of customer's orders OR "No orders yet" message
   - [ ] Features: Order ID, date, status, amount columns
   - [ ] Check: Orders load via API call (check Network tab)

6. **Wallet Page**
   - [ ] Navigate to: http://localhost/admagpro/wallet
   - [ ] Expected: Wallet/balance page loads
   - [ ] Display: Account balance, transaction history
   - [ ] Features: "Add Money" button, recent transactions list
   - [ ] Check: Balance loads from API

7. **Profile Page**
   - [ ] Navigate to: http://localhost/admagpro/profile
   - [ ] Expected: User profile page loads
   - [ ] Display: Customer information, account settings
   - [ ] Check: Data loads correctly

8. **Wishlist Page**
   - [ ] Navigate to: http://localhost/admagpro/wishlist
   - [ ] Expected: Wishlist page loads
   - [ ] Display: Saved products OR empty wishlist message
   - [ ] Check: No errors

9. **Customer Logout**
   - [ ] In header, click user menu → "Logout"
   - [ ] Expected:
     - Redirected to homepage
     - localStorage cleared (localStorage.getItem('auth_token') returns null)
     - Header reverts to "Login" / "Sign Up" buttons
   
10. **Verify Token Cleared**
    - [ ] Open DevTools (F12)
    - [ ] Go to Console tab
    - [ ] Type: `localStorage.getItem('auth_token')`
    - [ ] Expected: `null` (token is deleted)

11. **Try Accessing Protected Page Logged Out**
    - [ ] Navigate to: http://localhost/admagpro/cart
    - [ ] Expected: Page still loads (customer pages allow anonymous viewing)
    - [ ] Display: "Your cart is empty" message
    - [ ] Note: This is acceptable - API calls fail gracefully

---

## Test 3: ADMIN PERSPECTIVE ✅ (Session Authentication)

### Objective
Verify that administrators can log in to the admin panel and access admin-specific features. Admin authentication uses sessions, not API tokens.

### Prerequisite
- Ensure you have valid test admin credentials
- Admin uses different login page than customers

### Test Steps

1. **Admin Login Page**
   - [ ] Navigate to: http://localhost/admagpro/adminlogin
   - [ ] Expected: Different login form from customer login
   - [ ] Check: This is NOT the same as /login
   - [ ] Layout: Should show admin branding/messaging

2. **Admin Login**
   - [ ] Enter credentials:
     - Email/Username: [Use test admin credentials]
     - Password: [Use test admin password]
   - [ ] Click "Login"
   - [ ] Expected:
     - Redirected to admin dashboard
     - Session created (different from API token)
     - No console errors

3. **Admin Dashboard**
   - [ ] Check current URL
   - [ ] Expected: http://localhost/admagpro/home
   - [ ] Display: Admin dashboard with:
     - Statistics/analytics
     - User management options
     - System management links
   - [ ] Check: Admin can see admin-specific features

4. **Admin Routes Access**
   - [ ] Try accessing admin-specific routes:
     - [ ] http://localhost/admagpro/pending_kyc → Should display KYC management
     - [ ] http://localhost/admagpro/allfranchise → Should display franchises
     - [ ] http://localhost/admagpro/add_category → Should display category form
   - [ ] Expected: All routes work without 404 errors

5. **Admin Session Verification**
   - [ ] Open DevTools (F12)
   - [ ] Check: LocalStorage should NOT have 'auth_token' (session-based, not API)
   - [ ] Check: Application → Cookies → View server-side session cookies
   - [ ] Expected: Session cookie should exist (LARAVEL_SESSION or similar)

6. **Admin Logout**
   - [ ] Look for logout option
   - [ ] Click: "Logout" or "Admin Logout" link
   - [ ] Navigate to: http://localhost/admagpro/admin_logout
   - [ ] Expected:
     - Redirected to /adminlogin
     - Session cleared
     - Cannot access /home (admin dashboard) anymore

7. **Try Accessing Admin Routes After Logout**
   - [ ] Try: http://localhost/admagpro/home
   - [ ] Expected: Redirected to /adminlogin (not accessible without auth)
   - [ ] OR: Error/permission denied message

---

## Network/API Testing (Optional, for deep verification)

### Check API Calls in Customer Flow

1. **Open DevTools Network Tab**
   - [ ] F12 → Network tab
   - [ ] Reload page
   - [ ] Filter: XHR (XMLHttpRequest)

2. **Check Login API Call**
   - [ ] Go to /login and submit form
   - [ ] Expected API call:
     - **URL:** POST http://localhost/admagpro/api/v1/auth/login
     - **Status:** 200 OK
     - **Response:** Contains `token` field with JWT
     - **Headers:** Content-Type: application/json

3. **Check Cart API Call**
   - [ ] Go to /cart page
   - [ ] Expected API call:
     - **URL:** GET http://localhost/admagpro/api/v1/cart
     - **Status:** 200 OK OR 401 Unauthorized (if not logged in)
     - **Headers:** Authorization: Bearer [token]

4. **Check Orders API Call**
   - [ ] Go to /orders page
   - [ ] Expected API call:
     - **URL:** GET http://localhost/admagpro/api/v1/orders
     - **Status:** 200 OK OR 401 Unauthorized
     - **Response:** Array of customer orders

---

## Troubleshooting Guide

### Issue: Homepage shows 404 error
- **Check:** Verify routes/web.php has GET / → returns home.index view
- **Fix:** Run `php artisan route:clear`
- **Test:** Access http://localhost/admagpro/ directly

### Issue: Login page not loading (404)
- **Check:** Verify routes/web.php has GET /login → 'auth.login' view
- **Check:** Verify `resources/views/auth/login.blade.php` exists
- **Fix:** Run `php artisan view:clear`
- **Test:** Access http://localhost/admagpro/login directly

### Issue: Header not updating after login
- **Check:** Browser DevTools → Application tab → localStorage
- **Check:** Verify `auth_token` exists after login
- **Check:** Open browser console and see if JavaScript errors
- **Fix:** Clear browser cache (Ctrl+Shift+Delete)
- **Test:** Try another browser

### Issue: Admin dashboard not loading
- **Check:** Verify admin login credentials are correct
- **Check:** Verify session is created (check cookies)
- **Check:** Try accessing /home directly (should redirect to /adminlogin if not authenticated)
- **Fix:** Clear browser cookies for the domain

### Issue: API calls returning 401 Unauthorized
- **Check:** Verify token is saved in localStorage
- **Check:** Verify token is being sent in Authorization header
- **Fix:** Try logging out and logging back in
- **Check:** Verify `/api/v1/auth/login` endpoint is working

---

## Test Results Summary Template

```
VISITOR PERSPECTIVE:
- [ ] Homepage loads: ✓ / ✗
- [ ] Products page loads: ✓ / ✗
- [ ] Login page loads: ✓ / ✗
- [ ] Registration page loads: ✓ / ✗
- [ ] No console errors: ✓ / ✗
- [ ] Status: PASS / FAIL

CUSTOMER PERSPECTIVE:
- [ ] Can login with credentials: ✓ / ✗
- [ ] Token saved to localStorage: ✓ / ✗
- [ ] Header updates after login: ✓ / ✗
- [ ] Can access cart page: ✓ / ✗
- [ ] Can access orders page: ✓ / ✗
- [ ] Can access wallet page: ✓ / ✗
- [ ] Can logout successfully: ✓ / ✗
- [ ] Token cleared after logout: ✓ / ✗
- [ ] Status: PASS / FAIL

ADMIN PERSPECTIVE:
- [ ] Admin login page loads: ✓ / ✗
- [ ] Can login with admin credentials: ✓ / ✗
- [ ] Admin dashboard loads: ✓ / ✗
- [ ] Can access admin routes: ✓ / ✗
- [ ] Can logout successfully: ✓ / ✗
- [ ] Session cleared after logout: ✓ / ✗
- [ ] Status: PASS / FAIL
```

---

**Date:** Current Session
**Tester:** [Your Name]
**Environment:** Local / Production
**Browser:** [Chrome/Firefox/Safari/Edge]
