@extends('app_layout')

@section('content')
@php
/**
* @var \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $trending_products
* @var \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $new_products
*/
@endphp
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Hero Banner -->
    <section class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center">
                <div class="p-8 md:p-12 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Shop Smart, Save More</h1>
                    <p class="text-lg opacity-90 mb-6">Discover amazing products at unbeatable prices with verified sellers and secure payments.</p>
                    <div class="flex gap-4">
                        <a href="/products" class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                            Start Shopping
                        </a>
                        <a href="/referral" class="bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-800">
                            Earn Rewards
                        </a>
                    </div>
                </div>
                <div class="hidden md:block p-8">
                    <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=500" alt="Shopping" class="w-full rounded-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Shop by Category</h2>
            <a href="/products" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">View All</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <a href="/products?category=electronics" class="text-center bg-white p-4 rounded-lg hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-2"><i class="fas fa-laptop text-blue-600"></i></div>
                <p class="text-sm font-medium text-gray-700">Electronics</p>
            </a>
            <a href="/products?category=fashion" class="text-center bg-white p-4 rounded-lg hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-2"><i class="fas fa-shirt text-purple-600"></i></div>
                <p class="text-sm font-medium text-gray-700">Fashion</p>
            </a>
            <a href="/products?category=home" class="text-center bg-white p-4 rounded-lg hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-2"><i class="fas fa-home text-orange-600"></i></div>
                <p class="text-sm font-medium text-gray-700">Home</p>
            </a>
            <a href="/products?category=beauty" class="text-center bg-white p-4 rounded-lg hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-2"><i class="fas fa-spa text-pink-600"></i></div>
                <p class="text-sm font-medium text-gray-700">Beauty</p>
            </a>
            <a href="/products?category=books" class="text-center bg-white p-4 rounded-lg hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-2"><i class="fas fa-book text-green-600"></i></div>
                <p class="text-sm font-medium text-gray-700">Books</p>
            </a>
            <a href="/products?category=sports" class="text-center bg-white p-4 rounded-lg hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-2"><i class="fas fa-basketball text-red-600"></i></div>
                <p class="text-sm font-medium text-gray-700">Sports</p>
            </a>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Trending Now</h2>
            <a href="/products?sort=trending" class="text-blue-600 text-sm font-semibold">View All</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse($trending_products ?? [] as $product)
            <a href="/products/{{ $product->id }}" class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition-shadow group">
                <div class="relative overflow-hidden bg-gray-100 aspect-square">
                    <img src="https://via.placeholder.com/200?text={{ $product->name ?? 'Product' }}" alt="{{ $product->name ?? 'Product' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                    @if($product->discount_percent > 0)
                    <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                        -{{ (int)$product->discount_percent }}%
                    </div>
                    @endif
                </div>
                <div class="p-3">
                    <h3 class="text-sm font-medium text-gray-900 line-clamp-2">{{ $product->name }}</h3>
                    <div class="flex justify-between items-end mt-2">
                        <div>
                            <p class="text-lg font-bold text-gray-900">₹{{ (int)($product->final_price ?? $product->price) }}</p>
                            @if($product->discount_percent > 0)
                            <p class="text-xs text-gray-500 line-through">₹{{ (int)$product->price }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-5 text-center text-gray-500 py-8">
                <p>No products available</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Special Offers -->
    <section class="mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-lg p-8 text-white">
                <h3 class="text-2xl font-bold mb-2">Weekend Flash Sale</h3>
                <p class="opacity-90 mb-4">Get up to 50% off on selected items</p>
                <a href="/products?filter=flashsale" class="inline-block bg-white text-purple-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                    Shop Now
                </a>
            </div>
            <div class="bg-gradient-to-r from-orange-600 to-orange-800 rounded-lg p-8 text-white">
                <h3 class="text-2xl font-bold mb-2">Referral Program</h3>
                <p class="opacity-90 mb-4">Earn rewards by referring friends and family</p>
                <a href="/referral" class="inline-block bg-white text-orange-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">New Arrivals</h2>
            <a href="/products?sort=newest" class="text-blue-600 text-sm font-semibold">View All</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse($new_products ?? [] as $product)
            <a href="/products/{{ $product->id }}" class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition-shadow group">
                <div class="relative overflow-hidden bg-gray-100 aspect-square">
                    <img src="https://via.placeholder.com/200?text={{ $product->name ?? 'Product' }}" alt="{{ $product->name ?? 'Product' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                    <div class="absolute top-2 left-2 bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold">NEW</div>
                </div>
                <div class="p-3">
                    <h3 class="text-sm font-medium text-gray-900 line-clamp-2">{{ $product->name }}</h3>
                    <p class="text-lg font-bold text-gray-900 mt-2">₹{{ (int)($product->final_price ?? $product->price) }}</p>
                </div>
            </a>
            @empty
            <div class="col-span-5 text-center text-gray-500 py-8">
                <p>No new products</p>
            </div>
            @endforelse
        </div>
    </section>

</div>
@endsection