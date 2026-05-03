@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Customer Payments | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">Customer Payments</h4>
        @forelse($customer_transactions as $tx)
        <div class="p-4 rounded mb-3" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h6 class="fw-bold mb-1">{{ $tx->member_name ?? 'Customer' }}</h6>
                    <small class="text-muted">{{ $tx->member_phone ?? '' }} &bull; {{ $tx->created_at }}</small>
                </div>
                <div class="text-end">
                    <p class="mb-0"><small class="text-muted">Purchase:</small> &#8377;{{ $tx->purchase_amount }}</p>
                    <p class="mb-0"><small class="text-muted">Discount:</small> {{ $tx->discount_margin }}%</p>
                    <strong style="color:var(--theme-color);">Total: &#8377;{{ $tx->total_amount }}</strong>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="ri-bank-card-line" style="font-size:4rem;color:#ccc;"></i>
            <h5 class="mt-3 text-muted">No payment records yet.</h5>
        </div>
        @endforelse
    </div>
</section>
@endsection
