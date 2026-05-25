@extends('app_layout')

@section('content')
@php
/**
* @var \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
*/
@endphp
<div class="max-w-7xl mx-auto px-4 py-8 pt-12">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Products</h1>
        <p class="text-gray-600">Browse our collection of products</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar Filters -->
        <aside class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
                <!-- Categories -->
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Categories</h3>
                    <ul class="space-y-2">
                        <li><a href="/products" class="text-gray-600 hover:text-blue-600 text-sm">All Products</a></li>
                        <li><a href="/products?category=electronics" class="text-gray-600 hover:text-blue-600 text-sm">Electronics</a></li>
                        <li><a href="/products?category=fashion" class="text-gray-600 hover:text-blue-600 text-sm">Fashion</a></li>
                        <li><a href="/products?category=home" class="text-gray-600 hover:text-blue-600 text-sm">Home & Garden</a></li>
                        <li><a href="/products?category=beauty" class="text-gray-600 hover:text-blue-600 text-sm">Beauty</a></li>
                    </ul>
                </div>

                <!-- Price Range -->
                <div class="border-t pt-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Price Range</h3>
                    <form method="get" class="space-y-3">
                        <input type="hidden" name="page" value="{{ request('page') }}">
                        <div>
                            <label class="text-sm text-gray-600">Min Price</label>
                            <input
                                type="number"
                                name="price_min"
                                value="{{ request('price_min') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
                                placeholder="0">
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Max Price</label>
                            <input
                                type="number"
                                name="price_max"
                                value="{{ request('price_max') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm"
                                placeholder="10000">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded text-sm font-semibold hover:bg-blue-700">
                            Apply
                        </button>
                    </form>
                </div>

                <!-- Rating -->
                <div class="border-t pt-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Rating</h3>
                    <ul class="space-y-2">
                        <li><label class="flex items-center text-sm text-gray-600">
                                <input type="checkbox" class="mr-2"> <i class="fas fa-star text-yellow-400 mr-1"></i>4★ & above
                            </label></li>
                        <li><label class="flex items-center text-sm text-gray-600">
                                <input type="checkbox" class="mr-2"> <i class="fas fa-star text-yellow-400 mr-1"></i>3★ & above
                            </label></li>
                        <li><label class="flex items-center text-sm text-gray-600">
                                <input type="checkbox" class="mr-2"> <i class="fas fa-star text-yellow-400 mr-1"></i>2★ & above
                            </label></li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="md:col-span-3">
            <!-- Sort -->
            <div class="mb-6 flex justify-between items-center">
                <p class="text-gray-600 text-sm">Showing products</p>
                <select onchange="window.location.href='/products?sort=' + this.value" class="px-3 py-2 border border-gray-300 rounded text-sm">
                    <option value="">Sort By</option>
                    <option value="newest">Newest First</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="popular">Most Popular</option>
                </select>
            </div>

            <!-- Products -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($products ?? [] as $product)
                <a href="/products/{{ $product->id }}" class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition-shadow group">
                    <div class="relative overflow-hidden bg-gray-100 aspect-square">
                        <img src="https://via.placeholder.com/250?text={{ urlencode($product->name ?? 'Product') }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                        @if($product->discount_percent > 0)
                        <div class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                            -{{ (int)$product->discount_percent }}%
                        </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900 line-clamp-2">{{ $product->name }}</h3>
                        @if($product->rating > 0)
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star text-xs {{ $i < (int)$product->rating ? '' : 'opacity-30' }}"></i>
                                    @endfor
                            </div>
                            <span class="text-xs text-gray-600 ml-1">({{ $product->review_count }})</span>
                        </div>
                        @endif
                        <div class="mt-3 flex justify-between items-end">
                            <div>
                                <p class="text-lg font-bold text-gray-900">₹{{ (int)($product->final_price ?? $product->price) }}</p>
                                @if($product->discount_percent > 0)
                                <p class="text-xs text-gray-500 line-through">₹{{ (int)$product->price }}</p>
                                @endif
                            </div>
                            <button onclick="addToCart('{{ $product->id }}')" class="text-blue-600 hover:text-blue-700">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No products found</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($products) && $products->hasPages())
            <div class="mt-8 flex justify-center gap-2">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    function addToCart(productId) {
        const token = localStorage.getItem('auth_token');
        if (!token) {
            window.location.href = '/login';
            return;
        }

        fetch('/api/v1/cart/add', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        }).then(r => r.json()).then(data => {
            if (data.success) alert('Added to cart!');
        }).catch(e => console.error(e));
    }
</script>
@endsection