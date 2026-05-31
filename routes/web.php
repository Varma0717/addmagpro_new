<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\AllFranchise;
use App\Http\Controllers\Admin\AdminLogin;
use App\Http\Controllers\Admin\Banner\AddBanner;
use App\Http\Controllers\Admin\Users\CashbackUsers;
use App\Http\Controllers\Admin\OrderedProducts\OrderedItems;
use App\Http\Controllers\Admin\Users\ProductUsers;
use App\Http\Controllers\Admin\Users\ServiceUsers;
use App\Http\Controllers\Admin\Kyc\AcceptedKyc;
use App\Http\Controllers\Admin\Kyc\PendingKyc;
use App\Http\Controllers\Admin\Kyc\RejectedKyc;
use App\Http\Controllers\Admin\Withdrawals\AcceptedWithdrawal;
use App\Http\Controllers\Admin\Withdrawals\RejectedWithdrawal;
use App\Http\Controllers\Admin\Withdrawals\PendingWithdrawal;
use App\Http\Controllers\Admin\Stores\ApprovedStore;
use App\Http\Controllers\Admin\Stores\PendingStore;
use App\Http\Controllers\Admin\Stores\RejectedStore;
use App\Http\Controllers\Admin\Category\AddCategory;
use App\Http\Controllers\Admin\Brand\AddBrand;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Website_Policies\PolicyController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\RazorpayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| ROOT & ERROR PAGES
|--------------------------------------------------------------------------
*/

Route::view('error_page', 'error_page');
Route::view('blank', 'blank');

/*
|--------------------------------------------------------------------------
| CUSTOMER-FACING ROUTES (PUBLIC & AUTHENTICATED)
|--------------------------------------------------------------------------
| These routes are for regular customers and visitors
| Authentication: API-based (localStorage token), not session
*/

// Homepage - accessible to all visitors and customers
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('index');
    } else {
        return redirect()->route('welcome_page');
    }
});

// Product Browsing - Use /products_list instead

// Customer Dashboard Pages (require API auth via localStorage token)
Route::get('/cart', function () {
    return view('cart.index');
})->name('cart');

Route::get('/orders', function () {
    return view('orders.index');
})->name('orders');

Route::get('/wishlist', function () {
    return view('cart.index');
})->name('wishlist');

Route::get('/referral', function () {
    return view('home.index');
})->name('referral');

Route::get('/profile', function () {
    return view('home.index');
})->name('profile');

// Customer Authentication (no session, API-based)
// These views handle login/register via fetch to /api/v1/auth/*
Route::view('/login', 'auth.login')->middleware('guest')->name('login');
Route::view('/register', 'auth.register')->middleware('guest')->name('register');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
| Session-based authentication for admin users
| Access: /adminlogin for login, /home for dashboard
*/
Route::group(['middleware' => ['isAdminLogin']], function () {
    Route::get('pending_kyc', [PendingKyc::class, 'pending_kyc'])->name('pending_kyc');
    // Route::view('home','admin_pages.index')->name('home');
    Route::get('home', [AdminLogin::class, 'admin_dashboard'])->name('home');
    Route::get('backtwoback_settle', [AdminLogin::class, 'backtwoback_settle'])->name('backtwoback_settle');
    Route::get('pool_amount_settle', [AdminLogin::class, 'pool_amount_settle'])->name('pool_amount_settle');
    Route::get('admin_id_activation', [AdminLogin::class, 'admin_id_activation'])->name('admin_id_activation');
    Route::post('pin_system_activation', [AdminLogin::class, 'pin_system_activation'])->name('pin_system_activation');
    Route::get('pin_system', [AdminLogin::class, 'pin_system'])->name('pin_system');
    Route::get('backtwoback_amount_settle', [AdminLogin::class, 'backtwoback_amount_settle'])->name('backtwoback_amount_settle');
    Route::get('pool_amount_settle_activate', [AdminLogin::class, 'pool_amount_settle_activate'])->name('pool_amount_settle_activate');
    Route::get('allfranchise', [AllFranchise::class, 'index'])->name('allfranchise');
    Route::get('activefranchise', [AllFranchise::class, 'active_franchise'])->name('activefranchise');
    Route::get('product_wallet_convertion', [AdminLogin::class, 'product_wallet_convertion'])->name('product_wallet_convertion');
    Route::get('back2back_to_product_wallet/{user_id}', [AdminLogin::class, 'back2back_to_product_wallet'])->name('back2back_to_product_wallet');
    Route::get('inactivefranchise', [AllFranchise::class, 'inactive_franchise'])->name('inactivefranchise');
    Route::get('visitors', [CashbackUsers::class, 'cash_back_users'])->name('cashbackusers');
    Route::get('active_users', [CashbackUsers::class, 'active_users'])->name('active_users');
    Route::get('upgrade_user_percentage_level/{user_id}', [CashbackUsers::class, 'upgrade_user_percentage'])->name('upgrade_user_percentage_level');
    Route::post('upgrade_user_percentage_submit', [CashbackUsers::class, 'upgrade_user_percentage_submit'])->name('upgrade_user_percentage_submit');
    Route::get('productusers', [ProductUsers::class, 'product_users'])->name('productusers');
    Route::get('serviceusers', [ServiceUsers::class, 'service_users'])->name('serviceusers');
    Route::get('accepted_kyc', [AcceptedKyc::class, 'accepted_kyc'])->name('accepted_kyc');
    Route::get('rejected_kyc', [RejectedKyc::class, 'rejected_kyc'])->name('rejected_kyc');
    Route::get('update_withdrawal_request/{user_id}', [PendingWithdrawal::class, 'update_withdrawal_request'])->name('update_withdrawal_request');
    Route::get('update_vendor_withdrawal_request/{user_id}', [PendingWithdrawal::class, 'update_vendor_withdrawal_request'])->name('update_vendor_withdrawal_request');
    Route::post('update_user_withdrawal_status', [PendingWithdrawal::class, 'update_user_withdrawal_status'])->name('update_user_withdrawal_status');
    Route::get('pending_withdrawal', [PendingWithdrawal::class, 'pending_withdrawal'])->name('pending_withdrawal');
    Route::get('vendor_pending_withdrawal', [PendingWithdrawal::class, 'vendor_pending_withdrawal'])->name('vendor_pending_withdrawal');
    Route::get('accepted_withdrawal', [AcceptedWithdrawal::class, 'accepted_withdrawal'])->name('accepted_withdrawal');
    Route::get('rejected_withdrawal', [RejectedWithdrawal::class, 'rejected_withdrawal'])->name('rejected_withdrawal');
    Route::get('approvedstores', [ApprovedStore::class, 'approved_stores'])->name('approvedstores');
    Route::get('pendingstores', [PendingStore::class, 'pending_stores'])->name('pendingstores');
    Route::get('discount_vendors', [PendingStore::class, 'discount_vendors'])->name('discount_vendors');
    Route::get('rejectedstores', [RejectedStore::class, 'rejected_stores'])->name('rejectedstores');
    Route::get('update_status/{vendor_id}', [PendingStore::class, 'update_status'])->name('update_status');
    Route::post('updated_new_one', [PendingStore::class, 'updated_new_one'])->name('updated_new_one');
    Route::get('admin_profile', [PendingStore::class, 'admin_profile'])->name('admin_profile');
    Route::get('add_category', [AddCategory::class, 'add_category'])->name('add_category');
    Route::get('category_list', [AddCategory::class, 'category_list'])->name('category_list');
    // Route::post('new_category_added',[AddCategory::class,'new_category_added'])->name('new_category_added');
    Route::post('new_brand_added', [AddBrand::class, 'new_brand_added'])->name('new_brand_added');
    Route::get('delivered_products', [OrderedItems::class, 'delivered_products'])->name('delivered_products');
    Route::get('shipping_products', [OrderedItems::class, 'shipping_products'])->name('shipping_products');
    Route::get('packaging_products', [OrderedItems::class, 'packaging_products'])->name('packaging_products');
    Route::get('add_brand', [AddBrand::class, 'add_brand'])->name('add_brand');
    Route::get('brand_list', [AddBrand::class, 'brand_list'])->name('brand_list');
    Route::get('add_service', [AddBrand::class, 'add_service'])->name('add_service');
    Route::get('add_classified', [AddBrand::class, 'add_classified'])->name('add_classified');
    Route::get('add_store', [AddBrand::class, 'add_store'])->name('add_store');
    Route::post('new_service_added', [AddBrand::class, 'new_service_added'])->name('new_service_added');
    Route::post('new_classified_added', [AddBrand::class, 'new_classified_added'])->name('new_classified_added');
    Route::post('new_store_added', [AddBrand::class, 'new_store_added'])->name('new_store_added');
    Route::get('service_list', [AddBrand::class, 'service_list'])->name('service_list');
    Route::get('classified_list', [AddBrand::class, 'classified_list'])->name('classified_list');
    Route::get('store_list', [AddBrand::class, 'store_list'])->name('store_list');
    Route::get('service_update_admin_get/{service_id}', [AddBrand::class, 'service_update_admin'])->name('service_update_admin_get');
    Route::get('service_delete_admin_get/{service_id}', [AddBrand::class, 'service_delete_admin'])->name('service_delete_admin_get');
    Route::get('classified_update_admin_get/{service_id}', [AddBrand::class, 'classified_update_admin'])->name('classified_update_admin_get');
    Route::get('classified_delete_admin_get/{service_id}', [AddBrand::class, 'classified_delete_admin'])->name('classified_delete_admin_get');
    Route::get('store_update_admin_get/{store_id}', [AddBrand::class, 'store_update_admin'])->name('store_update_admin_get');
    Route::get('store_delete_admin_get/{store_id}', [AddBrand::class, 'store_delete_admin'])->name('store_delete_admin_get');
    Route::get('category_update_admin/{category_id}', [AddCategory::class, 'category_update_admin'])->name('category_update_admin');
    Route::get('brand_update_admin_get/{brand_id}', [AddBrand::class, 'brand_update_admin'])->name('brand_update_admin_get');
    Route::post('service_update_admin', [AddBrand::class, 'service_update_admin_submit'])->name('service_update_admin');
    Route::post('classified_update_admin', [AddBrand::class, 'classified_update_admin_submit'])->name('classified_update_admin');
    Route::post('store_update_admin', [AddBrand::class, 'store_update_admin_submit'])->name('store_update_admin');
    Route::post('category_update_admin', [AddCategory::class, 'category_update_admin_submit'])->name('category_update_admin_submit');
    Route::post('brand_update_admin', [AddBrand::class, 'brand_update_admin_submit'])->name('brand_update_admin');
    Route::get('id_activation_update/{id}', [AddBrand::class, 'id_activation_update'])->name('id_activation_update');
    Route::get('business_listing_status_update/{id}', [AddBrand::class, 'business_listing_status_update'])->name('business_listing_status_update');
    Route::post('business_listing_status_update_submit', [AddBrand::class, 'business_listing_status_update_submit'])->name('business_listing_status_update_submit');
    Route::post('status_update_id_active_submit', [AddBrand::class, 'status_update_id_active_submit'])->name('status_update_id_active_submit');
    Route::get('classified_business_service/{user_id}', [AddBrand::class, 'classified_business_service'])->name('classified_business_service');
    Route::get('add_banner', [AddBanner::class, 'add_banner'])->name('add_banner');
    Route::get('add_gallery', [AddBanner::class, 'add_gallery'])->name('add_gallery');
    Route::get('add_gadget_gallery', [AddBanner::class, 'add_gadget_gallery'])->name('add_gadget_gallery');
    Route::get('add_store_image', [AddBanner::class, 'add_store_image'])->name('add_store_image');
    Route::get('add_ads_banner', [AddBanner::class, 'add_ads_banner'])->name('add_ads_banner');
    Route::get('add_events_banner', [AddBanner::class, 'add_events_banner'])->name('add_events_banner');
    Route::get('events_banner', [AddBanner::class, 'events_banner'])->name('events_banner');
    Route::post('update_events_banner_gallery_submit', [AddBanner::class, 'update_events_banner_gallery_submit'])->name('update_events_banner_gallery_submit');
    Route::get('update_eventsbanner_gallery/{gallery_id}', [AddBanner::class, 'update_eventsbanner_gallery'])->name('update_eventsbanner_gallery');
    Route::post('new_events_banner_image_added', [AddBanner::class, 'new_events_banner_image_added'])->name('new_eventsbanner_image_added');
    Route::post('activate_id_in_products', [AdminLogin::class, 'activate_id_in_products'])->name('activate_id_in_products');
    Route::get('home_heading_name', [AddBanner::class, 'home_heading_name'])->name('home_heading_name');
    // Route::post('new_banner_added',[AddBanner::class,'new_banner_added']);
    Route::post('new_banner_added', [AddBanner::class, 'new_banner_added'])->name('new_banner_added');
    Route::post('new_gallery_added', [AddBanner::class, 'new_gallery_added'])->name('new_gallery_added');
    Route::post('new_gadget_gallery_added', [AddBanner::class, 'new_gadget_gallery_added'])->name('new_gadget_gallery_added');
    Route::post('new_store_image_added', [AddBanner::class, 'new_store_image_added'])->name('new_store_image_added');
    Route::post('new_ads_banner_image_added', [AddBanner::class, 'new_ads_banner_image_added'])->name('new_adsbanner_image_added');
    Route::post('new_home_heading_add', [AddBanner::class, 'new_home_heading_add'])->name('new_home_heading_add');
    Route::get('banner_list', [AddBanner::class, 'banner_list'])->name('banner_list');
    Route::get('gallery_list', [AddBanner::class, 'gallery_list'])->name('gallery_list');
    Route::get('gadget_gallery_list', [AddBanner::class, 'gadget_gallery_list'])->name('gadget_gallery_list');
    Route::get('store_images_list', [AddBanner::class, 'store_images_list'])->name('store_images_list');
    Route::get('ads_banner', [AddBanner::class, 'ads_banner'])->name('ads_banner');
    Route::get('home_heading_list', [AddBanner::class, 'home_heading_list'])->name('home_heading_list');
    Route::get('update_bannner/{banner_id}', [AddBanner::class, 'update_bannner'])->name('update_bannner');
    Route::get('update_gallery/{gallery_id}', [AddBanner::class, 'update_gallery'])->name('update_gallery');
    Route::get('update_gadget_gallery/{gallery_id}', [AddBanner::class, 'update_gadget_gallery'])->name('update_gadget_gallery');
    Route::get('update_store_gallery/{gallery_id}', [AddBanner::class, 'update_store_gallery'])->name('update_store_gallery');
    Route::get('update_adsbanner_gallery/{gallery_id}', [AddBanner::class, 'update_adsbanner_gallery'])->name('update_adsbanner_gallery');
    Route::get('update_heading_name/{heading_id}', [AddBanner::class, 'update_heading_name'])->name('update_heading_name');
    Route::post('update_banner', [AddBanner::class, 'update_banner'])->name('update_banner');
    Route::post('update_gallery_submit', [AddBanner::class, 'update_gallery_submit'])->name('update_gallery_submit');
    Route::post('update_gadget_gallery_submit', [AddBanner::class, 'update_gadget_gallery_submit'])->name('update_gadget_gallery_submit');
    Route::post('update_store_gallery_submit', [AddBanner::class, 'update_store_gallery_submit'])->name('update_store_gallery_submit');
    Route::post('update_ads_banner_gallery_submit', [AddBanner::class, 'update_ads_banner_gallery_submit'])->name('update_ads_banner_gallery_submit');
    Route::post('update_home_heading_submit', [AddBanner::class, 'update_home_heading_submit'])->name('update_home_heading_submit');
});


Route::get('adminlogin', [AdminLogin::class, 'loginpage'])->middleware(['isAdminalreadyLogin'])->name('adminlogin');
Route::post('admin_login_submit', [AdminLogin::class, 'login_submit'])->name('admin_login_submit');

Route::get('admin_logout', [AdminLogin::class, 'logout'])->name('admin_logout');

/*
|--------------------------------------------------------------------------
| VENDOR PANEL
|--------------------------------------------------------------------------
| Session-based authentication for vendor users
| Access: /login for vendor login, /register for vendor registration
*/

Route::get('vendor_logout', [VendorController::class, 'logout'])->name('vendor_logout');

Route::get('login', [LoginController::class, 'login'])->middleware(['isVendoralreadyLogin'])->name('login');
Route::post('login_submit', [LoginController::class, 'login_submit']);
Route::get('vendor_register/{referal?}', [LoginController::class, 'sign_up'])->middleware(['isVendoralreadyLogin'])->name('vendor_register');
Route::post('vendor_register', [VendorController::class, 'vendor_register_submit'])->name('vendor_register_submit');

//Vendors Dashboard

Route::group(['middleware' => ['isVendorLogin']], function () {
    Route::get('vendor_dashboard', [VendorController::class, 'vendor_dashboard'])->name('vendor_dashboard');
    Route::get('vendor_banner', [VendorController::class, 'vendor_banner'])->name('vendor_banner');
    Route::get('vendor_new_category', [VendorController::class, 'vendor_new_category'])->name('vendor_new_category');
    Route::post('new_category_added', [AddCategory::class, 'new_category_added'])->name('new_category_added');
    Route::get('vendor_category_list', [VendorController::class, 'vendor_category_list'])->name('vendor_category_list');
    Route::get('vendor_new_brand', [VendorController::class, 'vendor_new_brand'])->name('vendor_new_brand');
    Route::get('vendor_brand_list', [VendorController::class, 'vendor_brand_list'])->name('vendor_brand_list');
    Route::post('add_new_brand', [VendorController::class, 'add_new_brand']);
    Route::get('vendor_order_list', [VendorController::class, 'vendor_order_list'])->name('vendor_order_list');
    Route::get('products_list_vendor', [VendorController::class, 'products_list'])->name('products_list_vendors');
    Route::get('vendor_category_update/{category_id}', [VendorController::class, 'vendor_category_update'])->name('vendor_category_update');
    Route::get('vendor_banner_update/{vendor_id}', [VendorController::class, 'vendor_banner_update'])->name('vendor_banner_update');
    Route::post('vendor_category_update', [VendorController::class, 'vendor_category_update_submit'])->name('vendor_category_update_submit');
    Route::post('vendor_banner_update_modify', [VendorController::class, 'vendor_banner_update_modify'])->name('vendor_banner_update_modify');
    Route::get('vendor_category_delete/{id}', [VendorController::class, 'vendor_category_delete'])->name('vendor_category_delete');
    Route::get('vendor_brand_update/{brand_id}', [VendorController::class, 'vendor_brand_update'])->name('vendor_brand_update');
    Route::post('vendor_brand_update', [VendorController::class, 'vendor_brand_update_submit'])->name('vendor_brand_update_submit');
    Route::get('vendor_brand_delete/{brand_id}', [VendorController::class, 'vendor_brand_delete'])->name('vendor_brand_delete');
    Route::view('category_update', 'vendor_pages.category_update');
    Route::get('vendor_settings', [VendorController::class, 'vendor_settings'])->name('vendor_settings');
    Route::post('vendor_settings_update', [VendorController::class, 'vendor_settings_update'])->name('vendor_settings_update');
    Route::get('vendor_profile', [VendorController::class, 'vendor_profile'])->name('vendor_profile');
    Route::get('new_product', [VendorController::class, 'new_product'])->name('new_product');
    Route::post('new_product_submit', [VendorController::class, 'new_product_submit'])->name('new_product_submit');
    Route::get('product_delete/{product_id}', [VendorController::class, 'product_delete'])->name('product_delete');
    Route::get('product_update/{product_id}', [VendorController::class, 'product_update'])->name('product_update');
    Route::post('product_update_submit', [VendorController::class, 'product_update_submit'])->name('product_update_submit');
    Route::post('change_password', [VendorController::class, 'change_password'])->name('vendor_change_password_submit');
});


//Service Users

/*
|--------------------------------------------------------------------------
| SERVICE USER & CUSTOMER LOGIN PANEL
|--------------------------------------------------------------------------
| Single unified login for all frontend users (customers and service users)
| Session-based authentication
| Access: /index for login, /service_user_registration for registration
*/

Route::get('change_password', [AdminLogin::class, 'change_password'])->name('change_password');

Route::get('index', [ServiceController::class, 'landing_page'])->middleware('isServicealreadyLogin')->name('landingpage');
Route::post('landing_page', [ServiceController::class, 'landing_page_submit'])->name('landing_page');
Route::get('service_user_registration/{referal?}', [ServiceController::class, 'service_user_registration'])->name('service_user_registration');
Route::post('service_user_registration', [ServiceController::class, 'service_registration_submit'])->name('service_user_registration_submit');
Route::get('service_user_logout', [ServiceController::class, 'service_user_logout'])->name('service_user_logout');
Route::get('welcome_page', [ServiceController::class, 'welcome_page'])->name('welcome_page');

Route::group(['middleware' => ['isServiceLogin']], function () {
    Route::get('user_search_products', [ServiceController::class, 'user_search_products'])->name('user_search_products');
    Route::get('index_page', [ServiceController::class, 'index_page'])->name('index_page');
    Route::get('products_list', [ServiceController::class, 'products_list'])->name('products_list');
    Route::get('products_list_vendor/{vendor_id}', [ServiceController::class, 'products_list_vendor'])->name('products_list_vendor');
    Route::get('add_your_shop', [ServiceController::class, 'add_your_shop'])->name('add_your_shop');
    Route::get('vendors_full_view', [ServiceController::class, 'vendors_full_view'])->name('vendors_full_view');
    Route::post('shop_registeration', [ServiceController::class, 'shop_registeration'])->name('shop_registeration');
    Route::get('product_detail/{vendor_id}/{category_id}', [ServiceController::class, 'product_detail'])->name('product_detail');
    Route::get('products_grid_view/{category_id}', [ServiceController::class, 'products_grid_view'])->name('products_grid_view');
    Route::get('services_list', [ServiceController::class, 'services_list'])->name('services_list');
    Route::get('discount_vendor_detail/{vendor_id}', [ServiceController::class, 'discount_vendor_detail'])->name('discount_vendor_detail');
    Route::get('vendor_discount_products_shop/{vendor_id}', [ServiceController::class, 'vendor_discount_products_shop'])->name('vendor_discount_products_shop');
    Route::get('classifieds_list', [ServiceController::class, 'classifieds_list'])->name('classifieds_list');
    Route::get('user_stores_list', [ServiceController::class, 'user_stores_list'])->name('user_stores_list');
    Route::get('adding_service', [ServiceController::class, 'adding_service'])->name('adding_service');
    Route::get('adding_classified', [ServiceController::class, 'adding_classified'])->name('adding_classified');
    Route::get('adding_store_registration', [ServiceController::class, 'adding_store'])->name('adding_store');
    Route::get('service_fullview/{service_id}', [ServiceController::class, 'service_fullview'])->name('service_fullview');
    Route::get('service_user_detail_view/{user_id}', [ServiceController::class, 'service_user_detail_view'])->name('service_user_detail_view');
    Route::get('classified_fullview/{service_id}', [ServiceController::class, 'classified_fullview'])->name('classified_fullview');
    Route::get('latest_products_view', [ServiceController::class, 'latest_products_view'])->name('latest_products_view');
    Route::get('store_fullview/{store_id}', [ServiceController::class, 'store_fullview'])->name('store_fullview');
    Route::get('top_category_products_list/{category_id}', [ServiceController::class, 'top_category_products_list'])->name('top_category_products_list');
    Route::get('popular_discounts_products', [ServiceController::class, 'popular_discounts_products'])->name('popular_discounts_products');
    Route::get('add_to_cart/{product_id}/{quantity}', [ServiceController::class, 'add_to_cart'])->name('add_to_cart');
    Route::get('add_to_wishlist/{product_id}', [ServiceController::class, 'add_to_wishlist'])->name('add_to_wishlist');
    Route::get('remove_item_cart/{product_id}', [ServiceController::class, 'remove_item_cart'])->name('remove_item_cart');
    Route::get('wishlist', [ServiceController::class, 'wishlist'])->name('wishlist');
    Route::get('remove_item_wishlist/{product_id}', [ServiceController::class, 'remove_item_wishlist'])->name('remove_item_wishlist');
    Route::post('business_service_listing', [ServiceController::class, 'business_service_listing'])->name('business_service_listing');
    Route::get('billing_details_form', [ServiceController::class, 'billing_details_form'])->name('billing_details_form');
    Route::post('billing_details_form_submit', [ServiceController::class, 'billing_details_form_submit'])->name('billing_details_form_submit');
    Route::get('order_summary_details', [ServiceController::class, 'order_summary_details']);
    Route::post('ordered_cofirmation_status', [ServiceController::class, 'ordered_cofirmation_status'])->name('ordered_cofirmation_status');
    Route::get('user_dashboard', [ServiceController::class, 'user_dashboard'])->name('user_dashboard');
    Route::get('generate_coupon', [ServiceController::class, 'generate_coupon'])->name('generate_coupon');
    Route::post('/validate_coupon', [ServiceController::class, 'validateCoupon'])->name('validate_coupon');
    Route::post('new_generate_coupon', [ServiceController::class, 'new_generate_coupon'])->name('generate_new_coupon');
    Route::get('my_commission', [ServiceController::class, 'my_commission'])->name('my_commission');
    Route::get('account_orders', [ServiceController::class, 'account_orders'])->name('account_orders');
    Route::get('customer_payments', [ServiceController::class, 'customer_payments'])->name('customer_payments');
    Route::get('discount_shop_orders', [ServiceController::class, 'discount_shop_orders'])->name('discount_shop_orders');
    Route::get('account_profile', [ServiceController::class, 'account_profile'])->name('account_profile');
    Route::get('edit_user_profile', [ServiceController::class, 'edit_user_profile'])->name('edit_user_profile');
    Route::post('edit_user_profile_submit', [ServiceController::class, 'edit_user_profile_submit'])->name('edit_user_profile_submit');
    Route::get('team_details', [ServiceController::class, 'team_details'])->name('team_details');
    Route::get('id_activation', [ServiceController::class, 'id_activation'])->name('id_activation');
    Route::get('withdraw_amount', [ServiceController::class, 'withdraw_amount'])->name('withdraw_amount');
    Route::post('/user/withdraw', [ServiceController::class, 'storeWithdrawRequest'])->name('user_withdraw_request_submit');
    Route::get('vendor_withdraw_amount', [ServiceController::class, 'vendor_withdraw_amount'])->name('vendor_withdraw_amount');
    Route::post('user_withdraw_request', [ServiceController::class, 'user_withdraw_request'])->name('user_withdraw_request');
    Route::get('user_wallet', [ServiceController::class, 'user_wallet'])->name('user_wallet');
    Route::get('wallet/topup', [ServiceController::class, 'wallet_topup'])->name('wallet_topup');
    Route::post('vendor_withdrawal_request', [ServiceController::class, 'vendor_withdrawal_request'])->name('vendor_withdrawal_request');
    Route::post('filter_products', [ServiceController::class, 'filter_products'])->name('filter_products');
});

/*
|--------------------------------------------------------------------------
| WEBSITE POLICIES & LEGAL PAGES
|--------------------------------------------------------------------------
*/

// Policy Routes for Website
Route::get('privacy_policy', [PolicyController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('terms_and_conditions', [PolicyController::class, 'terms_and_conditions'])->name('terms_and_conditions');
Route::get('refund_policy', [PolicyController::class, 'refund_policy'])->name('refund_policy');
Route::get('shipping_policy', [PolicyController::class, 'shipping_policy'])->name('shipping_policy');
Route::get('contact_us', [PolicyController::class, 'contact_us'])->name('contact_us');

/*
|--------------------------------------------------------------------------
| PAYMENT GATEWAY
|--------------------------------------------------------------------------
| Razorpay payment processing for customer orders
*/

//Payment Gateway For Website
Route::post('razorpay', [RazorpayController::class, 'razorpay'])->name('razorpay_submit');
Route::post('discount_products_razorpay', [RazorpayController::class, 'discount_products_razorpay'])->name('discount_products_razorpay');
Route::get('payment', [RazorpayController::class, 'payment'])->name('payment');
Route::get('razorpay', [RazorpayController::class, 'razorpay'])->name('razorpay');
Route::get('success', [RazorpayController::class, 'success'])->name('success');
Route::get('cancel', [RazorpayController::class, 'cancel'])->name('cancel');

// Route::get('{any}', function () {
//     return redirect('/error_page');
// })->where('any', '.*');

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return 'Cache cleared!';
});

// ============================================
// CUSTOMER-FACING ROUTES (NEW ECOMMERCE UI)
// ============================================

// Home Page
Route::get('/home/new', function () {
    return view('home.index', [
        'trending_products' => [],
        'new_products' => [],
    ]);
});
