<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartApiController extends Controller
{
    use ApiResponse;

    /**
     * Get user's cart
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            $cart = $user->cart()->with('items.product')->first();

            if (!$cart) {
                return $this->successResponse([
                    'items' => [],
                    'subtotal' => 0,
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'total' => 0,
                    'coupon_code' => null,
                    'item_count' => 0,
                ], 'Empty cart');
            }

            return $this->successResponse([
                'id' => $cart->id,
                'items' => $cart->items->map(fn($item) => $this->formatCartItem($item))->toArray(),
                'subtotal' => (float) $cart->subtotal,
                'tax_amount' => (float) $cart->tax_amount,
                'discount_amount' => (float) $cart->discount_amount,
                'total' => (float) $cart->total,
                'coupon_code' => $cart->coupon_code,
                'item_count' => $cart->items->count(),
            ], 'Cart retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch cart: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            $product = Product::findOrFail($request->product_id);

            // Validate product
            if (!$product->is_active) {
                return $this->errorResponse('Product is not available', [], 400);
            }

            if ($product->stock_quantity < $request->quantity) {
                return $this->errorResponse('Insufficient stock', ['available' => $product->stock_quantity], 400);
            }

            // Get or create cart
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

            // Check if item already exists
            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                // Update quantity
                $newQuantity = $cartItem->quantity + $request->quantity;

                if ($product->stock_quantity < $newQuantity) {
                    return $this->errorResponse('Insufficient stock for total quantity', [], 400);
                }

                $cartItem->update([
                    'quantity' => $newQuantity,
                    'subtotal' => $product->final_price * $newQuantity,
                ]);
            } else {
                // Add new item
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price' => $product->final_price,
                    'subtotal' => $product->final_price * $request->quantity,
                ]);
            }

            // Recalculate cart
            $cart->recalculateTotal();

            return $this->successResponse([
                'cart' => $this->formatCart($cart),
                'message' => 'Item added to cart',
            ], 'Item added', 201);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to add item: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Update item quantity
     */
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
            $cartItem = CartItem::whereHas('cart', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->findOrFail($itemId);

            // Validate stock
            if ($cartItem->product->stock_quantity < $request->quantity) {
                return $this->errorResponse('Insufficient stock', ['available' => $cartItem->product->stock_quantity], 400);
            }

            // Update quantity
            $cartItem->update([
                'quantity' => $request->quantity,
                'subtotal' => $cartItem->price * $request->quantity,
            ]);

            // Recalculate cart
            $cartItem->cart->recalculateTotal();

            return $this->successResponse([
                'cart' => $this->formatCart($cartItem->cart),
            ], 'Item quantity updated');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update item: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Remove item from cart
     */
    public function destroy(Request $request, int $itemId)
    {
        try {
            $user = $request->user();
            $cartItem = CartItem::whereHas('cart', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->findOrFail($itemId);

            $cart = $cartItem->cart;
            $cartItem->delete();

            // Recalculate cart
            $cart->recalculateTotal();

            return $this->successResponse([
                'cart' => $this->formatCart($cart),
            ], 'Item removed from cart');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to remove item: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            $cart = $user->cart()->with('items')->first();

            if (!$cart || $cart->items->isEmpty()) {
                return $this->errorResponse('Cart is empty', [], 400);
            }

            // Find coupon
            $coupon = Coupon::where('code', $request->coupon_code)->first();

            if (!$coupon) {
                return $this->errorResponse('Invalid coupon code', [], 404);
            }

            if (!$coupon->isValid()) {
                return $this->errorResponse('Coupon is not valid or has expired', [], 400);
            }

            // Check user limit
            $userUsageCount = $coupon->usages()
                ->where('user_id', $user->id)
                ->count();

            if ($userUsageCount >= $coupon->max_usage_per_user) {
                return $this->errorResponse('You have already used this coupon', [], 400);
            }

            // Calculate discount
            $discount = $coupon->calculateDiscount($cart->subtotal);

            if ($discount <= 0) {
                return $this->errorResponse('Coupon cannot be applied to this cart', [], 400);
            }

            // Apply coupon
            $cart->update([
                'coupon_code' => $coupon->code,
                'discount_amount' => $discount,
            ]);

            $cart->recalculateTotal();

            return $this->successResponse([
                'cart' => $this->formatCart($cart),
                'discount' => (float) $discount,
                'coupon_details' => [
                    'code' => $coupon->code,
                    'description' => $coupon->description,
                    'discount_type' => $coupon->discount_type,
                    'discount_value' => (float) $coupon->discount_value,
                ],
            ], 'Coupon applied successfully');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to apply coupon: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Remove coupon
     */
    public function removeCoupon(Request $request)
    {
        try {
            $user = $request->user();
            $cart = $user->cart()->first();

            if (!$cart) {
                return $this->notFoundResponse('Cart not found');
            }

            $cart->update([
                'coupon_code' => null,
                'discount_amount' => 0,
            ]);

            $cart->recalculateTotal();

            return $this->successResponse([
                'cart' => $this->formatCart($cart),
            ], 'Coupon removed');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to remove coupon: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request)
    {
        try {
            $user = $request->user();
            $cart = $user->cart()->first();

            if ($cart) {
                $cart->items()->delete();
                $cart->delete();
            }

            return $this->successResponse(null, 'Cart cleared');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to clear cart: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    // Helper Methods

    /**
     * Format cart item response
     */
    private function formatCartItem($item): array
    {
        return [
            'id' => $item->id,
            'product' => [
                'id' => $item->product->id,
                'name' => $item->product->name,
                'slug' => $item->product->slug,
                'image_url' => $item->product->images()->where('is_primary', true)->first()?->image_url,
            ],
            'quantity' => $item->quantity,
            'price' => (float) $item->price,
            'subtotal' => (float) $item->subtotal,
        ];
    }

    /**
     * Format complete cart
     */
    private function formatCart($cart): array
    {
        return [
            'id' => $cart->id,
            'items' => $cart->items->map(fn($item) => $this->formatCartItem($item))->toArray(),
            'subtotal' => (float) $cart->subtotal,
            'tax_amount' => (float) $cart->tax_amount,
            'discount_amount' => (float) $cart->discount_amount,
            'total' => (float) $cart->total,
            'coupon_code' => $cart->coupon_code,
            'item_count' => $cart->items->count(),
        ];
    }
}
