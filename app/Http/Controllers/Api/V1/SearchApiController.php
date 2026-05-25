<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductReview;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SearchApiController extends Controller
{
    use ApiResponse;

    /**
     * Global search across products, categories, services
     */
    public function global(Request $request)
    {
        try {
            $query = $request->get('q');
            $limit = $request->get('limit', 10);

            if (!$query || strlen($query) < 2) {
                return $this->errorResponse('Search query must be at least 2 characters', [], 400);
            }

            // Search products with relevance ranking
            $products = $this->searchProducts($query, $limit);

            // Search categories
            $categories = $this->searchCategories($query, $limit);

            // Search services
            $services = $this->searchServices($query, $limit);

            return $this->successResponse([
                'query' => $query,
                'products' => $products,
                'categories' => $categories,
                'services' => $services,
                'total_results' => count($products) + count($categories) + count($services),
            ], 'Global search results retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Search failed: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Advanced product search with filters
     */
    public function products(Request $request)
    {
        try {
            $query = $request->get('q');
            $perPage = $request->get('per_page', 20);
            $categoryId = $request->get('category_id');
            $minPrice = $request->get('min_price');
            $maxPrice = $request->get('max_price');
            $sortBy = $request->get('sort_by', 'relevance');

            if (!$query || strlen($query) < 2) {
                return $this->errorResponse('Search query must be at least 2 characters', [], 400);
            }

            $searchQuery = Product::query();

            // Text search using actual columns: product_name, product_description
            $searchQuery->where(function ($q) use ($query) {
                $q->where('product_name', 'like', "%{$query}%")
                    ->orWhere('product_description', 'like', "%{$query}%")
                    ->orWhere('item_code', 'like', "%{$query}%");
            });

            // Category filter
            if ($categoryId) {
                $searchQuery->where('category_id', $categoryId);
            }

            // Price range using unit_price
            if ($minPrice) {
                $searchQuery->where('unit_price', '>=', $minPrice);
            }
            if ($maxPrice) {
                $searchQuery->where('unit_price', '<=', $maxPrice);
            }

            // Sorting
            switch ($sortBy) {
                case 'price':
                    $searchQuery->orderBy('unit_price', 'asc');
                    break;
                case 'newest':
                    $searchQuery->latest('created_at');
                    break;
                case 'relevance':
                default:
                    $searchQuery->orderBy('product_name', 'asc');
                    break;
            }

            $products = $searchQuery->paginate($perPage);

            collect($products->items())->transform(function ($product) {
                return $this->formatProductResponse($product);
            });

            return $this->paginatedResponse($products, 'Product search results retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Product search failed: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Search by product barcode/EAN/SKU
     */
    public function byBarcode(Request $request)
    {
        try {
            $barcode = $request->get('barcode');
            $type = $request->get('type', 'auto'); // auto, ean, sku, upc

            if (!$barcode) {
                return $this->errorResponse('Barcode is required', [], 400);
            }

            // Clean barcode input
            $barcode = preg_replace('/[^0-9a-zA-Z-]/', '', $barcode);

            if (strlen($barcode) < 6) {
                return $this->errorResponse('Invalid barcode format', [], 400);
            }

            // Search by item_code (barcode equivalent in legacy system)
            $query = Product::where('item_code', 'like', "%{$barcode}%");

            $product = $query->first();

            if (!$product) {
                return $this->notFoundResponse('Product not found with this barcode');
            }

            return $this->successResponse(
                $this->formatProductResponse($product),
                'Product found by barcode'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Barcode search failed: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Voice search - process transcribed text
     * (Client sends speech-to-text transcription, backend treats as text search)
     */
    public function voice(Request $request)
    {
        try {
            $transcript = $request->get('transcript');
            $language = $request->get('language', 'en');
            $confidence = $request->get('confidence', 0.0); // Speech recognition confidence score

            if (!$transcript || strlen($transcript) < 2) {
                return $this->errorResponse('Voice transcript must be at least 2 characters', [], 400);
            }

            // Log voice search for analytics
            Log::info('Voice search', [
                'transcript' => $transcript,
                'language' => $language,
                'confidence' => $confidence,
                'user_id' => $request->user()?->id,
            ]);

            // Process as normal text search
            $products = Product::where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->where(function ($q) use ($transcript) {
                    $q->where('name', 'like', "%{$transcript}%")
                        ->orWhere('description', 'like', "%{$transcript}%")
                        ->orWhere('tags', 'like', "%{$transcript}%")
                        ->orWhere('category_id', 'in', function ($sq) use ($transcript) {
                            $sq->select('id')->from('categories')
                                ->where('name', 'like', "%{$transcript}%");
                        });
                })
                ->orderBy('review_count', 'desc')
                ->limit(20)
                ->get()
                ->map(fn($p) => $this->formatProductResponse($p));

            return $this->successResponse([
                'transcript' => $transcript,
                'confidence' => (float) $confidence,
                'products' => $products,
                'product_count' => count($products),
            ], 'Voice search results retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Voice search failed: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get search suggestions and autocomplete
     */
    public function suggestions(Request $request)
    {
        try {
            $query = $request->get('q');
            $type = $request->get('type', 'all'); // all, products, categories, trending
            $limit = $request->get('limit', 10);

            if (!$query || strlen($query) < 2) {
                // Return trending searches if no query
                if ($type === 'all' || $type === 'trending') {
                    return $this->getTrendingSearches($limit);
                }
                return $this->successResponse([], 'No suggestions');
            }

            $suggestions = [];

            // Product suggestions
            if ($type === 'all' || $type === 'products') {
                $productSuggestions = Product::where('is_active', true)
                    ->where(function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                            ->orWhere('tags', 'like', "%{$query}%");
                    })
                    ->limit($limit)
                    ->pluck('name')
                    ->unique()
                    ->map(fn($name) => [
                        'type' => 'product',
                        'text' => $name,
                        'icon' => 'package',
                    ])->values();

                $suggestions = array_merge($suggestions, $productSuggestions->toArray());
            }

            // Category suggestions
            if ($type === 'all' || $type === 'categories') {
                $categorySuggestions = Category::where('is_active', true)
                    ->where('name', 'like', "%{$query}%")
                    ->limit($limit)
                    ->get()
                    ->map(fn($cat) => [
                        'type' => 'category',
                        'text' => $cat->name,
                        'icon' => 'folder',
                        'slug' => $cat->slug,
                    ])->values();

                $suggestions = array_merge($suggestions, $categorySuggestions->toArray());
            }

            // Trending searches
            if ($type === 'all' || $type === 'trending') {
                $trendingSuggestions = $this->getTrendingSearchList($limit);
                $suggestions = array_merge($suggestions, $trendingSuggestions);
            }

            return $this->successResponse(
                array_slice($suggestions, 0, $limit),
                'Suggestions retrieved'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Suggestions failed: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get trending searches
     */
    public function trending(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);

            $trendingSearches = $this->getTrendingSearchList($limit);

            return $this->successResponse([
                'trending' => $trendingSearches,
                'updated_at' => now(),
            ], 'Trending searches retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Trending search failed: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get popular/trending categories
     */
    public function trendingCategories(Request $request)
    {
        try {
            $limit = $request->get('limit', 8);

            $categories = Category::where('is_active', true)
                ->withCount('products')
                ->orderBy('products_count', 'desc')
                ->limit($limit)
                ->get()
                ->map(fn($cat) => [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'image_url' => $cat->image_url,
                    'product_count' => $cat->products_count,
                ]);

            return $this->successResponse($categories, 'Trending categories retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Trending categories failed: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Log search query for analytics
     */
    public function logSearch(Request $request)
    {
        try {
            $query = $request->get('query');
            $type = $request->get('type', 'text'); // text, voice, barcode
            $results_count = $request->get('results_count', 0);
            $clicked_result_id = $request->get('clicked_result_id');

            if (!$query) {
                return $this->errorResponse('Query is required', [], 400);
            }

            // Log to database for analytics
            DB::table('search_logs')->insert([
                'user_id' => $request->user()?->id,
                'query' => $query,
                'type' => $type,
                'results_count' => $results_count,
                'clicked_result_id' => $clicked_result_id,
                'clicked_result_type' => $request->get('clicked_result_type'),
                'timestamp' => now(),
                'created_at' => now(),
            ]);

            return $this->successResponse(['logged' => true], 'Search logged');
        } catch (\Exception $e) {
            // Log errors but don't fail the request
            Log::error('Search log failed: ' . $e->getMessage());
            return $this->successResponse(['logged' => false], 'Search log stored locally');
        }
    }

    /**
     * Get user's recent searches
     */
    public function recent(Request $request)
    {
        try {
            $user = $request->user();
            $limit = $request->get('limit', 10);

            $recentSearches = DB::table('search_logs')
                ->where('user_id', $user->id)
                ->distinct('query')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->pluck('query')
                ->map(fn($query) => [
                    'text' => $query,
                    'type' => 'recent',
                ])
                ->values();

            return $this->successResponse($recentSearches, 'Recent searches retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Recent searches failed: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Clear user's search history
     */
    public function clearHistory(Request $request)
    {
        try {
            $user = $request->user();
            DB::table('search_logs')->where('user_id', $user->id)->delete();

            return $this->successResponse(['cleared' => true], 'Search history cleared');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Clear history failed: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    // ============ HELPER METHODS ============

    /**
     * Search products with relevance ranking
     */
    private function searchProducts(string $query, int $limit = 10)
    {
        return Product::where(function ($q) use ($query) {
            $q->where('product_name', 'like', "%{$query}%")
                ->orWhere('product_description', 'like', "%{$query}%")
                ->orWhere('item_code', 'like', "%{$query}%");
        })
            ->orderBy('product_name', 'asc')
            ->limit($limit)
            ->get()
            ->map(fn($p) => $this->formatProductResponse($p))
            ->toArray();
    }

    /**
     * Search categories
     */
    private function searchCategories(string $query, int $limit = 5)
    {
        return Category::where('name', 'like', "%{$query}%")
            ->limit($limit)
            ->get()
            ->map(fn($cat) => [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug ?? Str::slug($cat->name),
                'image_url' => $cat->image_url,
                'product_count' => $cat->products()->count(),
            ])
            ->toArray();
    }

    /**
     * Search services
     */
    private function searchServices(string $query, int $limit = 5)
    {
        return \App\Models\Service::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'slug' => $s->slug,
                'icon_url' => $s->icon_url,
                'action_url' => $s->action_url,
            ])
            ->toArray();
    }

    /**
     * Get trending searches response
     */
    private function getTrendingSearches(int $limit)
    {
        $trendingList = $this->getTrendingSearchList($limit);
        return $this->successResponse([
            'trending' => $trendingList,
            'type' => 'trending',
        ], 'Trending suggestions retrieved');
    }

    /**
     * Get trending search list from database
     */
    private function getTrendingSearchList(int $limit)
    {
        // Get most searched queries in last 30 days
        $thirty_days_ago = now()->subDays(30);

        $trending = DB::table('search_logs')
            ->where('created_at', '>=', $thirty_days_ago)
            ->groupBy('query')
            ->selectRaw('query, COUNT(*) as count')
            ->orderBy('count', 'desc')
            ->limit($limit)
            ->pluck('query')
            ->map(fn($query) => [
                'type' => 'trending',
                'text' => $query,
                'icon' => 'trending-up',
            ])
            ->values()
            ->toArray();

        // If no trending searches from logs, return hardcoded popular ones
        if (empty($trending)) {
            $trending = [
                ['type' => 'trending', 'text' => 'Electronics', 'icon' => 'trending-up'],
                ['type' => 'trending', 'text' => 'Fashion', 'icon' => 'trending-up'],
                ['type' => 'trending', 'text' => 'Beauty', 'icon' => 'trending-up'],
                ['type' => 'trending', 'text' => 'Home Decor', 'icon' => 'trending-up'],
                ['type' => 'trending', 'text' => 'Sports', 'icon' => 'trending-up'],
            ];
        }

        return $trending;
    }

    /**
     * Format product response
     */
    private function formatProductResponse(Product $product)
    {
        return [
            'id' => $product->product_id,
            'name' => $product->product_name,
            'description' => $product->product_description,
            'price' => (float) $product->unit_price,
            'cost_price' => (float) $product->purchase_price,
            'category_id' => $product->category_id,
            'vendor_id' => $product->vendor_id,
            'image_url' => $product->product_images,
        ];
    }
}
