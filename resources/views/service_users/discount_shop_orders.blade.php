@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Discount Shop Orders | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">Discount Shop Orders</h4>
        @forelse($my_discount_purchases as $purchase)
        <div class="p-4 rounded mb-3" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h6 class="fw-bold mb-1">{{ $purchase->store_name }}</h6>
                    <small class="text-muted">{{ $purchase->created_at }}</small>
                </div>
                <div class="text-end">
                    <span class="badge mb-1" style="background:rgba(255,153,0,.1);color:var(--theme-color);padding:.4rem .9rem;border-radius:20px;">
                        {{ $purchase->discount_margin }}% Discount Applied
                    </span>
                    <div>
                        <small class="text-muted">Purchase: &#8377;{{ $purchase->purchase_amount }}</small>
                        <span class="fw-bold ms-2" style="color:var(--theme-color);">Total: &#8377;{{ $purchase->total_amount }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="ri-discount-percent-line" style="font-size:4rem;color:#ccc;"></i>
            <h5 class="mt-3 text-muted">No discount purchases yet.</h5>
            <a href="{{ route('welcome_page') }}" class="btn mt-2" style="background:var(--theme-color);color:#fff;">Explore Discount Shops</a>
        </div>
        @endforelse
    </div>
</section>
@endsection
