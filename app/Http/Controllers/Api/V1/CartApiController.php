<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CartApiController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $rows = DB::table('cart_products as c')
                ->leftJoin('products_list as p', 'c.product_id', '=', 'p.product_id')
                ->where('c.service_user_id', $user->id)
                ->select([
                    'c.cart_id',
                    'c.product_id',
                    'c.quantity',
                    'p.product_name',
                    'p.product_description',
                    'p.unit_price',
                    'p.product_images',
                ])
                ->orderByDesc('c.cart_id')
                ->get();

            $items = $rows->map(function ($row) {
                $price = (float) ($row->unit_price ?? 0);
                $qty = (int) ($row->quantity ?? 0);
                $subtotal = $price * $qty;
                $name = (string) ($row->product_name ?? 'Product');
                $slug = Str::slug($name);

                return [
                    'id' => (int) ($row->cart_id ?? 0),
                    'product_id' => (int) ($row->product_id ?? 0),
                    'quantity' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                    'product' => [
                        'id' => (int) ($row->product_id ?? 0),
                        'name' => $name,
                        'slug' => $slug,
                        'effective_price' => $price,
                        'primary_image_url' => $row->product_images,
                        'image_url' => $row->product_images,
                    ],
                ];
            })->values();

            $subtotal = (float) $items->sum('subtotal');
            $quantityCount = (int) $items->sum('quantity');

            return $this->successResponse([
                'items' => $items,
                'subtotal' => $subtotal,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total' => $subtotal,
                'coupon_code' => null,
                'item_count' => $items->count(),
                'quantity_count' => $quantityCount,
            ], 'Cart retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch cart: ' . $e->getMessage(), [], 500);
        }
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products_list,product_id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $productId = (int) $request->product_id;
            $qty = (int) $request->quantity;

            $existing = DB::table('cart_products')
                ->where('service_user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($existing) {
                DB::table('cart_products')
                    ->where('cart_id', $existing->cart_id)
                    ->update(['quantity' => (int) $existing->quantity + $qty]);
            } else {
                DB::table('cart_products')->insert([
                    'service_user_id' => $user->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'created_at' => now(),
                ]);
            }

            return $this->index($request);
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to add item: ' . $e->getMessage(), [], 500);
        }
    }

    public function update(Request $request, int $itemId)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $updated = DB::table('cart_products')
                ->where('cart_id', $itemId)
                ->where('service_user_id', $user->id)
                ->update(['quantity' => (int) $request->quantity]);

            if ($updated === 0) {
                return $this->notFoundResponse('Cart item not found');
            }

            return $this->index($request);
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to update item: ' . $e->getMessage(), [], 500);
        }
    }

    public function destroy(Request $request, int $itemId)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            DB::table('cart_products')
                ->where('cart_id', $itemId)
                ->where('service_user_id', $user->id)
                ->delete();

            return $this->index($request);
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to remove item: ' . $e->getMessage(), [], 500);
        }
    }

    public function applyCoupon(Request $request)
    {
        try {
            if (!Schema::hasTable('coupons')) {
                return $this->errorResponse('Coupon system not configured', [], 400);
            }

            return $this->errorResponse('Invalid coupon code', [], 404);
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to apply coupon: ' . $e->getMessage(), [], 500);
        }
    }

    public function removeCoupon(Request $request)
    {
        return $this->index($request);
    }

    public function clear(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            DB::table('cart_products')
                ->where('service_user_id', $user->id)
                ->delete();

            return $this->successResponse(null, 'Cart cleared');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to clear cart: ' . $e->getMessage(), [], 500);
        }
    }
}
