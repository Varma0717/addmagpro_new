@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Discount Vendor | AddMagPro')
@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav><ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                <li class="breadcrumb-item active">Discount Vendor</li>
            </ol></nav>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="custom-container">
        <div class="row g-4">
            <div class="col-lg-5">
                @if($vendor_detail->banner_image ?? '')
                <img src="{{ asset($vendor_detail->banner_image) }}" alt="{{ $vendor_detail->shop_name }}" class="img-fluid rounded" style="max-height:360px;width:100%;object-fit:cover;">
                @else
                <div class="rounded d-flex align-items-center justify-content-center" style="height:300px;background:linear-gradient(135deg,var(--theme-color),#ff6600);">
                    <i class="ri-store-line" style="font-size:5rem;color:#fff;"></i>
                </div>
                @endif
            </div>
            <div class="col-lg-7">
                <h3 class="fw-bold mb-2">{{ $vendor_detail->shop_name }}</h3>
                <span class="badge mb-3" style="background:var(--theme-color);color:#fff;font-size:.9rem;padding:.5rem 1rem;border-radius:20px;">
                    <i class="ri-percent-line me-1"></i>{{ $vendor_detail->discount_margin ?? 0 }}% Discount
                </span>
                @if($vendor_detail->shop_description ?? '')
                <p class="text-muted mb-3">{{ $vendor_detail->shop_description }}</p>
                @endif
                <div class="mb-2"><i class="ri-user-line me-2" style="color:var(--theme-color);"></i><strong>{{ $vendor_detail->member_name }}</strong></div>
                <div class="mb-2"><i class="ri-phone-line me-2" style="color:var(--theme-color);"></i>{{ $vendor_detail->member_phone }}</div>
                <div class="mb-2"><i class="ri-map-pin-line me-2" style="color:var(--theme-color);"></i>{{ $vendor_detail->address }}, {{ $vendor_detail->location }}, {{ $vendor_detail->state }}</div>
                <div class="mt-4 d-flex gap-3 flex-wrap">
                    <a href="tel:{{ $vendor_detail->member_phone }}" class="btn" style="background:var(--theme-color);color:#fff;">
                        <i class="ri-phone-line me-1"></i> Call Now
                    </a>
                    <a href="{{ route('vendor_discount_products_shop', $vendor_detail->vendor_id) }}" class="btn btn-outline-secondary">
                        <i class="ri-shopping-bag-line me-1"></i> View Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
