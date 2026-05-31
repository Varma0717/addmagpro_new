<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductReview;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    use ApiResponse;

    /**
     * Get all products with filters
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 12);
            $categoryId = $request->get('category_id');
            $search = $request->get('search');
            $minPrice = $request->get('min_price');
            $maxPrice = $request->get('max_price');
            $sortBy = $request->get('sort_by', 'latest'); // latest, price_asc, price_desc

            $query = Product::query();

            // Filter by category
            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            // Search
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%")
                        ->orWhere('product_description', 'like', "%{$search}%")
                        ->orWhere('item_code', 'like', "%{$search}%");
                });
            }

            // Price range
            if ($minPrice) {
                $query->where('unit_price', '>=', $minPrice);
            }
            if ($maxPrice) {
                $query->where('unit_price', '<=', $maxPrice);
            }

            // Sorting
            switch ($sortBy) {
                case 'price_asc':
                    $query->orderBy('unit_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('unit_price', 'desc');
                    break;
                case 'latest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $products = $query->paginate($perPage);

            // Transform products using formatProductResponse
            $transformedProducts = collect($products->items())->map(function ($product) {
                return $this->formatProductResponse($product);
            });
            $products->setCollection($transformedProducts);

            return $this->paginatedResponse($products, 'Products retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch products: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get single product details
     */
    public function show(Request $request, int $id)
    {
        try {
            $product = Product::where('product_id', $id)->first();

            if (!$product) {
                return $this->notFoundResponse('Product not found');
            }

            return $this->successResponse([
                'product' => $this->formatProductResponse($product),
                'seller' => $product->vendor_id ? [
                    'id' => $product->vendor_id,
                    'name' => 'Vendor ' . $product->vendor_id,
                ] : null,
            ], 'Product details retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch product: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get all categories
     */
    public function categories(Request $request)
    {
        try {
            $categories = Category::query()
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'image_url' => $category->image_url,
                        'product_count' => $category->products()->count(),
                        'subcategories' => $category->children()
                            ->get()
                            ->map(function ($child) {
                                return [
                                    'id' => $child->id,
                                    'name' => $child->name,
                                    'slug' => $child->slug,
                                    'product_count' => $child->products()->count(),
                                ];
                            }),
                    ];
                });

            return $this->successResponse($categories, 'Categories retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch categories: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get products by category
     */
    public function byCategory(Request $request, string $categorySlug)
    {
        try {
            $category = Category::where('slug', $categorySlug)
                ->first();

            if (!$category) {
                return $this->notFoundResponse('Category not found');
            }

            $perPage = $request->get('per_page', 12);
            $sortBy = $request->get('sort_by', 'latest');
            $minPrice = $request->get('min_price');
            $maxPrice = $request->get('max_price');

            $query = $category->products();

            if ($minPrice) {
                $query->where('unit_price', '>=', $minPrice);
            }
            if ($maxPrice) {
                $query->where('unit_price', '<=', $maxPrice);
            }

            switch ($sortBy) {
                case 'popular':
                    $query->orderBy('review_count', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }

            $products = $query->paginate($perPage);

            // Transform products using formatProductResponse
            $transformedProducts = collect($products->items())->map(function ($product) {
                return $this->formatProductResponse($product);
            });
            $products->setCollection($transformedProducts);

            return $this->paginatedResponse($products, 'Category products retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch category products: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query || strlen($query) < 2) {
            return $this->errorResponse('Search query must be at least 2 characters', [], 400);
        }

        try {
            $perPage = $request->get('per_page', 12);

            $products = Product::where('is_active', true)
                ->inStock()
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('tags', 'like', "%{$query}%");
                })
                ->latest()
                ->paginate($perPage);

            // Transform products using formatProductResponse
            $transformedProducts = collect($products->items())->map(function ($product) {
                return $this->formatProductResponse($product);
            });
            $products->setCollection($transformedProducts);

            return $this->paginatedResponse($products, 'Search results retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to search products: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get search suggestions
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q');

        if (!$query || strlen($query) < 2) {
            return $this->successResponse([], 'No suggestions');
        }

        try {
            $suggestions = Product::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('tags', 'like', "%{$query}%");
                })
                ->distinct()
                ->limit(10)
                ->get(['name'])
                ->map(fn($p) => ['text' => $p->name]);

            return $this->successResponse($suggestions, 'Suggestions retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch suggestions: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get price range for filters
     */
    public function priceRange(Request $request)
    {
        try {
            $categoryId = $request->get('category_id');

            $query = Product::where('is_active', true)->inStock();

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            $minPrice = $query->min('price');
            $maxPrice = $query->max('price');

            return $this->successResponse([
                'min_price' => (float) $minPrice,
                'max_price' => (float) $maxPrice,
            ], 'Price range retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch price range: ' . $e->getMessage(),
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
        // Get primary image - safely handle missing product_images table
        $imageUrl = null;
        try {
            $primaryImage = $product->images()->first();
            if ($primaryImage) {
                $imageUrl = $primaryImage->image_url ??
                    $primaryImage->image_path ??
                    $primaryImage->url ?? null;
            }
        } catch (\Exception $e) {
            // product_images table might not exist, use legacy column
        }

        // Fallback to legacy product_images column
        if (!$imageUrl) {
            $imageUrl = $product->product_images ?? null;
        }

        // Calculate effective price (with discount if any)
        $effectivePrice = (float) $product->unit_price;
        if ($product->discount_type && $product->discount_value) {
            if ($product->discount_type === 'percentage') {
                $effectivePrice = $effectivePrice * (1 - ($product->discount_value / 100));
            } else {
                $effectivePrice = $effectivePrice - $product->discount_value;
            }
        }

        // Get average rating - safely handle missing product_reviews table
        $avgRating = null;
        try {
            $avgRating = $product->reviews()->avg('rating');
        } catch (\Exception $e) {
            // product_reviews table might not exist
        }

        return [
            'id' => $product->product_id,
            'product_id' => $product->product_id,
            'name' => $product->product_name,
            'slug' => $product->slug ?? Str::slug($product->product_name),
            'description' => $product->product_description,
            'category_id' => $product->category_id,
            'vendor_id' => $product->vendor_id,
            'brand_id' => $product->brand_id,
            'brand_name' => $product->brand_id ? 'Brand ' . $product->brand_id : null,
            'item_code' => $product->item_code,
            'price' => (float) $product->unit_price,
            'effective_price' => round($effectivePrice, 2),
            'cost_price' => (float) $product->purchase_price,
            'discount_type' => $product->discount_type,
            'discount_value' => $product->discount_value,
            'stock_quantity' => (int) $product->quantity,
            'primary_image_url' => $imageUrl,
            'image_url' => $imageUrl,
            'rating_avg' => $avgRating ? round($avgRating, 1) : null,
            'is_active' => (bool) $product->is_active,
            'created_at' => $product->created_at?->toIso8601String(),
        ];
    }

    /**
     * Get rating distribution
     */
    private function getRatingDistribution($productId): array
    {
        $distribution = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];

        $reviews = ProductReview::where('product_id', $productId)->get();

        foreach ($reviews as $review) {
            if (isset($distribution[$review->rating])) {
                $distribution[$review->rating]++;
            }
        }

        return $distribution;
    }
}
