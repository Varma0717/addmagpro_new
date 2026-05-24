@extends('service_user_dashboard_layouts.master')

@section('page_title', 'AddMagPro | Earn While You Shop & Share')

@section('extra_css')
<style>
    .hero-swiper {
        position: relative;
    }

    .hero-swiper .swiper-slide img {
        width: 100%;
        max-height: 480px;
        object-fit: cover;
    }

    .member-card {
        border-radius: 12px;
        transition: transform .2s;
        text-decoration: none;
    }

    .member-card:hover {
        transform: translateY(-4px);
    }

    .stats-strip {
        background: #fff4e6;
        color: #222;
        padding: 2rem 0;
    }

    .stats-strip .stat-item h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: #aa5500;
    }

    .stats-strip .stat-item p {
        margin: 0;
        font-size: .9rem;
        color: #444;
    }

    .section-heading {
        text-align: center;
        margin-bottom: 2rem;
    }

    .section-heading h2 {
        font-weight: 700;
        color: var(--title-color);
    }

    .section-heading p {
        color: var(--content-color);
    }

    .vendor-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
    }

    .vendor-card {
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .07);
    }

    .discount-vendor-card {
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .07);
    }

    .discount-vendor-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .discount-badge {
        background: var(--theme-color);
        color: #fff;
        font-weight: 700;
        padding: .3rem .8rem;
        border-radius: 4px;
        display: inline-block;
        margin-top: .4rem;
    }

    .event-card img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        border-radius: 8px;
    }

    .banner-full img {
        width: 100%;
        border-radius: 8px;
    }

    .gallery-grid img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>
@endsection

@section('mainsection')

{{-- ====== 1. HERO SWIPER BANNER ====== --}}
<section class="hero-swiper section-b-space">
    <div class="swiper hero-slider" id="heroSlider">
        <div class="swiper-wrapper">
            @isset($main_slider_banner)
            @foreach($main_slider_banner as $banner)
            <div class="swiper-slide">
                <a href="{{ $banner->banner_url ?? '#' }}">
                    <img src="{{ asset($banner->banner_image) }}" alt="Banner" loading="lazy">
                </a>
            </div>
            @endforeach
            @endisset
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

{{-- ====== 2. MEMBERSHIP CATEGORY STRIP ====== --}}
<section class="category-section section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>Explore Memberships</h2>
            <p>Choose your category and start earning</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('services_list') }}" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-briefcase-4-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Services</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('user_stores_list') }}" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-store-2-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Stores</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('products_list') }}" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-box-3-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Products</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('classifieds_list') }}" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-file-list-3-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Classifieds</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('popular_discounts_products') }}" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-discount-percent-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Discounts</h6>
                </a>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ route('vendors_full_view') }}" class="member-card d-flex flex-column align-items-center text-center p-4 bg-white rounded-3 shadow-sm text-decoration-none" style="transition:transform .2s,box-shadow .2s;">
                    <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:72px;height:72px;background:rgba(var(--primary-color),.1);">
                        <i class="ri-building-2-line" style="font-size:2rem;color:var(--theme-color);"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color:var(--title-color);">Vendors</h6>
                </a>
            </div>
        </div>
    </div>
</section>
<style>
    .member-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, .1) !important;
    }

    .member-card:hover .ri-briefcase-4-line,
    .member-card:hover .ri-store-2-line,
    .member-card:hover .ri-box-3-line,
    .member-card:hover .ri-file-list-3-line,
    .member-card:hover .ri-discount-percent-line,
    .member-card:hover .ri-building-2-line {
        transform: scale(1.15);
        transition: transform .2s;
    }
</style>

{{-- ====== 3. ADS GALLERY BANNER ====== --}}
@isset($ads_gallery)
@if(count($ads_gallery) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="swiper" id="adsSlider">
            <div class="swiper-wrapper">
                @foreach($ads_gallery as $ad)
                <div class="swiper-slide">
                    <a href="{{ $ad->ads_banner_url ?? '#' }}">
                        <img src="{{ asset($ad->ads_banner_image) }}" alt="Ads Banner" class="img-fluid rounded" style="width:100%;">
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 4. BANNER 1 - GROCERIES ====== --}}
@isset($banner1)
@if(count($banner1) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>Groceries</h2>
            <p>Get 100% cashback on grocery products</p>
        </div>
        <div class="banner-full">
            <a href="{{ $banner1[0]->banner_url ?? '#' }}">
                <img src="{{ asset($banner1[0]->banner_image) }}" alt="Groceries Banner" class="img-fluid">
            </a>
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 5. VENDOR BANNERS ====== --}}
@isset($vendor_banners)
@if(count($vendor_banners) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>{{ $headings[1]->heading ?? 'Featured Vendors' }}</h2>
        </div>
        <div class="row g-3">
            @foreach($vendor_banners as $vb)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="vendor-card">
                    <a href="{{ route('products_list_vendor', ['vendor_id' => $vb->vendor_id]) }}">
                        <img src="{{ asset($vb->ImageURL) }}" alt="Vendor">
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('vendors_full_view') }}" class="btn btn-outline-dark">View All Vendors</a>
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 6. BANNER 2 - DISCOUNT STORES ====== --}}
@isset($banner2)
@if(count($banner2) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>{{ $headings[2]->heading ?? 'Discount Stores' }}</h2>
            <p>Select your best discount provider from the market</p>
        </div>
        <div class="banner-full">
            <a href="{{ $banner2[0]->banner_url ?? '#' }}">
                <img src="{{ asset($banner2[0]->banner_image) }}" alt="Discounts Banner" class="img-fluid">
            </a>
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 7. DISCOUNT VENDOR SHOPS ====== --}}
@isset($discount_vendor_banners)
@if(count($discount_vendor_banners) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="row g-3">
            @foreach($discount_vendor_banners as $dvb)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="discount-vendor-card">
                    <a href="{{ route('discount_vendor_detail', ['vendor_id' => $dvb->vendor_id]) }}">
                        <img src="{{ $dvb->banner_image }}" alt="{{ $dvb->shop_name }}">
                    </a>
                    <div class="p-2 text-center">
                        <h6 class="fw-bold mb-1">{{ $dvb->shop_name }}</h6>
                        <p class="text-muted mb-1" style="font-size:.8rem;">{{ $dvb->location }}</p>
                        <span class="discount-badge">{{ $dvb->discount_margin/2 }}% Discount</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('popular_discounts_products') }}" class="btn" style="background:var(--theme-color);color:#fff;">View All Discount Stores</a>
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 8. BANNER 3 - 100% CASHBACK PRODUCTS ====== --}}
@isset($banner3)
@if(count($banner3) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>100% Cashback Products</h2>
        </div>
        <div class="banner-full">
            <a href="{{ $banner3[0]->banner_url ?? '#' }}">
                <img src="{{ asset($banner3[0]->banner_image) }}" alt="Cashback Banner" class="img-fluid">
            </a>
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 9. GADGET GALLERY ====== --}}
@isset($gadget_gallery)
@if(count($gadget_gallery) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="row g-2">
            @foreach($gadget_gallery->take(4) as $g)
            <div class="col-6 col-md-3">
                <a href="{{ $g->gadget_gallery_url ?? '#' }}">
                    <img src="{{ asset($g->gadget_gallery_image) }}" alt="Gallery" class="img-fluid rounded" style="height:160px;width:100%;object-fit:cover;">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 10. PRODUCT TABS: Latest + Special Offers ====== --}}
<section class="product-tab-section section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>{{ $headings[3]->heading ?? 'Shop Our Products' }}</h2>
        </div>
        <div class="row">
            <div class="col-auto mx-auto">
                <ul class="nav nav-pills flex-nowrap" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-latest" type="button">New Arrivals</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-special" type="button">Special Offers</button>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="tab-latest">
                <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    @isset($latest_products)
                    @foreach($latest_products as $lp)
                    <div class="col">
                        <div class="product-box productMain h-100">
                            <div class="product-image">
                                <a href="{{ route('latest_products_view') }}">
                                    <img src="{{ $lp->product_images ?? asset('assets/kartify/images/product/placeholder.png') }}" class="img-fluid" alt="{{ $lp->product_name }}">
                                </a>
                                <ul class="product-option">
                                    <li title="Wishlist">
                                        <a href="{{ route('add_to_wishlist', ['product_id' => $lp->product_id]) }}">
                                            <i class="iconsax" data-icon-name="heart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-detail">
                                <a href="{{ route('latest_products_view') }}">
                                    <h5 class="name">{{ $lp->product_name }}</h5>
                                </a>
                                <h5 class="price theme-color">&#8377;{{ number_format($lp->selling_price ?? $lp->purchase_price, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endisset
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('latest_products_view') }}" class="btn btn-outline-dark">View All New Arrivals</a>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-special">
                <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    @isset($products)
                    @foreach($products as $product)
                    @if(($product->purchase_price ?? 0) > 3000)
                    <div class="col">
                        <div class="product-box productMain h-100">
                            <div class="product-image">
                                <a href="{{ route('product_detail', ['vendor_id' => $product->vendor_id, 'category_id' => $product->category_id]) }}">
                                    <img src="{{ $product->product_images ?? asset('assets/kartify/images/product/placeholder.png') }}" class="img-fluid" alt="{{ $product->product_name }}">
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
                                <h5 class="price theme-color">&#8377;{{ number_format($product->purchase_price, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endisset
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('products_list') }}" class="btn btn-outline-dark">View All Products</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====== 11. CATEGORY SLIDER ====== --}}
@isset($categories)
@if(count($categories) > 0)
<section class="section-b-space" style="background:var(--section-bg-color,#f9f9f6);">
    <div class="custom-container py-4">
        <div class="section-heading">
            <h2>{{ $headings[4]->heading ?? 'Shop by Category' }}</h2>
            <p>Select your favourite category and start shopping</p>
        </div>
        <div class="swiper" id="categorySlider" style="padding-bottom:2.25rem;">
            <div class="swiper-wrapper">
                @foreach($categories as $cat)
                <div class="swiper-slide text-center">
                    <a href="{{ route('top_category_products_list', ['category_id' => $cat->id]) }}" class="d-block text-decoration-none">
                        <img src="{{ $cat->ImageURL }}" class="img-fluid rounded-circle" alt="{{ $cat->CategoryName }}" style="height:80px;width:80px;object-fit:cover;">
                        <h6 class="mt-2 fw-bold" style="color:var(--title-color);font-size:.8rem;">{{ $cat->CategoryName }}</h6>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 12. STORE GALLERY ====== --}}
@isset($store_gallery)
@if(count($store_gallery) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>{{ $headings[6]->heading ?? 'Popular Stores' }}</h2>
            <p>Select your best speciality store from the market</p>
        </div>
        <div class="row g-3">
            @foreach($store_gallery as $sg)
            <div class="col-6 col-md-4 col-lg-3">
                <img src="{{ asset($sg['store_image']) }}" alt="Store" class="img-fluid rounded gallery-grid">
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 13. BANNER 4 ====== --}}
@isset($banner4)
@if(count($banner4) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>{{ $headings[7]->heading ?? 'Speciality Stores' }}</h2>
        </div>
        <div class="banner-full">
            <a href="{{ $banner4[0]->banner_url ?? '#' }}">
                <img src="{{ asset($banner4[0]->banner_image) }}" alt="Banner" class="img-fluid">
            </a>
        </div>
        @isset($store_gallery_mini)
        <div class="row g-2 mt-2">
            @foreach($store_gallery_mini as $sgm)
            <div class="col-6 col-md-3">
                <img src="{{ asset($sgm['store_image']) }}" alt="Store" class="img-fluid rounded">
            </div>
            @endforeach
        </div>
        @endisset
    </div>
</section>
@endif
@endisset

{{-- ====== 14. EVENT BANNERS ====== --}}
@isset($event_banners)
@if(count($event_banners) > 0)
<section class="section-b-space">
    <div class="custom-container">
        <div class="section-heading">
            <h2>{{ $headings[8]->heading ?? 'Upcoming Events' }}</h2>
            <p>Do not miss out on our exciting events</p>
        </div>
        <div class="row g-3">
            @foreach($event_banners as $ev)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="event-card">
                    <img src="{{ asset($ev->event_banner_image) }}" alt="Event" class="img-fluid rounded">
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endisset

{{-- ====== 15. STATS STRIP ====== --}}
<section class="stats-strip">
    <div class="custom-container">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3 stat-item">
                <h3>{{ $visitor_users_count ?? '0' }}+</h3>
                <p>Total Visitors</p>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <h3>{{ $active_users_count ?? '0' }}+</h3>
                <p>Total Joinings</p>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <h3>{{ $total_joinings ?? '0' }}+</h3>
                <p>Active Members</p>
            </div>
            <div class="col-6 col-md-3 stat-item">
                <h3>100%</h3>
                <p>Cashback Guaranteed</p>
            </div>
        </div>
    </div>
</section>

{{-- ====== 16. JOIN CTA ====== --}}
<section class="section-b-space section-t-space">
    <div class="custom-container">
        <div class="text-center py-4 px-3 rounded" style="background:linear-gradient(135deg,#aa5500 0%,#7a2800 100%);">

            <h2 class="fw-bold mb-2" style="color:#fff!important;">Join AddMagPro Today</h2>
            <p class="mb-3" style="color:rgba(255,255,255,0.9)!important;">Earn while you shop, refer friends, and grow your income!</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                @if(!session('service_user_id'))
                <a href="{{ route('service_user_registration') }}" class="btn btn-light fw-bold" style="color:var(--theme-color);">Register Now</a>
                <a href="{{ route('service_user_login') }}" class="btn btn-outline-light fw-bold">Sign In</a>
                @else
                <a href="{{ route('team_details') }}" class="btn btn-light fw-bold" style="color:var(--theme-color);">Refer &amp; Earn</a>
                <a href="{{ route('products_list') }}" class="btn btn-outline-light fw-bold">Shop Now</a>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@section('extra_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('heroSlider')) {
            new Swiper('#heroSlider', {
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            });
        }
        if (document.getElementById('adsSlider')) {
            new Swiper('#adsSlider', {
                loop: true,
                autoplay: {
                    delay: 3000
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                slidesPerView: 1,
                spaceBetween: 10
            });
        }
        if (document.getElementById('categorySlider')) {
            new Swiper('#categorySlider', {
                slidesPerView: 2,
                spaceBetween: 12,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                breakpoints: {
                    480: {
                        slidesPerView: 3
                    },
                    768: {
                        slidesPerView: 4
                    },
                    992: {
                        slidesPerView: 6
                    },
                    1200: {
                        slidesPerView: 8
                    }
                }
            });
        }
    });
</script>
@endsection