@extends('service_user_dashboard_layouts.master')
@section('page_title', 'My Wishlist | AddMagPro')
@section('mainsection')

<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                    <li class="breadcrumb-item active">My Wishlist</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="section-b-space">
    <div class="custom-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">My Wishlist
                @isset($wishlist_count)
                <span class="badge ms-2" style="background:var(--theme-color);font-size:.75rem;">{{ $wishlist_count }}</span>
                @endisset
            </h4>
            <a href="{{ route('products_list') }}" class="btn btn-outline-secondary btn-sm">
                <i class="ri-shopping-bag-line me-1"></i>Continue Shopping
            </a>
        </div>

        @isset($wishlist_products)
        @if(count($wishlist_products) > 0)
        <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
            @foreach($wishlist_products as $item)
            <div class="col">
                <div class="product-box productMain h-100">
                    <div class="product-image">
                        <a href="{{ route('product_detail', ['vendor_id' => $item->vendor_id ?? 0, 'category_id' => $item->category_id ?? 0]) }}">
                            <img src="{{ asset($item->product_images) }}" alt="{{ $item->product_name }}" class="img-fluid">
                        </a>
                        <ul class="product-option">
                            <li title="Remove from Wishlist">
                                <a href="{{ route('remove_item_wishlist', ['product_id' => $item->product_id]) }}">
                                    <i class="iconsax" data-icon-name="trash"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="product-detail">
                        <a href="{{ route('product_detail', ['vendor_id' => $item->vendor_id ?? 0, 'category_id' => $item->category_id ?? 0]) }}">
                            <h5 class="name">{{ $item->product_name }}</h5>
                        </a>
                        <h5 class="price theme-color">&#8377;{{ number_format($item->selling_price ?? $item->purchase_price ?? 0, 2) }}</h5>
                        <div class="d-flex gap-2 mt-2">
                            <a href="{{ route('add_to_cart', ['product_id' => $item->product_id, 'quantity' => 1]) }}" class="btn flex-grow-1 btn-sm" style="background:var(--theme-color);color:#fff;">
                                <i class="iconsax me-1" data-icon-name="basket-2" style="font-size:.85rem;"></i>Add to Cart
                            </a>
                            <a href="{{ route('remove_item_wishlist', ['product_id' => $item->product_id]) }}" class="btn btn-outline-danger btn-sm">
                                <i class="ri-delete-bin-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="ri-heart-line" style="font-size:4rem;color:#ccc;"></i>
            <h5 class="mt-3 text-muted">Your wishlist is empty</h5>
            <p class="text-muted">Add items to your wishlist to save them for later</p>
            <a href="{{ route('products_list') }}" class="btn mt-2" style="background:var(--theme-color);color:#fff;">Browse Products</a>
        </div>
        @endif
        @endisset
    </div>
</section>
@endsection
