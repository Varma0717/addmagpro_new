<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [ApiController::class, 'register']);
Route::post('/user_login', [ApiController::class, 'user_login']);

Route::get('/category_list',[ApiController::class, 'category_list']);
Route::get('/products_list',[ApiController::class,'products_list']);
Route::post('/add_to_cart',[ApiController::class, 'add_to_cart']);
Route::get('/view_cart',[ApiController::class,'view_cart']);
Route::post('/order_products',[ApiController::class,'order_products']);

Route::get('/test', function () {
    return response()->json(['message' => 'Test route working']);
});