<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $perPage = max(1, min(100, (int) $request->get('per_page', 12)));
            $categoryId = $request->get('category_id');
            $categorySlug = $request->get('category_slug');
            $search = trim((string) ($request->get('search') ?? $request->get('q') ?? ''));
            $minPrice = $request->get('min_price');
            $maxPrice = $request->get('max_price');
            $sort = (string) ($request->get('sort') ?? $request->get('sort_by') ?? 'latest');

            $query = Product::query();

            if ($categoryId !== null && $categoryId !== '') {
                $query->where('category_id', (int) $categoryId);
            }

            if ($categorySlug !== null && trim($categorySlug) !== '') {
                $category = Category::query()->get()->first(function ($item) use ($categorySlug) {
                    $name = (string) ($item->CategoryName ?? '');
                    return Str::slug($name) === trim((string) $categorySlug);
                });
                if ($category) {
                    $query->where('category_id', (int) $category->id);
                }
            }

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%")
                        ->orWhere('product_description', 'like', "%{$search}%")
                        ->orWhere('item_code', 'like', "%{$search}%");
                });
            }

            if ($minPrice !== null && $minPrice !== '') {
                $query->where('unit_price', '>=', (float) $minPrice);
            }
            if ($maxPrice !== null && $maxPrice !== '') {
                $query->where('unit_price', '<=', (float) $maxPrice);
            }

            switch ($sort) {
                case 'price_asc':
                    $query->orderBy('unit_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('unit_price', 'desc');
                    break;
                case 'rating':
                case 'popular':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'latest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $products = $query->paginate($perPage);
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
                'message' => 'Products retrieved',
                'timestamp' => now()->toIso8601String(),
            ]);
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch products: ' . $e->getMessage(), [], 500);
        }
    }

    public function show(Request $request, string $slug)
    {
        try {
            $product = null;
            $normalized = trim($slug);

            if (preg_match('/^product-(\d+)$/', strtolower($normalized), $matches) === 1) {
                $product = Product::where('product_id', (int) $matches[1])->first();
            }

            if (!$product && is_numeric($normalized)) {
                $product = Product::where('product_id', (int) $normalized)->first();
            }

            if (!$product) {
                $product = Product::query()
                    ->get()
                    ->first(function ($item) use ($normalized) {
                        $derived = Str::slug((string) $item->product_name);
                        return $derived === $normalized;
                    });
            }

            if (!$product) {
                return $this->notFoundResponse('Product not found');
            }

            $formatted = $this->formatProductResponse($product);
            $formatted['images'] = array_values(array_filter([
                $formatted['primary_image_url'] ?? null,
            ]));
            $formatted['reviews'] = [];
            $formatted['stock'] = 999;
            $formatted['short_description'] = $formatted['description'];
            $formatted['category'] = [
                'id' => (int) ($product->category_id ?? 0),
                'name' => $this->resolveCategoryName((int) ($product->category_id ?? 0)),
            ];

            return $this->successResponse($formatted, 'Product details retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch product: ' . $e->getMessage(), [], 500);
        }
    }

    public function categories(Request $request)
    {
        try {
            $categories = Category::query()
                ->orderBy('CategoryName')
                ->get()
                ->map(function ($category) {
                    $name = (string) ($category->CategoryName ?? '');
                    return [
                        'id' => (int) $category->id,
                        'name' => $name,
                        'slug' => Str::slug($name),
                        'image_url' => $category->ImageURL,
                        'product_count' => Product::where('category_id', $category->id)->count(),
                        'subcategories' => [],
                    ];
                })
                ->values();

            return $this->successResponse($categories, 'Categories retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch categories: ' . $e->getMessage(), [], 500);
        }
    }

    public function byCategory(Request $request, string $categorySlug)
    {
        try {
            $category = Category::query()->get()->first(function ($item) use ($categorySlug) {
                $name = (string) ($item->CategoryName ?? '');
                return Str::slug($name) === $categorySlug;
            });

            if (!$category) {
                return $this->notFoundResponse('Category not found');
            }

            $request->merge(['category_id' => (int) $category->id]);
            return $this->index($request);
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch category products: ' . $e->getMessage(), [], 500);
        }
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function suggestions(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        if (mb_strlen($query) < 2) {
            return $this->successResponse([], 'No suggestions');
        }

        try {
            $items = Product::query()
                ->where(function ($q) use ($query) {
                    $q->where('product_name', 'like', "%{$query}%")
                        ->orWhere('item_code', 'like', "%{$query}%");
                })
                ->limit(10)
                ->get(['product_name'])
                ->map(fn($product) => ['text' => (string) $product->product_name])
                ->values();

            return $this->successResponse($items, 'Suggestions retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch suggestions: ' . $e->getMessage(), [], 500);
        }
    }

    public function priceRange(Request $request)
    {
        try {
            $categoryId = $request->get('category_id');
            $query = Product::query();
            if ($categoryId !== null && $categoryId !== '') {
                $query->where('category_id', (int) $categoryId);
            }

            $minPrice = (float) ($query->min('unit_price') ?? 0);
            $maxPrice = (float) ($query->max('unit_price') ?? 0);

            return $this->successResponse([
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
            ], 'Price range retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch price range: ' . $e->getMessage(), [], 500);
        }
    }

    private function formatProductResponse(Product $product): array
    {
        $image = trim((string) ($product->product_images ?? ''));
        $slug = Str::slug((string) $product->product_name);

        return [
            'id' => (int) $product->product_id,
            'product_id' => (int) $product->product_id,
            'name' => (string) ($product->product_name ?? '-'),
            'slug' => $slug,
            'description' => (string) ($product->product_description ?? ''),
            'category_id' => (int) ($product->category_id ?? 0),
            'vendor_id' => (int) ($product->vendor_id ?? 0),
            'brand_id' => (int) ($product->brand_id ?? 0),
            'item_code' => (string) ($product->item_code ?? ''),
            'price' => (float) ($product->unit_price ?? 0),
            'effective_price' => (float) ($product->unit_price ?? 0),
            'cost_price' => (float) ($product->purchase_price ?? 0),
            'primary_image_url' => $image !== '' ? $image : null,
            'image_url' => $image !== '' ? $image : null,
            'rating_avg' => null,
            'created_at' => $product->created_at ? $product->created_at->toIso8601String() : null,
        ];
    }

    private function resolveCategoryName(int $categoryId): string
    {
        if ($categoryId <= 0) {
            return 'General';
        }

        $category = Category::query()->where('id', $categoryId)->first();
        if (!$category) {
            return 'General';
        }

        return (string) ($category->CategoryName ?? 'General');
    }
}
