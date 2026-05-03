@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Popular Discount Products | AddMagPro')
@section('mainsection')

<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                    <li class="breadcrumb-item active">Discount Products</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading mb-4">
            <h2>Popular Discount Products</h2>
            <p>Get great deals on top products</p>
        </div>
        @isset($products)
        <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
            @foreach($products as $product)
            @if(($product->purchase_price ?? 0) > 0)
            <div class="col">
                <div class="product-box productMain h-100">
                    <div class="product-image">
                        <a href="{{ route('product_detail', ['vendor_id' => $product->vendor_id, 'category_id' => $product->category_id]) }}">
                            <img src="{{ asset($product->product_images) }}" alt="{{ $product->product_name }}" class="img-fluid">
                        </a>
                        <ul class="product-option">
                            <li>
                                <a href="{{ route('add_to_wishlist', ['product_id' => $product->product_id]) }}" title="Wishlist">
                                    <i class="iconsax" data-icon-name="heart"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('add_to_cart', ['product_id' => $product->product_id, 'quantity' => 1]) }}" title="Add to Cart">
                                    <i class="iconsax" data-icon-name="basket-2"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product-detail">
                        <a href="{{ route('product_detail', ['vendor_id' => $product->vendor_id, 'category_id' => $product->category_id]) }}">
                            <h5 class="name">{{ $product->product_name }}</h5>
                        </a>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="price theme-color mb-0">&#8377;{{ number_format($product->selling_price ?? $product->purchase_price, 2) }}</h5>
                            @if(isset($product->selling_price) && $product->selling_price < $product->purchase_price)
                            <del class="text-muted" style="font-size:.8rem;">&#8377;{{ number_format($product->purchase_price, 2) }}</del>
                            @endif
                        </div>
                        <a href="{{ route('add_to_cart', ['product_id' => $product->product_id, 'quantity' => 1]) }}" class="btn w-100 btn-sm mt-2" style="background:var(--theme-color);color:#fff;">
                            <i class="iconsax me-1" data-icon-name="basket-2" style="font-size:.85rem;"></i>Add to Cart
                        </a>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @endisset
    </div>
</section>
@endsection
