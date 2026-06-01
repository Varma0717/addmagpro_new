<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WishlistApiController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $items = DB::table('wishlist_products as w')
                ->leftJoin('products_list as p', 'w.product_id', '=', 'p.product_id')
                ->where('w.service_user_id', $user->id)
                ->select([
                    'w.wishlist_id',
                    'w.product_id',
                    'w.created_at as added_at',
                    'p.product_name',
                    'p.product_images',
                    'p.unit_price',
                ])
                ->orderByDesc('w.wishlist_id')
                ->get()
                ->map(function ($row) {
                    $name = (string) ($row->product_name ?? 'Product');
                    $price = (float) ($row->unit_price ?? 0);
                    return [
                        'id' => (int) ($row->wishlist_id ?? 0),
                        'product_id' => (int) ($row->product_id ?? 0),
                        'added_at' => $row->added_at,
                        'product' => [
                            'id' => (int) ($row->product_id ?? 0),
                            'name' => $name,
                            'slug' => Str::slug($name),
                            'price' => $price,
                            'final_price' => $price,
                            'primary_image_url' => $row->product_images,
                            'image_url' => $row->product_images,
                        ],
                    ];
                })
                ->values();

            return $this->successResponse([
                'items' => $items,
                'item_count' => $items->count(),
            ], 'Wishlist retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch wishlist: ' . $e->getMessage(), [], 500);
        }
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products_list,product_id',
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
            $exists = DB::table('wishlist_products')
                ->where('service_user_id', $user->id)
                ->where('product_id', $productId)
                ->exists();

            if ($exists) {
                return $this->errorResponse('Product is already in your wishlist', [], 400);
            }

            DB::table('wishlist_products')->insert([
                'service_user_id' => $user->id,
                'product_id' => $productId,
                'created_at' => now(),
            ]);

            return $this->successResponse(null, 'Item added to wishlist', 201);
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to add to wishlist: ' . $e->getMessage(), [], 500);
        }
    }

    public function remove(Request $request, int $itemId)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $deleted = DB::table('wishlist_products')
                ->where('wishlist_id', $itemId)
                ->where('service_user_id', $user->id)
                ->delete();

            if ($deleted === 0) {
                return $this->notFoundResponse('Item not found in wishlist');
            }

            return $this->successResponse(null, 'Item removed from wishlist');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to remove item: ' . $e->getMessage(), [], 500);
        }
    }

    public function clear(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            DB::table('wishlist_products')
                ->where('service_user_id', $user->id)
                ->delete();

            return $this->successResponse(null, 'Wishlist cleared');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to clear wishlist: ' . $e->getMessage(), [], 500);
        }
    }

    public function isInWishlist(Request $request, int $productId)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $isInWishlist = DB::table('wishlist_products')
                ->where('service_user_id', $user->id)
                ->where('product_id', $productId)
                ->exists();

            return $this->successResponse([
                'product_id' => $productId,
                'is_in_wishlist' => $isInWishlist,
            ], 'Wishlist status retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to check wishlist: ' . $e->getMessage(), [], 500);
        }
    }

    public function count(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $count = DB::table('wishlist_products')
                ->where('service_user_id', $user->id)
                ->count();

            return $this->successResponse(['count' => $count], 'Wishlist count retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to get wishlist count: ' . $e->getMessage(), [], 500);
        }
    }

    public function share(Request $request)
    {
        return $this->successResponse([
            'share_url' => config('app.url') . '/wishlist',
            'share_text' => 'Check out my wishlist on AddMagPro!',
            'items_count' => 0,
            'total_value' => 0,
        ], 'Wishlist share link generated');
    }
}
