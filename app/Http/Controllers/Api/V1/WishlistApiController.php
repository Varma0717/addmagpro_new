<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistApiController extends Controller
{
    use ApiResponse;

    /**
     * Get user's wishlist
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $wishlist = $user->wishlist()->with('items.product')->first();

            if (!$wishlist || $wishlist->items->isEmpty()) {
                return $this->successResponse([
                    'items' => [],
                    'item_count' => 0,
                ], 'Wishlist is empty');
            }

            $items = $wishlist->items->map(fn($item) => [
                'id' => $item->id,
                'product' => $this->formatProduct($item->product),
                'added_at' => $item->created_at,
            ])->toArray();

            return $this->successResponse([
                'id' => $wishlist->id,
                'items' => $items,
                'item_count' => count($items),
            ], 'Wishlist retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch wishlist: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Add item to wishlist
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $product = Product::findOrFail($request->product_id);

            if (!$product->is_active) {
                return $this->errorResponse('Product is not available', [], 400);
            }

            // Get or create wishlist
            $wishlist = $user->wishlist()->firstOrCreate(['user_id' => $user->id]);

            // Check if item already exists
            $existingItem = $wishlist->items()
                ->where('product_id', $product->id)
                ->exists();

            if ($existingItem) {
                return $this->errorResponse('Product is already in your wishlist', [], 400);
            }

            // Add item
            WishlistItem::create([
                'wishlist_id' => $wishlist->id,
                'product_id' => $product->id,
            ]);

            return $this->successResponse([
                'product' => $this->formatProduct($product),
                'message' => 'Added to wishlist',
            ], 'Item added to wishlist', 201);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to add to wishlist: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Remove item from wishlist
     */
    public function remove(Request $request, int $itemId)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $wishlist = $user->wishlist()->first();

            if (!$wishlist) {
                return $this->notFoundResponse('Wishlist not found');
            }

            $item = $wishlist->items()->find($itemId);

            if (!$item) {
                return $this->notFoundResponse('Item not found in wishlist');
            }

            $item->delete();

            return $this->successResponse(null, 'Item removed from wishlist');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to remove item: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Remove all items from wishlist
     */
    public function clear(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $wishlist = $user->wishlist()->first();

            if ($wishlist) {
                $wishlist->items()->delete();
            }

            return $this->successResponse(null, 'Wishlist cleared');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to clear wishlist: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Check if product is in wishlist
     */
    public function isInWishlist(Request $request, int $productId)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $wishlist = $user->wishlist()->first();

            $isInWishlist = false;
            if ($wishlist) {
                $isInWishlist = $wishlist->items()
                    ->where('product_id', $productId)
                    ->exists();
            }

            return $this->successResponse([
                'product_id' => $productId,
                'is_in_wishlist' => $isInWishlist,
            ], 'Wishlist status retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to check wishlist: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get wishlist item count
     */
    public function count(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $wishlist = $user->wishlist()->first();

            $count = 0;
            if ($wishlist) {
                $count = $wishlist->items()->count();
            }

            return $this->successResponse([
                'count' => $count,
            ], 'Wishlist count retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get wishlist count: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Share wishlist
     */
    public function share(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $wishlist = $user->wishlist()->with('items.product')->first();

            if (!$wishlist || $wishlist->items->isEmpty()) {
                return $this->errorResponse('Wishlist is empty', [], 400);
            }

            $shareUrl = config('app.url') . '/wishlist/' . base64_encode($user->id);

            $items = $wishlist->items->map(fn($item) => [
                'name' => $item->product->name,
                'price' => (float) $item->product->final_price,
            ])->toArray();

            return $this->successResponse([
                'share_url' => $shareUrl,
                'share_text' => 'Check out my wishlist on AdMagPro!',
                'items_count' => count($items),
                'total_value' => (float) collect($items)->sum('price'),
            ], 'Wishlist share link generated');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to generate share link: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    // Helper Methods

    /**
     * Format product response
     */
    private function formatProduct($product): array
    {
        $primaryImage = $product->images()->where('is_primary', true)->first()
            ?? $product->images()->first();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => (float) $product->price,
            'final_price' => (float) $product->final_price,
            'discount_percent' => (float) $product->discount_percent,
            'rating' => $product->rating,
            'review_count' => $product->review_count,
            'in_stock' => $product->stock_quantity > 0,
            'image_url' => $primaryImage?->image_url,
        ];
    }
}
