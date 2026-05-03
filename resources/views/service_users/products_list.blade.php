@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Products | AddMagPro')
@section('mainsection')

{{-- Breadcrumb --}}
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

{{-- Categories Grid --}}
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading mb-4">
            <h2>Shop by Category</h2>
            <p>Browse products across all categories</p>
        </div>
        <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
            @isset($vendor_categories)
            @foreach($vendor_categories as $cat)
            <div class="col">
                <a href="{{ route('products_grid_view', ['category_id' => $cat->id]) }}" class="text-decoration-none">
                    <div class="category-box text-center p-3 bg-white rounded shadow-sm" style="transition:transform .2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
                        <div class="overflow-hidden rounded mb-2" style="height:120px;">
                            <img src="{{ asset($cat->ImageURL) }}" alt="{{ $cat->CategoryName }}" class="img-fluid w-100 h-100" style="object-fit:cover;">
                        </div>
                        <h6 class="fw-bold mb-0 mt-2" style="color:var(--title-color);font-size:.9rem;">{{ $cat->CategoryName }}</h6>
                    </div>
                </a>
            </div>
            @endforeach
            @endisset
        </div>
    </div>
</section>

{{-- All Products Highlight --}}
@isset($products)
@if(count($products) > 0)
<section class="section-b-space" style="background:var(--section-bg-color,#f9f9f6);">
    <div class="custom-container py-4">
        <div class="section-heading mb-4">
            <h2>All Products</h2>
        </div>
        <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
            @foreach($products->take(20) as $product)
            <div class="col">
                <div class="product-box productMain h-100">
                    <div class="product-image">
                        <a href="{{ route('product_detail', ['vendor_id' => $product->vendor_id, 'category_id' => $product->category_id]) }}">
                            <img src="{{ asset($product->product_images) }}" alt="{{ $product->product_name }}" class="img-fluid">
                        </a>
                        <ul class="product-option">
                            <li title="Add to Wishlist">
                                <a href="{{ route('add_to_wishlist', ['product_id' => $product->product_id]) }}">
                                    <i class="iconsax" data-icon-name="heart"></i>
                                </a>
                            </li>
                            <li title="Add to Cart">
                                <a href="{{ route('add_to_cart', ['product_id' => $product->product_id, 'quantity' => 1]) }}">
                                    <i class="iconsax" data-icon-name="basket-2"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product-detail">
                        <a href="{{ route('product_detail', ['vendor_id' => $product->vendor_id, 'category_id' => $product->category_id]) }}">
                            <h5 class="name">{{ $product->product_name }}</h5>
                        </a>
                        <h5 class="price theme-color">&#8377;{{ number_format($product->purchase_price ?? 0, 2) }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endisset

@endsection
