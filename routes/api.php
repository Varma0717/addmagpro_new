<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\ApiController;
use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\AccountApiController;
use App\Http\Controllers\Api\V1\LocationApiController;
use App\Http\Controllers\Api\V1\WalletApiController;
use App\Http\Controllers\Api\V1\ReferralApiController;
use App\Http\Controllers\Api\V1\HomeApiController;
use App\Http\Controllers\Api\V1\ProductApiController;
use App\Http\Controllers\Api\V1\CartApiController;
use App\Http\Controllers\Api\V1\OrderApiController;
use App\Http\Controllers\Api\V1\WishlistApiController;
use App\Http\Controllers\Api\V1\SearchApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Legacy routes (deprecated, for backward compatibility)
Route::post('/register', [ApiController::class, 'register']);
Route::post('/user_login', [ApiController::class, 'user_login']);
Route::get('/category_list', [ApiController::class, 'category_list']);
Route::get('/products_list', [ApiController::class, 'products_list']);
Route::post('/add_to_cart', [ApiController::class, 'add_to_cart']);
Route::get('/view_cart', [ApiController::class, 'view_cart']);
Route::post('/order_products', [ApiController::class, 'order_products']);

// ===== NEW API V1 ROUTES =====

// Auth Routes (Public)
Route::prefix('v1/auth')->group(function () {
    Route::post('register', [AuthApiController::class, 'register']);
    Route::post('login', [AuthApiController::class, 'login']);
    Route::post('logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('me', [AuthApiController::class, 'me'])->middleware('auth:sanctum');
    Route::post('refresh', [AuthApiController::class, 'refresh'])->middleware('auth:sanctum');
});

// Location Routes (Public)
Route::prefix('v1/locations')->group(function () {
    Route::get('', [LocationApiController::class, 'index']);
    Route::post('detect', [LocationApiController::class, 'detect']);
    Route::post('nearby', [LocationApiController::class, 'nearby']);
    Route::post('save', [LocationApiController::class, 'saveUserLocation'])->middleware('auth:sanctum');
});

// Home Routes (Public)
Route::prefix('v1/home')->group(function () {
    Route::get('', [HomeApiController::class, 'index']);
    Route::get('featured', [HomeApiController::class, 'featured']);
    Route::get('new-launches', [HomeApiController::class, 'newLaunches']);
    Route::get('trending', [HomeApiController::class, 'trending']);
    Route::get('discounted', [HomeApiController::class, 'discounted']);
});

// Product Routes (Public)
Route::prefix('v1/products')->group(function () {
    Route::get('', [ProductApiController::class, 'index']);
    Route::get('search', [ProductApiController::class, 'search']);
    Route::get('suggestions', [ProductApiController::class, 'suggestions']);
    Route::get('categories', [ProductApiController::class, 'categories']);
    Route::get('price-range', [ProductApiController::class, 'priceRange']);
    Route::get('category/{slug}', [ProductApiController::class, 'byCategory']);
    Route::get('{slug}', [ProductApiController::class, 'show']);
});

// Search Routes (Public)
Route::prefix('v1/search')->group(function () {
    Route::get('', [SearchApiController::class, 'global']);
    Route::get('products', [SearchApiController::class, 'products']);
    Route::get('barcode', [SearchApiController::class, 'byBarcode']);
    Route::post('voice', [SearchApiController::class, 'voice']);
    Route::get('suggestions', [SearchApiController::class, 'suggestions']);
    Route::get('trending', [SearchApiController::class, 'trending']);
    Route::get('trending-categories', [SearchApiController::class, 'trendingCategories']);
});

// Protected Routes (Requires Authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Account Routes
    Route::prefix('v1/account')->group(function () {
        Route::get('profile', [AccountApiController::class, 'profile']);
        Route::patch('profile', [AccountApiController::class, 'updateProfile']);
        Route::get('addresses', [AccountApiController::class, 'addresses']);
        Route::post('addresses', [AccountApiController::class, 'addAddress']);
        Route::get('notifications', [AccountApiController::class, 'notifications']);
        Route::post('notifications/{id}/read', [AccountApiController::class, 'markNotificationRead']);
        Route::get('notification-preferences', [AccountApiController::class, 'notificationPreferences']);
        Route::patch('notification-preferences', [AccountApiController::class, 'updateNotificationPreferences']);
    });

    // Wallet Routes
    Route::prefix('v1/account/wallet')->group(function () {
        Route::get('', [WalletApiController::class, 'index']); // Get balance
        Route::post('topup/create', [WalletApiController::class, 'createTopup']);
        Route::post('topup/verify', [WalletApiController::class, 'verifyTopup']);
        Route::post('send-money', [WalletApiController::class, 'sendMoney']);
        Route::post('self-transfer', [WalletApiController::class, 'selfTransfer']);
        Route::get('transactions', [WalletApiController::class, 'transactions']);
        Route::get('transactions/{id}', [WalletApiController::class, 'getTransaction']);
        Route::get('statistics', [WalletApiController::class, 'statistics']);
    });

    // Referral Routes
    Route::prefix('v1/account/referrals')->group(function () {
        Route::get('', [ReferralApiController::class, 'list']);
        Route::get('profile', [ReferralApiController::class, 'profile']);
        Route::get('{id}', [ReferralApiController::class, 'show']);
        Route::post('share', [ReferralApiController::class, 'share']);
        Route::post('register', [ReferralApiController::class, 'registerWithCode']);
        Route::post('{id}/claim-bonus', [ReferralApiController::class, 'claimBonus']);
        Route::post('{id}/complete', [ReferralApiController::class, 'completeReferral']);
        Route::get('statistics', [ReferralApiController::class, 'statistics']);
    });

    // Cart Routes
    Route::prefix('v1/cart')->group(function () {
        Route::get('', [CartApiController::class, 'index']);
        Route::post('add', [CartApiController::class, 'add']);
        Route::patch('items/{id}', [CartApiController::class, 'update']);
        Route::delete('items/{id}', [CartApiController::class, 'destroy']);
        Route::post('apply-coupon', [CartApiController::class, 'applyCoupon']);
        Route::post('remove-coupon', [CartApiController::class, 'removeCoupon']);
        Route::post('clear', [CartApiController::class, 'clear']);
    });

    // Order Routes
    Route::prefix('v1/orders')->group(function () {
        Route::get('', [OrderApiController::class, 'index']);
        Route::post('create', [OrderApiController::class, 'create']);
        Route::get('statistics', [OrderApiController::class, 'statistics']);
        Route::get('{id}', [OrderApiController::class, 'show']);
        Route::post('{id}/cancel', [OrderApiController::class, 'cancel']);
        Route::post('{id}/return', [OrderApiController::class, 'requestReturn']);
        Route::get('{id}/track', [OrderApiController::class, 'track']);
    });

    // Wishlist Routes
    Route::prefix('v1/wishlist')->group(function () {
        Route::get('', [WishlistApiController::class, 'index']);
        Route::post('add', [WishlistApiController::class, 'add']);
        Route::delete('items/{id}', [WishlistApiController::class, 'remove']);
        Route::post('clear', [WishlistApiController::class, 'clear']);
        Route::get('count', [WishlistApiController::class, 'count']);
        Route::get('is-in-wishlist/{productId}', [WishlistApiController::class, 'isInWishlist']);
        Route::post('share', [WishlistApiController::class, 'share']);
    });

    // Protected Search Routes
    Route::prefix('v1/search')->group(function () {
        Route::post('log', [SearchApiController::class, 'logSearch']);
        Route::get('recent', [SearchApiController::class, 'recent']);
        Route::post('clear-history', [SearchApiController::class, 'clearHistory']);
    });
});

// API v1 fallback (optional legacy)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json(['message' => 'Test route working']);
});
