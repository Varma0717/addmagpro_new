@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Category Products | AddMagPro')
@section('mainsection')

<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products_list') }}">Products</a></li>
                    <li class="breadcrumb-item active">Category</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="section-b-space">
    <div class="custom-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">{{ $items_found ?? 0 }} Product(s) Found</h5>
            <a href="{{ route('products_list') }}" class="btn btn-outline-secondary btn-sm">
                <i class="ri-arrow-left-line me-1"></i>Back
            </a>
        </div>
        @isset($products)
        @if(count($products) > 0)
        <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
            @foreach($products as $product)
            <div class="col">
                <div class="product-box productMain h-100">
                    <div class="product-image">
                        <a href="{{ route('product_detail', ['vendor_id' => $product->vendor_id, 'category_id' => $product->category_id]) }}">
                            <img src="{{ asset($product->product_images) }}" alt="{{ $product->product_name }}" class="img-fluid">
                        </a>
                        <ul class="product-option">
                            <li title="Wishlist">
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
                        <h5 class="price theme-color">&#8377;{{ number_format($product->selling_price ?? $product->purchase_price ?? 0, 2) }}</h5>
                        <a href="{{ route('add_to_cart', ['product_id' => $product->product_id, 'quantity' => 1]) }}" class="btn w-100 btn-sm mt-1" style="background:var(--theme-color);color:#fff;">Add to Cart</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="ri-inbox-line" style="font-size:4rem;color:#ccc;"></i>
            <h5 class="mt-3 text-muted">No products in this category</h5>
            <a href="{{ route('products_list') }}" class="btn mt-2" style="background:var(--theme-color);color:#fff;">Browse All Categories</a>
        </div>
        @endif
        @endisset
    </div>
</section>
@endsection
