<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// ============================================================================
// ADMIN PANEL IMPORTS
// ============================================================================
use App\Http\Controllers\Admin\AdminLogin;
use App\Http\Controllers\Admin\AllFranchise;
use App\Http\Controllers\Admin\Banner\AddBanner;
use App\Http\Controllers\Admin\Users\CashbackUsers;
use App\Http\Controllers\Admin\Users\ProductUsers;
use App\Http\Controllers\Admin\Users\ServiceUsers;
use App\Http\Controllers\Admin\OrderedProducts\OrderedItems;
use App\Http\Controllers\Admin\Kyc\AcceptedKyc;
use App\Http\Controllers\Admin\Kyc\PendingKyc;
use App\Http\Controllers\Admin\Kyc\RejectedKyc;
use App\Http\Controllers\Admin\Withdrawals\AcceptedWithdrawal;
use App\Http\Controllers\Admin\Withdrawals\PendingWithdrawal;
use App\Http\Controllers\Admin\Withdrawals\RejectedWithdrawal;
use App\Http\Controllers\Admin\Stores\ApprovedStore;
use App\Http\Controllers\Admin\Stores\PendingStore;
use App\Http\Controllers\Admin\Stores\RejectedStore;
use App\Http\Controllers\Admin\Category\AddCategory;
use App\Http\Controllers\Admin\Brand\AddBrand;

// ============================================================================
// VENDOR & SERVICE PANEL IMPORTS
// ============================================================================
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\LoginController;

// ============================================================================
// PAYMENT & POLICY IMPORTS
// ============================================================================
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\Website_Policies\PolicyController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES DOCUMENTATION
|--------------------------------------------------------------------------
| 
| Route Organization:
| 1. PUBLIC PAGES - Accessible to all visitors
| 2. CUSTOMER ROUTES - Require API token (localStorage)
| 3. AUTH ROUTES - Login/Register pages
| 4. ADMIN ROUTES - Session-based admin authentication
| 5. VENDOR ROUTES - Session-based vendor authentication
| 6. SERVICE ROUTES - Session-based service provider authentication
| 7. POLICY & UTILITY ROUTES - Static pages
|
*/

// ============================================================================
// 1. PUBLIC PAGES & ERROR HANDLING
// ============================================================================

Route::view('error_page', 'error_page');
Route::view('blank', 'blank');

// Homepage redirect (handles both authenticated and guest users)
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('index');
    }
    return redirect()->route('welcome_page');
})->name('home');

// ============================================================================
// 2. CUSTOMER-FACING ROUTES (PUBLIC & AUTHENTICATED)
// ============================================================================
// NOTE: Authentication is API-based (localStorage token), not session-based
// These routes serve as page containers; actual data comes from /api/v1/*

Route::prefix('')->group(function () {

    // Product Browsing
    Route::get('products', function () {
        return view('products.index', ['products' => []]);
    })->name('products.index');

    Route::get('products/{id}', function ($id) {
        return redirect('/products');
    })->name('product.show');

    Route::get('search', function () {
        return view('products.index', ['products' => []]);
    })->name('search');

    // Customer Account Pages
    Route::get('cart', function () {
        return view('cart.index');
    })->name('cart');

    Route::get('orders', function () {
        return view('orders.index');
    })->name('orders');

    Route::get('wishlist', function () {
        return view('cart.index');
    })->name('wishlist');

    Route::get('referral', function () {
        return view('home.index');
    })->name('referral');

    Route::get('profile', function () {
        return view('home.index');
    })->name('profile');

    Route::get('wallet', function () {
        return view('wallet.index');
    })->name('wallet');
});

// ============================================================================
// 3. AUTHENTICATION ROUTES
// ============================================================================

Route::prefix('auth')->group(function () {
    Route::view('login', 'auth.login')->middleware('guest')->name('login');
    Route::view('register', 'auth.register')->middleware('guest')->name('register');
    Route::view('forgot-password', 'auth.forgot-password')->middleware('guest')->name('forgot-password');
});

// ============================================================================
// 4. ADMIN PANEL ROUTES
// ============================================================================
// Prefix: /admin
// Middleware: isAdminLogin (session-based)

Route::get('adminlogin', [AdminLogin::class, 'loginpage'])
    ->middleware('isAdminalreadyLogin')
    ->name('adminlogin');

Route::post('admin_login_submit', [AdminLogin::class, 'login_submit'])
    ->name('admin_login_submit');

Route::get('admin_logout', [AdminLogin::class, 'logout'])
    ->name('admin_logout');

Route::prefix('admin')->middleware('isAdminLogin')->group(function () {

    // Dashboard
    Route::get('dashboard', [AdminLogin::class, 'admin_dashboard'])->name('admin.dashboard');
    Route::get('profile', [PendingStore::class, 'admin_profile'])->name('admin.profile');

    // System Settings
    Route::get('pin-system', [AdminLogin::class, 'pin_system'])->name('admin.pin_system');
    Route::post('pin-system-activate', [AdminLogin::class, 'pin_system_activation'])->name('admin.pin_system_activation');
    Route::get('admin-id-activation', [AdminLogin::class, 'admin_id_activation'])->name('admin.admin_id_activation');
    Route::post('admin-id-activate', [AdminLogin::class, 'admin_id_activation'])->name('admin.admin_id_activate');

    // Settlement Routes
    Route::get('backtwoback-settle', [AdminLogin::class, 'backtwoback_settle'])->name('admin.backtwoback_settle');
    Route::get('pool-settle', [AdminLogin::class, 'pool_amount_settle'])->name('admin.pool_amount_settle');
    Route::get('product-wallet-conversion', [AdminLogin::class, 'product_wallet_convertion'])->name('admin.product_wallet_convertion');
    Route::get('back2back-to-wallet/{user_id}', [AdminLogin::class, 'back2back_to_product_wallet'])->name('admin.back2back_to_product_wallet');

    // Franchises
    Route::get('franchises', [AllFranchise::class, 'index'])->name('admin.franchises');
    Route::get('franchises/active', [AllFranchise::class, 'active_franchise'])->name('admin.franchises.active');
    Route::get('franchises/inactive', [AllFranchise::class, 'inactive_franchise'])->name('admin.franchises.inactive');

    // Users Management
    Route::get('users', [CashbackUsers::class, 'cash_back_users'])->name('admin.users');
    Route::get('users/active', [CashbackUsers::class, 'active_users'])->name('admin.users.active');
    Route::get('users/products', [ProductUsers::class, 'product_users'])->name('admin.users.products');
    Route::get('users/services', [ServiceUsers::class, 'service_users'])->name('admin.users.services');
    Route::get('users/upgrade-level/{user_id}', [CashbackUsers::class, 'upgrade_user_percentage'])->name('admin.users.upgrade_level');
    Route::post('users/upgrade-level-submit', [CashbackUsers::class, 'upgrade_user_percentage_submit'])->name('admin.users.upgrade_level_submit');

    // KYC Management
    Route::get('kyc/pending', [PendingKyc::class, 'pending_kyc'])->name('admin.kyc.pending');
    Route::get('kyc/accepted', [AcceptedKyc::class, 'accepted_kyc'])->name('admin.kyc.accepted');
    Route::get('kyc/rejected', [RejectedKyc::class, 'rejected_kyc'])->name('admin.kyc.rejected');

    // Withdrawal Management
    Route::get('withdrawals/pending', [PendingWithdrawal::class, 'pending_withdrawal'])->name('admin.withdrawals.pending');
    Route::get('withdrawals/vendor-pending', [PendingWithdrawal::class, 'vendor_pending_withdrawal'])->name('admin.withdrawals.vendor_pending');
    Route::get('withdrawals/accepted', [AcceptedWithdrawal::class, 'accepted_withdrawal'])->name('admin.withdrawals.accepted');
    Route::get('withdrawals/rejected', [RejectedWithdrawal::class, 'rejected_withdrawal'])->name('admin.withdrawals.rejected');
    Route::get('withdrawals/update/{user_id}', [PendingWithdrawal::class, 'update_withdrawal_request'])->name('admin.withdrawals.update');
    Route::get('withdrawals/vendor-update/{user_id}', [PendingWithdrawal::class, 'update_vendor_withdrawal_request'])->name('admin.withdrawals.vendor_update');
    Route::post('withdrawals/status-update', [PendingWithdrawal::class, 'update_user_withdrawal_status'])->name('admin.withdrawals.status_update');

    // Stores Management
    Route::get('stores/approved', [ApprovedStore::class, 'approved_stores'])->name('admin.stores.approved');
    Route::get('stores/pending', [PendingStore::class, 'pending_stores'])->name('admin.stores.pending');
    Route::get('stores/rejected', [RejectedStore::class, 'rejected_stores'])->name('admin.stores.rejected');
    Route::get('stores/discount-vendors', [PendingStore::class, 'discount_vendors'])->name('admin.stores.discount_vendors');
    Route::get('stores/update-status/{vendor_id}', [PendingStore::class, 'update_status'])->name('admin.stores.update_status');
    Route::post('stores/update-status-submit', [PendingStore::class, 'updated_new_one'])->name('admin.stores.update_status_submit');
    Route::get('stores/business-service/{user_id}', [AddBrand::class, 'classified_business_service'])->name('admin.stores.business_service');

    // Products Management
    Route::get('products/ordered', [OrderedItems::class, 'delivered_products'])->name('admin.products.ordered');
    Route::get('products/shipping', [OrderedItems::class, 'shipping_products'])->name('admin.products.shipping');
    Route::get('products/packaging', [OrderedItems::class, 'packaging_products'])->name('admin.products.packaging');
    Route::post('products/activate-id', [AdminLogin::class, 'activate_id_in_products'])->name('admin.products.activate_id');

    // Categories Management
    Route::get('categories', [AddCategory::class, 'category_list'])->name('admin.categories');
    Route::get('categories/add', [AddCategory::class, 'add_category'])->name('admin.categories.add');
    Route::get('categories/edit/{category_id}', [AddCategory::class, 'category_update_admin'])->name('admin.categories.edit');
    Route::post('categories/update', [AddCategory::class, 'category_update_admin_submit'])->name('admin.categories.update');

    // Brands Management
    Route::get('brands', [AddBrand::class, 'brand_list'])->name('admin.brands');
    Route::get('brands/add', [AddBrand::class, 'add_brand'])->name('admin.brands.add');
    Route::post('brands/add-submit', [AddBrand::class, 'new_brand_added'])->name('admin.brands.add_submit');
    Route::get('brands/edit/{brand_id}', [AddBrand::class, 'brand_update_admin'])->name('admin.brands.edit');
    Route::post('brands/update', [AddBrand::class, 'brand_update_admin_submit'])->name('admin.brands.update');

    // Services Management
    Route::get('services', [AddBrand::class, 'service_list'])->name('admin.services');
    Route::get('services/add', [AddBrand::class, 'add_service'])->name('admin.services.add');
    Route::post('services/add-submit', [AddBrand::class, 'new_service_added'])->name('admin.services.add_submit');
    Route::get('services/edit/{service_id}', [AddBrand::class, 'service_update_admin'])->name('admin.services.edit');
    Route::post('services/update', [AddBrand::class, 'service_update_admin_submit'])->name('admin.services.update');
    Route::get('services/delete/{service_id}', [AddBrand::class, 'service_delete_admin'])->name('admin.services.delete');

    // Classified Ads Management
    Route::get('classified', [AddBrand::class, 'classified_list'])->name('admin.classified');
    Route::get('classified/add', [AddBrand::class, 'add_classified'])->name('admin.classified.add');
    Route::post('classified/add-submit', [AddBrand::class, 'new_classified_added'])->name('admin.classified.add_submit');
    Route::get('classified/edit/{service_id}', [AddBrand::class, 'classified_update_admin'])->name('admin.classified.edit');
    Route::post('classified/update', [AddBrand::class, 'classified_update_admin_submit'])->name('admin.classified.update');
    Route::get('classified/delete/{service_id}', [AddBrand::class, 'classified_delete_admin'])->name('admin.classified.delete');

    // Stores Listings Management
    Route::get('store-listings', [AddBrand::class, 'store_list'])->name('admin.store_listings');
    Route::get('store-listings/add', [AddBrand::class, 'add_store'])->name('admin.store_listings.add');
    Route::post('store-listings/add-submit', [AddBrand::class, 'new_store_added'])->name('admin.store_listings.add_submit');
    Route::get('store-listings/edit/{store_id}', [AddBrand::class, 'store_update_admin'])->name('admin.store_listings.edit');
    Route::post('store-listings/update', [AddBrand::class, 'store_update_admin_submit'])->name('admin.store_listings.update');
    Route::get('store-listings/delete/{store_id}', [AddBrand::class, 'store_delete_admin'])->name('admin.store_listings.delete');
    Route::get('store-listings/business/{user_id}', [AddBrand::class, 'classified_business_service'])->name('admin.store_listings.business');
    Route::get('store-listings/status/{id}', [AddBrand::class, 'business_listing_status_update'])->name('admin.store_listings.status');
    Route::post('store-listings/status-update', [AddBrand::class, 'business_listing_status_update_submit'])->name('admin.store_listings.status_update');
    Route::get('store-listings/id-activation/{id}', [AddBrand::class, 'id_activation_update'])->name('admin.store_listings.id_activation');
    Route::post('store-listings/id-activation-submit', [AddBrand::class, 'status_update_id_active_submit'])->name('admin.store_listings.id_activation_submit');

    // Banners Management
    Route::get('banners', [AddBanner::class, 'banner_list'])->name('admin.banners');
    Route::get('banners/add', [AddBanner::class, 'add_banner'])->name('admin.banners.add');
    Route::post('banners/add-submit', [AddBanner::class, 'new_banner_added'])->name('admin.banners.add_submit');
    Route::get('banners/edit/{banner_id}', [AddBanner::class, 'update_bannner'])->name('admin.banners.edit');
    Route::post('banners/update', [AddBanner::class, 'update_banner'])->name('admin.banners.update');

    // Gallery Management
    Route::get('galleries', [AddBanner::class, 'gallery_list'])->name('admin.galleries');
    Route::get('galleries/add', [AddBanner::class, 'add_gallery'])->name('admin.galleries.add');
    Route::post('galleries/add-submit', [AddBanner::class, 'new_gallery_added'])->name('admin.galleries.add_submit');
    Route::get('galleries/edit/{gallery_id}', [AddBanner::class, 'update_gallery'])->name('admin.galleries.edit');
    Route::post('galleries/update', [AddBanner::class, 'update_gallery_submit'])->name('admin.galleries.update');

    // Gadget Gallery Management
    Route::get('gadget-galleries', [AddBanner::class, 'gadget_gallery_list'])->name('admin.gadget_galleries');
    Route::get('gadget-galleries/add', [AddBanner::class, 'add_gadget_gallery'])->name('admin.gadget_galleries.add');
    Route::post('gadget-galleries/add-submit', [AddBanner::class, 'new_gadget_gallery_added'])->name('admin.gadget_galleries.add_submit');
    Route::get('gadget-galleries/edit/{gallery_id}', [AddBanner::class, 'update_gadget_gallery'])->name('admin.gadget_galleries.edit');
    Route::post('gadget-galleries/update', [AddBanner::class, 'update_gadget_gallery_submit'])->name('admin.gadget_galleries.update');

    // Store Images Management
    Route::get('store-images', [AddBanner::class, 'store_images_list'])->name('admin.store_images');
    Route::get('store-images/add', [AddBanner::class, 'add_store_image'])->name('admin.store_images.add');
    Route::post('store-images/add-submit', [AddBanner::class, 'new_store_image_added'])->name('admin.store_images.add_submit');
    Route::get('store-images/edit/{gallery_id}', [AddBanner::class, 'update_store_gallery'])->name('admin.store_images.edit');
    Route::post('store-images/update', [AddBanner::class, 'update_store_gallery_submit'])->name('admin.store_images.update');

    // Ads Banner Management
    Route::get('ads-banners', [AddBanner::class, 'ads_banner'])->name('admin.ads_banners');
    Route::get('ads-banners/add', [AddBanner::class, 'add_ads_banner'])->name('admin.ads_banners.add');
    Route::post('ads-banners/add-submit', [AddBanner::class, 'new_ads_banner_image_added'])->name('admin.ads_banners.add_submit');
    Route::get('ads-banners/edit/{gallery_id}', [AddBanner::class, 'update_adsbanner_gallery'])->name('admin.ads_banners.edit');
    Route::post('ads-banners/update', [AddBanner::class, 'update_ads_banner_gallery_submit'])->name('admin.ads_banners.update');

    // Home Headings Management
    Route::get('headings', [AddBanner::class, 'home_heading_list'])->name('admin.headings');
    Route::get('headings/add', [AddBanner::class, 'home_heading_name'])->name('admin.headings.add');
    Route::post('headings/add-submit', [AddBanner::class, 'new_home_heading_add'])->name('admin.headings.add_submit');
    Route::get('headings/edit/{heading_id}', [AddBanner::class, 'update_heading_name'])->name('admin.headings.edit');
    Route::post('headings/update', [AddBanner::class, 'update_home_heading_submit'])->name('admin.headings.update');

    // Events Banners Management
    Route::get('events-banners', [AddBanner::class, 'events_banner'])->name('admin.events_banners');
    Route::get('events-banners/add', [AddBanner::class, 'add_events_banner'])->name('admin.events_banners.add');
    Route::post('events-banners/add-submit', [AddBanner::class, 'new_events_banner_image_added'])->name('admin.events_banners.add_submit');
    Route::get('events-banners/edit/{gallery_id}', [AddBanner::class, 'update_eventsbanner_gallery'])->name('admin.events_banners.edit');
    Route::post('events-banners/update', [AddBanner::class, 'update_events_banner_gallery_submit'])->name('admin.events_banners.update');
});

// ============================================================================
// 5. VENDOR PANEL ROUTES
// ============================================================================
// Prefix: /vendor
// Middleware: isVendorLogin (session-based)

Route::get('login', [LoginController::class, 'login'])
    ->middleware('isVendoralreadyLogin')
    ->name('vendor.login');

Route::post('login_submit', [LoginController::class, 'login_submit'])
    ->name('vendor.login_submit');

Route::get('vendor_register/{referal?}', [LoginController::class, 'sign_up'])
    ->middleware('isVendoralreadyLogin')
    ->name('vendor.register');

Route::post('vendor_register', [VendorController::class, 'vendor_register_submit'])
    ->name('vendor.register_submit');

Route::get('vendor_logout', [VendorController::class, 'logout'])
    ->name('vendor.logout');

Route::prefix('vendor')->middleware('isVendorLogin')->group(function () {
    Route::get('dashboard', [VendorController::class, 'vendor_dashboard'])->name('vendor.dashboard');
    Route::get('banner', [VendorController::class, 'vendor_banner'])->name('vendor.banner');
    // Add more vendor routes as needed
});

// ============================================================================
// 6. SERVICE PROVIDER PANEL ROUTES
// ============================================================================

Route::prefix('service')->middleware('isServiceLogin')->group(function () {
    Route::get('dashboard', [ServiceController::class, 'service_dashboard'])->name('service.dashboard');
    // Add service provider routes as needed
});

// ============================================================================
// 7. POLICY & UTILITY ROUTES
// ============================================================================

Route::prefix('policy')->group(function () {
    Route::get('privacy', [PolicyController::class, 'privacy'])->name('policy.privacy');
    Route::get('terms', [PolicyController::class, 'terms'])->name('policy.terms');
    Route::get('refund', [PolicyController::class, 'refund'])->name('policy.refund');
});

// ============================================================================
// 8. PAYMENT ROUTES
// ============================================================================

Route::prefix('payment')->group(function () {
    Route::post('razorpay/create', [RazorpayController::class, 'create'])->name('payment.razorpay.create');
    Route::post('razorpay/verify', [RazorpayController::class, 'verify'])->name('payment.razorpay.verify');
});

// ============================================================================
// FALLBACK ROUTES
// ============================================================================
// These should be at the end to avoid conflicts

// Catch undefined routes and show 404
Route::fallback(function () {
    return response()->view('error_page', [], 404);
});
