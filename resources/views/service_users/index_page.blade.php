@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Home | AddMagPro')
@section('mainsection')
<!-- Hero Banner -->
<section style="background:linear-gradient(135deg,#1a1a2e 60%,#aa5500 100%);padding:4rem 0;color:#fff;">
    <div class="custom-container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h1 class="fw-bold" style="font-size:2.5rem;line-height:1.2;">
                    Shop Smart,<br><span style="color:var(--theme-color);">Earn More</span> with AddMagPro
                </h1>
                <p class="mt-3 mb-4" style="opacity:.85;font-size:1.05rem;">
                    Discover products, services, stores and exclusive discount vendors — all in one platform.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products_list') }}" class="btn py-2 px-4 fw-bold" style="background:var(--theme-color);color:#fff;">Shop Now</a>
                    <a href="{{ route('services_list') }}" class="btn py-2 px-4 fw-bold" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3);">Explore Services</a>
                </div>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block">
                <i class="ri-shopping-bag-3-line" style="font-size:10rem;opacity:.3;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
@if(isset($categories) && $categories->count())
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">Shop by Category</h4>
        <div class="row g-3">
            @foreach($categories->take(8) as $cat)
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('products_grid_view', $cat->category_id ?? $cat->id) }}" style="text-decoration:none;">
                    <div class="text-center p-3 rounded" style="background:#fff;box-shadow:0 2px 8px rgba(0,0,0,.06);transition:.2s;">
                        @if(isset($cat->category_image) && $cat->category_image)
                        <img src="{{ asset($cat->category_image) }}" alt="{{ $cat->category_name ?? '' }}" style="width:56px;height:56px;object-fit:cover;border-radius:10px;">
                        @else
                        <div style="width:56px;height:56px;background:rgba(255,153,0,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <i class="ri-archive-line" style="font-size:1.5rem;color:var(--theme-color);"></i>
                        </div>
                        @endif
                        <p class="mt-2 mb-0 fw-semibold" style="font-size:.82rem;color:#333;">{{ $cat->category_name ?? 'Category' }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Products -->
@if(isset($latest_products) && $latest_products->count())
<section class="section-b-space" style="background:#f9f9f9;padding-top:2rem;">
    <div class="custom-container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0">Latest Products</h4>
            <a href="{{ route('products_list') }}" style="color:var(--theme-color);font-weight:600;font-size:.9rem;">View All <i class="ri-arrow-right-line"></i></a>
        </div>
        <div class="row g-3">
            @foreach($latest_products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.06);">
                    <div style="height:180px;overflow:hidden;position:relative;">
                        <img src="{{ asset($product->product_images) }}" alt="{{ $product->product_name }}"
                            style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div class="p-3">
                        <p class="fw-semibold mb-1" style="font-size:.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $product->product_name }}</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="fw-bold" style="color:var(--theme-color);">&#8377;{{ $product->selling_price }}</span>
                            <form action="{{ route('add_to_cart', [$product->product_id, 1]) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:var(--theme-color);color:#fff;border:none;border-radius:6px;padding:4px 10px;font-size:.8rem;">
                                    <i class="ri-shopping-cart-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Services -->
@if(isset($service) && $service->count())
<section class="section-b-space">
    <div class="custom-container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0">Our Services</h4>
            <a href="{{ route('services_list') }}" style="color:var(--theme-color);font-weight:600;font-size:.9rem;">View All <i class="ri-arrow-right-line"></i></a>
        </div>
        <div class="row g-3">
            @foreach($service as $s)
            <div class="col-6 col-md-3">
                <a href="{{ route('service_fullview', $s->service_id) }}" style="text-decoration:none;">
                    <div class="text-center p-3 rounded" style="background:#fff;box-shadow:0 2px 8px rgba(0,0,0,.06);">
                        @if($s->service_category_image)
                        <img src="{{ asset($s->service_category_image) }}" alt="{{ $s->service_name }}" style="width:64px;height:64px;object-fit:cover;border-radius:12px;">
                        @else
                        <div style="width:64px;height:64px;background:rgba(255,153,0,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <i class="ri-settings-3-line" style="font-size:1.8rem;color:var(--theme-color);"></i>
                        </div>
                        @endif
                        <p class="mt-2 mb-0 fw-semibold" style="font-size:.85rem;color:#333;">{{ $s->service_name }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
