@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Discount Shop | AddMagPro')
@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav><ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                <li class="breadcrumb-item active">Discount Shop</li>
            </ol></nav>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="custom-container">
        @foreach($discount_vendor_details as $vendor)
        <div class="mb-4 p-3 rounded" style="background:linear-gradient(135deg,rgba(255,153,0,.1),rgba(255,102,0,.05));border:1px solid rgba(255,153,0,.2);">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                @if($vendor->banner_image ?? '')
                <img src="{{ asset($vendor->banner_image) }}" alt="{{ $vendor->shop_name }}" style="width:80px;height:80px;border-radius:8px;object-fit:cover;">
                @endif
                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-0">{{ $vendor->shop_name }}</h5>
                    <p class="text-muted mb-0">{{ $vendor->address }}, {{ $vendor->location }}</p>
                </div>
                <span class="badge" style="background:var(--theme-color);color:#fff;font-size:1rem;padding:.5rem 1.2rem;border-radius:20px;">
                    {{ $vendor->discount_margin }}% OFF
                </span>
            </div>
        </div>
        @endforeach

        <div class="text-center py-5">
            <i class="ri-store-line" style="font-size:4rem;color:var(--theme-color);opacity:.5;"></i>
            <h5 class="mt-3 fw-bold">Shop With Exclusive Discounts</h5>
            <p class="text-muted">Visit this store to enjoy exclusive member discounts on every purchase.</p>
            @foreach($discount_vendor_details as $vendor)
            <a href="tel:{{ $vendor->member_phone }}" class="btn mt-2" style="background:var(--theme-color);color:#fff;">
                <i class="ri-phone-line me-1"></i> Contact: {{ $vendor->member_phone }}
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
