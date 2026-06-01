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
use Illuminate\Support\Str;

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
                    $title = $this->firstString($banner, ['title', 'banner_title', 'name']);
                    $description = $this->firstString($banner, ['description', 'subtitle', 'banner_description']);
                    $imageUrl = $this->firstString($banner, ['image_url', 'banner_image', 'event_banner_image', 'ads_banner_image', 'ImageURL']);
                    $actionUrl = $this->firstString($banner, ['action_url', 'redirect_url', 'link_url']);
                    $type = $this->firstString($banner, ['banner_type', 'type']);

                    return [
                        'id' => $this->firstInt($banner, ['id', 'banner_id']),
                        'title' => $title,
                        'description' => $description,
                        'image_url' => $imageUrl,
                        'action_url' => $actionUrl,
                        'type' => $type,
                    ];
                })
                ->filter(function ($banner) {
                    return !empty($banner['image_url']) || !empty($banner['title']);
                })
                ->values();

            // Get categories
            $categories = Category::query()
                ->limit(8)
                ->get()
                ->map(function ($category) {
                    $name = $this->firstString($category, ['name', 'CategoryName', 'category_name', 'title']);

                    return [
                        'id' => $this->firstInt($category, ['id', 'category_id']),
                        'name' => $name,
                        'slug' => $this->firstString($category, ['slug']) ?? Str::slug((string) $name),
                        'image_url' => $this->firstString($category, ['image_url', 'ImageURL', 'category_image', 'icon_url']),
                    ];
                })
                ->values();

            // Get services (12 from mockup)
            $services = Service::query()
                ->limit(12)
                ->get()
                ->map(function ($service) {
                    $name = $this->firstString($service, ['name', 'service_name', 'classified_name', 'title']);

                    return [
                        'id' => $this->firstInt($service, ['id', 'service_id']),
                        'name' => $name,
                        'slug' => $this->firstString($service, ['slug']) ?? Str::slug((string) $name),
                        'icon_url' => $this->firstString($service, ['icon_url', 'service_image', 'ImageURL', 'banner_image']),
                        'action_url' => $this->firstString($service, ['action_url', 'service_url', 'redirect_url']),
                    ];
                })
                ->values();

            // Featured: latest arrivals
            $featuredCollection = Product::query()
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            $featuredIds = $featuredCollection->pluck('product_id')->all();
            $featuredProducts = $featuredCollection->map(function ($product) {
                return $this->formatProductResponse($product);
            })->values();

            // Recommended: high value items excluding featured set
            $recommendedCollection = Product::query()
                ->when(!empty($featuredIds), function ($query) use ($featuredIds) {
                    return $query->whereNotIn('product_id', $featuredIds);
                })
                ->orderBy('unit_price', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            $recommendedIds = $recommendedCollection->pluck('product_id')->all();
            $recommendedProducts = $recommendedCollection->map(function ($product) {
                return $this->formatProductResponse($product);
            })->values();

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

            // New launches: newest batch excluding featured/recommended
            $excludeIds = array_values(array_unique(array_merge($featuredIds, $recommendedIds)));
            $newLaunchCollection = Product::query()
                ->when(!empty($excludeIds), function ($query) use ($excludeIds) {
                    return $query->whereNotIn('product_id', $excludeIds);
                })
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
            $newLaunches = $newLaunchCollection->map(function ($product) {
                return $this->formatProductResponse($product);
            })->values();

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

            return $this->paginatedResponse($products, 'New launches retrieved');
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
        $price = (float) ($product->unit_price ?? 0);

        return [
            'id' => $product->product_id,
            'product_id' => $product->product_id,
            'name' => $product->product_name,
            'slug' => $product->slug ?? Str::slug((string) $product->product_name),
            'description' => $product->product_description,
            'category_id' => $product->category_id,
            'vendor_id' => $product->vendor_id,
            'brand_id' => $product->brand_id,
            'item_code' => $product->item_code,
            'price' => $price,
            'effective_price' => $price,
            'cost_price' => (float) $product->purchase_price,
            'primary_image_url' => $product->product_images,
            'image_url' => $product->product_images,
            'rating_avg' => null,
        ];
    }

    private function firstString(object $model, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = data_get($model, $key);
            if (!is_string($value)) {
                if (is_numeric($value)) {
                    return (string) $value;
                }
                continue;
            }

            $trimmed = trim($value);
            if ($trimmed !== '') {
                return $trimmed;
            }
        }

        return null;
    }

    private function firstInt(object $model, array $keys): ?int
    {
        foreach ($keys as $key) {
            $value = data_get($model, $key);
            if (is_int($value)) {
                return $value;
            }
            if (is_numeric($value)) {
                return (int) $value;
            }
        }

        return null;
    }
}
