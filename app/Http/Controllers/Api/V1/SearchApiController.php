<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchApiController extends Controller
{
    use ApiResponse;

    public function global(Request $request)
    {
        try {
            $query = trim((string) $request->get('q', ''));
            $limit = max(1, min(50, (int) $request->get('limit', 10)));

            if (mb_strlen($query) < 2) {
                return $this->errorResponse('Search query must be at least 2 characters', [], 400);
            }

            $products = $this->searchProducts($query, $limit);
            $categories = $this->searchCategories($query, min(8, $limit));
            $services = $this->searchServices($query, min(12, $limit));

            return $this->successResponse([
                'query' => $query,
                'products' => $products,
                'categories' => $categories,
                'services' => $services,
                'total_results' => count($products) + count($categories) + count($services),
            ], 'Global search results retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Search failed: ' . $e->getMessage(), [], 500);
        }
    }

    public function products(Request $request)
    {
        try {
            $query = trim((string) $request->get('q', ''));
            if (mb_strlen($query) < 2) {
                return $this->errorResponse('Search query must be at least 2 characters', [], 400);
            }

            $perPage = max(1, min(100, (int) $request->get('per_page', 20)));
            $categoryId = $request->get('category_id');
            $minPrice = $request->get('min_price');
            $maxPrice = $request->get('max_price');
            $sortBy = (string) $request->get('sort_by', 'relevance');

            $searchQuery = Product::query()
                ->where(function ($q) use ($query) {
                    $q->where('product_name', 'like', "%{$query}%")
                        ->orWhere('product_description', 'like', "%{$query}%")
                        ->orWhere('item_code', 'like', "%{$query}%");
                });

            if ($categoryId !== null && $categoryId !== '') {
                $searchQuery->where('category_id', (int) $categoryId);
            }
            if ($minPrice !== null && $minPrice !== '') {
                $searchQuery->where('unit_price', '>=', (float) $minPrice);
            }
            if ($maxPrice !== null && $maxPrice !== '') {
                $searchQuery->where('unit_price', '<=', (float) $maxPrice);
            }

            switch ($sortBy) {
                case 'price':
                case 'price_asc':
                    $searchQuery->orderBy('unit_price', 'asc');
                    break;
                case 'price_desc':
                    $searchQuery->orderBy('unit_price', 'desc');
                    break;
                case 'newest':
                    $searchQuery->orderBy('created_at', 'desc');
                    break;
                case 'relevance':
                default:
                    $searchQuery->orderBy('product_name', 'asc');
                    break;
            }

            $products = $searchQuery->paginate($perPage);
            $items = collect($products->items())
                ->map(fn(Product $product) => $this->formatProductResponse($product))
                ->values();

            return response()->json([
                'success' => true,
                'data' => $items,
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'last_page' => $products->lastPage(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                    'has_more' => $products->hasMorePages(),
                ],
                'message' => 'Product search results retrieved',
                'timestamp' => now()->toIso8601String(),
            ]);
        } catch (\Throwable $e) {
            return $this->errorResponse('Product search failed: ' . $e->getMessage(), [], 500);
        }
    }

    public function byBarcode(Request $request)
    {
        try {
            $barcode = preg_replace('/[^0-9a-zA-Z-]/', '', (string) $request->get('barcode', ''));
            if ($barcode === '' || strlen($barcode) < 3) {
                return $this->errorResponse('Invalid barcode format', [], 400);
            }

            $product = Product::where('item_code', 'like', "%{$barcode}%")->first();
            if (!$product) {
                return $this->notFoundResponse('Product not found with this barcode');
            }

            return $this->successResponse($this->formatProductResponse($product), 'Product found by barcode');
        } catch (\Throwable $e) {
            return $this->errorResponse('Barcode search failed: ' . $e->getMessage(), [], 500);
        }
    }

    public function voice(Request $request)
    {
        $request->merge(['q' => (string) $request->get('transcript', '')]);
        return $this->global($request);
    }

    public function suggestions(Request $request)
    {
        try {
            $query = trim((string) $request->get('q', ''));
            $limit = max(1, min(20, (int) $request->get('limit', 10)));

            if (mb_strlen($query) < 2) {
                return $this->successResponse($this->getTrendingSearchList($limit), 'Trending suggestions retrieved');
            }

            $items = Product::query()
                ->where(function ($q) use ($query) {
                    $q->where('product_name', 'like', "%{$query}%")
                        ->orWhere('item_code', 'like', "%{$query}%");
                })
                ->limit($limit)
                ->get(['product_name'])
                ->map(fn($product) => [
                    'type' => 'product',
                    'text' => (string) $product->product_name,
                    'icon' => 'package',
                ])
                ->values()
                ->toArray();

            return $this->successResponse($items, 'Suggestions retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Suggestions failed: ' . $e->getMessage(), [], 500);
        }
    }

    public function trending(Request $request)
    {
        $limit = max(1, min(20, (int) $request->get('limit', 10)));
        return $this->successResponse([
            'trending' => $this->getTrendingSearchList($limit),
            'updated_at' => now(),
        ], 'Trending searches retrieved');
    }

    public function trendingCategories(Request $request)
    {
        try {
            $limit = max(1, min(20, (int) $request->get('limit', 8)));
            $categories = Category::query()
                ->orderBy('CategoryName')
                ->limit($limit)
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => (int) $category->id,
                        'name' => (string) ($category->CategoryName ?? ''),
                        'slug' => Str::slug((string) ($category->CategoryName ?? '')),
                        'image_url' => $category->ImageURL,
                        'product_count' => Product::where('category_id', $category->id)->count(),
                    ];
                })
                ->values();

            return $this->successResponse($categories, 'Trending categories retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Trending categories failed: ' . $e->getMessage(), [], 500);
        }
    }

    public function logSearch(Request $request)
    {
        return $this->successResponse(['logged' => false], 'Search log skipped');
    }

    public function recent(Request $request)
    {
        return $this->successResponse([], 'Recent searches retrieved');
    }

    public function clearHistory(Request $request)
    {
        return $this->successResponse(['cleared' => true], 'Search history cleared');
    }

    private function searchProducts(string $query, int $limit = 10): array
    {
        return Product::query()
            ->where(function ($q) use ($query) {
                $q->where('product_name', 'like', "%{$query}%")
                    ->orWhere('product_description', 'like', "%{$query}%")
                    ->orWhere('item_code', 'like', "%{$query}%");
            })
            ->orderBy('product_name')
            ->limit($limit)
            ->get()
            ->map(fn(Product $product) => $this->formatProductResponse($product))
            ->toArray();
    }

    private function searchCategories(string $query, int $limit = 5): array
    {
        return Category::query()
            ->where('CategoryName', 'like', "%{$query}%")
            ->limit($limit)
            ->get()
            ->map(function ($category) {
                $name = (string) ($category->CategoryName ?? '');
                return [
                    'id' => (int) $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'image_url' => $category->ImageURL,
                    'product_count' => Product::where('category_id', $category->id)->count(),
                ];
            })
            ->toArray();
    }

    private function searchServices(string $query, int $limit = 5): array
    {
        return DB::table('services')
            ->where('service_name', 'like', "%{$query}%")
            ->limit($limit)
            ->get()
            ->map(function ($service) {
                $id = (int) ($service->service_id ?? 0);
                $name = trim((string) ($service->service_name ?? 'Service'));
                return [
                    'id' => $id,
                    'name' => $name,
                    'slug' => 'service-' . $id,
                    'icon_url' => $service->service_image,
                    'action_url' => null,
                ];
            })
            ->toArray();
    }

    private function getTrendingSearchList(int $limit): array
    {
        $fallback = [
            ['type' => 'trending', 'text' => 'Electronics', 'icon' => 'trending-up'],
            ['type' => 'trending', 'text' => 'Fashion', 'icon' => 'trending-up'],
            ['type' => 'trending', 'text' => 'Groceries', 'icon' => 'trending-up'],
            ['type' => 'trending', 'text' => 'Mobiles', 'icon' => 'trending-up'],
            ['type' => 'trending', 'text' => 'Home Appliances', 'icon' => 'trending-up'],
        ];

        return array_slice($fallback, 0, $limit);
    }

    private function formatProductResponse(Product $product): array
    {
        $image = trim((string) ($product->product_images ?? ''));

        return [
            'id' => (int) $product->product_id,
            'product_id' => (int) $product->product_id,
            'name' => (string) ($product->product_name ?? '-'),
            'slug' => Str::slug((string) $product->product_name),
            'description' => (string) ($product->product_description ?? ''),
            'price' => (float) ($product->unit_price ?? 0),
            'effective_price' => (float) ($product->unit_price ?? 0),
            'image_url' => $image !== '' ? $image : null,
            'primary_image_url' => $image !== '' ? $image : null,
            'category_id' => (int) ($product->category_id ?? 0),
            'vendor_id' => (int) ($product->vendor_id ?? 0),
        ];
    }
}
