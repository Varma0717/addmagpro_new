<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Service;
use App\Models\Product;
use App\Models\Location;
use App\Models\Coupon;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    use ApiResponse;

    /**
     * Get home screen data (location-aware)
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            // Get user's current location
            $userLocation = null;
            if ($user && $user->location_lat && $user->location_lng) {
                $userLocation = [
                    'latitude' => (float) $user->location_lat,
                    'longitude' => (float) $user->location_lng,
                    'address' => $user->location_address,
                ];
            }

            // Get banners
            $banners = Banner::query()
                ->limit(5)
                ->get()
                ->map(function ($banner) {
                    return [
                        'id' => $banner->id,
                        'title' => $banner->title,
                        'description' => $banner->description,
                        'image_url' => $banner->image_url,
                        'action_url' => $banner->action_url,
                        'type' => $banner->banner_type,
                    ];
                });

            // Get categories
            $categories = Category::query()
                ->limit(8)
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'image_url' => $category->image_url,
                    ];
                });

            // Get services (12 from mockup)
            $services = Service::query()
                ->limit(12)
                ->get()
                ->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'name' => $service->name,
                        'slug' => $service->slug,
                        'icon_url' => $service->icon_url,
                        'action_url' => $service->action_url,
                    ];
                });

            // Get featured products
            $featuredProducts = Product::query()
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($product) {
                    return $this->formatProductResponse($product);
                });

            // Get recommended products (top rated)
            $recommendedProducts = Product::query()
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($product) {
                    return $this->formatProductResponse($product);
                });

            // Get active coupons (benefits/offers)
            $coupons = [];

            // Get referral card info (if user is logged in)
            $referralCard = null;
            if ($user) {
                if (!$user->referral_code) {
                    $user->generateReferralCode();
                }

                $referralCard = [
                    'referral_code' => $user->referral_code,
                    'referral_link' => config('app.url') . '/referral/' . $user->referral_code,
                    'bonus_available' => (float) config('wallet.referred_bonus') / 100,
                    'text' => 'Share your code and earn ₹300!',
                ];
            }

            // New launches (recently added products)
            $newLaunches = Product::query()
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get()
                ->map(function ($product) {
                    return $this->formatProductResponse($product);
                });

            return $this->successResponse([
                'user_location' => $userLocation,
                'banners' => $banners,
                'categories' => $categories,
                'services' => $services,
                'featured_products' => $featuredProducts,
                'recommended_products' => $recommendedProducts,
                'new_launches' => $newLaunches,
                'recommended_benefits' => $coupons,
                'referral_card' => $referralCard,
                'user_wallet' => $user ? [
                    'balance' => (float) $user->wallet_balance,
                    'currency' => 'INR',
                ] : null,
            ], 'Home data retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch home data: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get featured products only
     */
    public function featured(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);

            $products = Product::query()
                ->latest()
                ->paginate($perPage);

            collect($products->items())->transform(function ($product) {
                return $this->formatProductResponse($product);
            });

            return $this->paginatedResponse($products, 'Featured products retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch featured products: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get new launches
     */
    public function newLaunches(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);

            $products = Product::query()
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            collect($products->items())->transform(function ($product) {
                return $this->formatProductResponse($product);
            });
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch new launches: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get trending products
     */
    public function trending(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);

            $products = Product::query()
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            collect($products->items())->transform(function ($product) {
                return $this->formatProductResponse($product);
            });

            return $this->paginatedResponse($products, 'Trending products retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch trending products: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get discounted products
     */
    public function discounted(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);

            $products = Product::query()
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            collect($products->items())->transform(function ($product) {
                return $this->formatProductResponse($product);
            });

            return $this->paginatedResponse($products, 'Discounted products retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch discounted products: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    // Helper Methods

    /**
     * Format product response
     */
    private function formatProductResponse(Product $product): array
    {
        return [
            'id' => $product->product_id,
            'name' => $product->product_name,
            'description' => $product->product_description,
            'category_id' => $product->category_id,
            'vendor_id' => $product->vendor_id,
            'brand_id' => $product->brand_id,
            'item_code' => $product->item_code,
            'price' => (float) $product->unit_price,
            'cost_price' => (float) $product->purchase_price,
            'image_url' => $product->product_images,
        ];
    }
}
