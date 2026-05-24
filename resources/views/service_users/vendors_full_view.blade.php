@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Vendor Shops | AddMagPro')
@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav><ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                <li class="breadcrumb-item active">Vendor Shops</li>
            </ol></nav>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">Vendor Shops</h4>
        <div class="row g-4">
            @forelse($vendor_banners as $vendor)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('products_list_vendor', $vendor->vendor_id) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
                        @if($vendor->vendor_banner_image ?? '')
                        <img src="{{ asset($vendor->vendor_banner_image) }}" alt="{{ $vendor->shop_name ?? 'Vendor' }}" style="width:100%;height:200px;object-fit:cover;">
                        @else
                        <div style="width:100%;height:200px;background:linear-gradient(135deg,var(--theme-color),#7a2800);display:flex;align-items:center;justify-content:center;">
                            <i class="ri-store-2-line" style="font-size:3rem;color:#fff;"></i>
                        </div>
                        @endif
                        <div class="card-body">
                            <h6 class="fw-bold mb-1" style="color:var(--title-color);">{{ $vendor->shop_name ?? 'Vendor Shop' }}</h6>
                            @if($vendor->description ?? '')
                            <p class="text-muted mb-0" style="font-size:.85rem;">{{ Str::limit($vendor->description, 80) }}</p>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-0 pt-0">
                            <span class="btn w-100" style="background:var(--theme-color);color:#fff;">
                                <i class="ri-shopping-bag-line me-1"></i> Shop Now
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="ri-store-2-line" style="font-size:3rem;color:#ccc;"></i>
                <p class="text-muted mt-2">No vendor shops available yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
