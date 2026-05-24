@extends('service_user_dashboard_layouts.master')
@section('page_title', 'My Wallet | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">My Wallet</h4>
        @php $total = ($user_back_two_back_amount ?? 0) + ($user_commission_amount ?? 0) + ($user_pool_commission_amount ?? 0); @endphp
        <div class="p-4 mb-4 text-white text-center rounded" style="background:linear-gradient(135deg,var(--theme-color),#7a2800);">
            <p class="mb-0">Total Wallet Balance</p>
            <h1 class="fw-bold my-2">&#8377;{{ number_format($total, 2) }}</h1>
            <a href="{{ route('withdraw_amount') }}" class="btn mt-2" style="background:#fff;color:var(--theme-color);font-weight:700;">
                Withdraw Now
            </a>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);border-top:4px solid var(--theme-color);">
                    <p class="text-muted mb-1">Commission Balance</p>
                    <h4 class="fw-bold mb-0">&#8377;{{ number_format($user_commission_amount ?? 0, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);border-top:4px solid #1976d2;">
                    <p class="text-muted mb-1">Pool Commission</p>
                    <h4 class="fw-bold mb-0">&#8377;{{ number_format($user_pool_commission_amount ?? 0, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);border-top:4px solid #388e3c;">
                    <p class="text-muted mb-1">B2B Balance</p>
                    <h4 class="fw-bold mb-0">&#8377;{{ number_format($user_back_two_back_amount ?? 0, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
