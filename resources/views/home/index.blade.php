@extends('app_layout')

@section('content')
@php
/**
* @var \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $trending_products
* @var \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $new_products
*/
@endphp

<div class="container-max py-12">

    <!-- HERO SECTION -->
    <section class="hero section mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
            <div class="hero-content">
                <h1>Shop Smart, Save More</h1>
                <p>Discover amazing products at unbeatable prices with verified sellers and secure payments</p>
                <div class="hero-cta">
                    <a href="/products" class="btn btn-secondary">
                        <i class="fas fa-shopping-bag"></i>Start Shopping
                    </a>
                    <a href="/referral" class="btn btn-outline">
                        <i class="fas fa-gift"></i>Earn Rewards
                    </a>
                </div>
            </div>
            <div class="hidden md:flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=600&h=400&fit=crop" alt="Shopping illustration" class="rounded-2xl shadow-lg" style="max-width: 100%;">
            </div>
        </div>
    </section>

    <!-- CATEGORIES SECTION -->
    <section class="section">
        <div class="section-header">
            <h2>Shop by Category</h2>
            <a href="/products" class="text-primary font-semibold hover:text-primary-dark transition">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="category-grid">
            <a href="/products?category=electronics" class="category-card">
                <i class="fas fa-laptop" style="color: #0366d6;"></i>
                <span class="category-card-name">Electronics</span>
            </a>
            <a href="/products?category=fashion" class="category-card">
                <i class="fas fa-shirt" style="color: #9333ea;"></i>
                <span class="category-card-name">Fashion</span>
            </a>
            <a href="/products?category=home" class="category-card">
                <i class="fas fa-home" style="color: #f97316;"></i>
                <span class="category-card-name">Home & Kitchen</span>
            </a>
            <a href="/products?category=beauty" class="category-card">
                <i class="fas fa-spa" style="color: #ec4899;"></i>
                <span class="category-card-name">Beauty</span>
            </a>
            <a href="/products?category=books" class="category-card">
                <i class="fas fa-book" style="color: #22c55e;"></i>
                <span class="category-card-name">Books</span>
            </a>
            <a href="/products?category=sports" class="category-card">
                <i class="fas fa-basketball" style="color: #ef4444;"></i>
                <span class="category-card-name">Sports</span>
            </a>
        </div>
    </section>

    <!-- TRENDING PRODUCTS SECTION -->
    <section class="section">
        <div class="section-header">
            <h2>Trending Now</h2>
            <a href="/products?sort=trending" class="text-primary font-semibold hover:text-primary-dark transition">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        @if(count($trending_products ?? []) > 0)
        <div class="product-grid">
            @foreach($trending_products as $product)
            <a href="/products/{{ $product->id }}" class="product-card">
                <div class="product-image-container">
                    <img src="https://via.placeholder.com/200?text={{ urlencode($product->name ?? 'Product') }}" alt="{{ $product->name ?? 'Product' }}" class="product-image">
                    @if(isset($product->discount_percent) && $product->discount_percent > 0)
                    <div class="product-badge">-{{ (int)$product->discount_percent }}%</div>
                    @endif
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $product->name ?? 'Unnamed Product' }}</h3>
                    <div class="product-price-container">
                        <div>
                            <div class="product-price">₹{{ (int)($product->final_price ?? $product->price ?? 0) }}</div>
                            @if(isset($product->discount_percent) && $product->discount_percent > 0)
                            <div class="product-original-price">₹{{ (int)($product->price ?? 0) }}</div>
                            @endif
                        </div>
                        @if(isset($product->rating) && $product->rating > 0)
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <span>{{ number_format($product->rating, 1) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-neutral-300 mb-4"></i>
            <p class="text-neutral-500 text-lg">No trending products available yet</p>
        </div>
        @endif
    </section>

    <!-- PROMOTIONAL BANNERS -->
    <section class="section mb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="/products?filter=flashsale" class="group block">
                <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-2xl p-12 text-white overflow-hidden relative hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative z-10">
                        <p class="text-sm font-semibold text-purple-200 mb-2 uppercase tracking-widest">Limited Time Offer</p>
                        <h3 class="text-4xl font-bold mb-3">Weekend Flash Sale</h3>
                        <p class="text-lg text-purple-100 mb-6">Get up to 50% off on selected items</p>
                        <span class="inline-flex items-center gap-2 bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-purple-50 transition">
                            Shop Now <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                    <div class="absolute top-0 right-0 text-purple-700 opacity-10">
                        <i class="fas fa-shopping-cart text-9xl"></i>
                    </div>
                </div>
            </a>
            <a href="/referral" class="group block">
                <div class="bg-gradient-to-r from-orange-600 to-orange-800 rounded-2xl p-12 text-white overflow-hidden relative hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative z-10">
                        <p class="text-sm font-semibold text-orange-200 mb-2 uppercase tracking-widest">Earn Passive Income</p>
                        <h3 class="text-4xl font-bold mb-3">Referral Program</h3>
                        <p class="text-lg text-orange-100 mb-6">Earn rewards by referring friends and family</p>
                        <span class="inline-flex items-center gap-2 bg-white text-orange-600 px-6 py-3 rounded-lg font-semibold hover:bg-orange-50 transition">
                            Learn More <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                    <div class="absolute top-0 right-0 text-orange-700 opacity-10">
                        <i class="fas fa-gift text-9xl"></i>
                    </div>
                </div>
            </a>
        </div>
    </section>

    <!-- NEW ARRIVALS SECTION -->
    <section class="section">
        <div class="section-header">
            <h2>New Arrivals</h2>
            <a href="/products?sort=newest" class="text-primary font-semibold hover:text-primary-dark transition">
                View All <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        @if(count($new_products ?? []) > 0)
        <div class="product-grid">
            @foreach($new_products as $product)
            <a href="/products/{{ $product->id }}" class="product-card">
                <div class="product-image-container">
                    <img src="https://via.placeholder.com/200?text={{ urlencode($product->name ?? 'Product') }}" alt="{{ $product->name ?? 'Product' }}" class="product-image">
                    <div class="product-badge" style="background-color: #3b82f6; top: 12px; left: 12px; right: auto;">NEW</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $product->name ?? 'Unnamed Product' }}</h3>
                    <div class="product-price-container">
                        <div class="product-price">₹{{ (int)($product->final_price ?? $product->price ?? 0) }}</div>
                        @if(isset($product->rating) && $product->rating > 0)
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <span>{{ number_format($product->rating, 1) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-inbox text-4xl text-neutral-300 mb-4"></i>
            <p class="text-neutral-500 text-lg">No new products available yet</p>
        </div>
        @endif
    </section>

</div>

@endsection