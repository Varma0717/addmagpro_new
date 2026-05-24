@extends('service_user_dashboard_layouts.master')
@section('page_title', 'My Orders | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">My Orders</h4>
        @forelse($customer_ordered_products as $order)
        <div class="p-4 rounded mb-3" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <span class="text-muted" style="font-size:.85rem;">Order #{{ $order->unique_id }}</span>
                    <h6 class="fw-bold mb-0">{{ $order->first_name }}</h6>
                </div>
                <div class="text-end">
                    @php
                    $statusColors = ['Packing'=>'#aa5500','Shipping'=>'#1565c0','Delivered'=>'#1b5e20'];
                    $sc = $statusColors[$order->status] ?? '#4a4a4a';
                    @endphp
                    <span class="badge" style="background:{{ $sc }};color:#fff;padding:.4rem .9rem;border-radius:20px;">
                        {{ $order->status }}
                    </span>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md-6"><small class="text-muted">Address:</small> {{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->zip_code }}</div>
                <div class="col-md-3"><small class="text-muted">Total:</small> <strong>&#8377;{{ $order->total_amount }}</strong></div>
                <div class="col-md-3"><small class="text-muted">Date:</small> {{ $order->ordered_date }}</div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="ri-shopping-bag-line" style="font-size:4rem;color:#ccc;"></i>
            <h5 class="mt-3 text-muted">No orders yet.</h5>
            <a href="{{ route('products_list') }}" class="btn mt-2" style="background:var(--theme-color);color:#fff;">Start Shopping</a>
        </div>
        @endforelse
    </div>
</section>
@endsection