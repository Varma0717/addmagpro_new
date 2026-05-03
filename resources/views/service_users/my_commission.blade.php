@extends('service_user_dashboard_layouts.master')
@section('page_title', 'My Commission | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">My Commission</h4>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 rounded text-center text-white" style="background:linear-gradient(135deg,var(--theme-color),#ff6600);border-radius:12px;">
                    <i class="ri-money-dollar-circle-line" style="font-size:2.5rem;"></i>
                    <h3 class="fw-bold mt-2">&#8377;{{ number_format($user_commission->total_balance ?? 0, 2) }}</h3>
                    <p class="mb-0 opacity-85">Commission Balance</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded text-center text-white" style="background:linear-gradient(135deg,#1976d2,#0d47a1);border-radius:12px;">
                    <i class="ri-shopping-bag-line" style="font-size:2.5rem;"></i>
                    <h3 class="fw-bold mt-2">&#8377;{{ number_format($user_commission->purchase_income ?? 0, 2) }}</h3>
                    <p class="mb-0 opacity-85">Purchase Income</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded text-center text-white" style="background:linear-gradient(135deg,#388e3c,#1b5e20);border-radius:12px;">
                    <i class="ri-group-line" style="font-size:2.5rem;"></i>
                    <h3 class="fw-bold mt-2">&#8377;{{ number_format($pool_comission_amount->pool_balance ?? 0, 2) }}</h3>
                    <p class="mb-0 opacity-85">Pool Commission</p>
                </div>
            </div>
            @if($product_comission_amount ?? null)
            <div class="col-md-4">
                <div class="p-4 rounded text-center text-white" style="background:linear-gradient(135deg,#7b1fa2,#4a148c);border-radius:12px;">
                    <i class="ri-store-line" style="font-size:2.5rem;"></i>
                    <h3 class="fw-bold mt-2">&#8377;{{ number_format($product_comission_amount->balance ?? 0, 2) }}</h3>
                    <p class="mb-0 opacity-85">Product Commission</p>
                </div>
            </div>
            @endif
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('withdraw_amount') }}" class="btn px-5 py-3 fw-bold" style="background:var(--theme-color);color:#fff;">
                <i class="ri-money-pound-box-line me-2"></i> Withdraw Amount
            </a>
        </div>
    </div>
</section>
@endsection
