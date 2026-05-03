@extends('service_user_dashboard_layouts.master')
@section('page_title', 'My Dashboard | AddMagPro')

@section('extra_css')
<style>
    .dash-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
        padding: 1.5rem;
        height: auto;
    }

    .dash-stat {
        border-radius: 12px;
        padding: 1.5rem;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .dash-stat .stat-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, .2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .dash-stat h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }

    .dash-stat p {
        margin: 0;
        opacity: .85;
        font-size: .9rem;
    }

    .level-badge {
        display: inline-block;
        padding: .4rem 1.2rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: .9rem;
    }

    .sidebar-dash-link {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .7rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        color: var(--title-color);
        transition: background .15s;
    }

    .sidebar-dash-link:hover,
    .sidebar-dash-link.active {
        background: rgba(255, 153, 0, .1);
        color: var(--theme-color);
    }

    .sidebar-dash-link i {
        font-size: 1.1rem;
        color: var(--theme-color);
    }
</style>
@endsection

@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <div class="row g-4">

            {{-- LEFT SIDEBAR --}}
            <div class="col-lg-3 col-xl-2">
                <div class="dash-card p-0 overflow-hidden">
                    <div class="p-3 text-center" style="background:linear-gradient(135deg,var(--theme-color) 0%,#ff6600 100%);">
                        <div class="rounded-circle mx-auto mb-2 overflow-hidden" style="width:64px;height:64px;background:rgba(255,255,255,.2);">
                            <i class="ri-user-line" style="font-size:2.5rem;color:#fff;line-height:64px;"></i>
                        </div>
                        @isset($user_details)
                        <h6 class="text-white fw-bold mb-0">{{ $user_details[0]->member_name ?? 'Member' }}</h6>
                        <small class="text-white opacity-75">ID: {{ $user_details[0]->service_id ?? '' }}</small>
                        @endisset
                    </div>
                    <div class="p-2">
                        <a href="{{ route('user_dashboard') }}" class="sidebar-dash-link active">
                            <i class="ri-dashboard-line"></i>Dashboard
                        </a>
                        <a href="{{ route('generate_coupon') }}" class="sidebar-dash-link">
                            <i class="ri-coupon-line"></i>Generate Coupons
                        </a>
                        <a href="{{ route('user_wallet') }}" class="sidebar-dash-link">
                            <i class="ri-wallet-line"></i>My Wallet
                        </a>
                        <a href="{{ route('team_details') }}" class="sidebar-dash-link">
                            <i class="ri-team-line"></i>Team Details
                        </a>
                        <a href="{{ route('account_profile') }}" class="sidebar-dash-link">
                            <i class="ri-user-settings-line"></i>Profile
                        </a>
                        <a href="{{ route('account_orders') }}" class="sidebar-dash-link">
                            <i class="ri-shopping-bag-line"></i>My Orders
                        </a>
                        <a href="{{ route('discount_shop_orders') }}" class="sidebar-dash-link">
                            <i class="ri-discount-percent-line"></i>Discount Orders
                        </a>
                        <a href="{{ route('customer_payments') }}" class="sidebar-dash-link">
                            <i class="ri-bank-card-line"></i>Payments
                        </a>
                        <a href="{{ route('service_user_logout') }}" class="sidebar-dash-link text-danger" onclick="return confirm('Logout?')">
                            <i class="ri-logout-box-line"></i>Logout
                        </a>
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9 col-xl-10">

                @isset($user_details)
                {{-- Member Level Badge --}}
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-bold mb-0">Welcome, {{ $user_details[0]->member_name ?? 'Member' }}!</h4>
                        <p class="text-muted mb-0">Here's your account overview</p>
                    </div>
                    @php
                    $gross = $user_details[0]->cumulative_gross ?? 0;
                    if ($gross >= 120001) { $level = 'Diamond'; $levelColor = '#1565c0'; }
                    elseif ($gross >= 40001) { $level = 'Gold'; $levelColor = '#e65100'; }
                    elseif ($gross >= 20001) { $level = 'Silver'; $levelColor = '#4a4a4a'; }
                    elseif ($gross >= 8000) { $level = 'Bronze'; $levelColor = '#6d4c41'; }
                    else { $level = 'Starter'; $levelColor = '#2e7d32'; }
                    @endphp
                    <span class="level-badge" style="background:{{ $levelColor }};color:#fff;">
                        <i class="ri-medal-line me-1"></i>{{ $level }} Member
                    </span>
                </div>
                @endisset

                {{-- Stats Row --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:.75rem;margin-bottom:1.25rem;">
                    <div class="dash-stat" style="background:linear-gradient(135deg,#ff9900,#ff6600);">
                        <div class="stat-icon"><i class="ri-wallet-line"></i></div>
                        <div>
                            <h3>&#8377;{{ number_format($cummulative_value ?? 0, 0) }}</h3>
                            <p>Total Wallet</p>
                        </div>
                    </div>
                    <div class="dash-stat" style="background:linear-gradient(135deg,#1976d2,#0d47a1);">
                        <div class="stat-icon"><i class="ri-money-dollar-circle-line"></i></div>
                        <div>
                            <h3>&#8377;{{ number_format($my_commission ?? 0, 0) }}</h3>
                            <p>Commission</p>
                        </div>
                    </div>
                    <div class="dash-stat" style="background:linear-gradient(135deg,#388e3c,#1b5e20);">
                        <div class="stat-icon"><i class="ri-exchange-dollar-line"></i></div>
                        <div>
                            <h3>&#8377;{{ number_format($back_two_back_balance_value ?? 0, 0) }}</h3>
                            <p>B2B Balance</p>
                        </div>
                    </div>
                    <div class="dash-stat" style="background:linear-gradient(135deg,#7b1fa2,#4a148c);">
                        <div class="stat-icon"><i class="ri-store-line"></i></div>
                        <div>
                            <h3>{{ $discount_vendor_count ?? 0 }}</h3>
                            <p>Discount Vendors</p>
                        </div>
                    </div>
                </div>

                {{-- Membership Progress --}}
                @isset($user_details)
                <div class="dash-card mb-4">
                    <h6 class="fw-bold mb-3">Membership Progress</h6>
                    @php
                    $gross = $user_details[0]->cumulative_gross ?? 0;
                    $nextLevel = 8000;
                    $nextName = 'Bronze';
                    if ($gross < 8000) { $nextLevel=8000; $nextName='Bronze' ; }
                        elseif ($gross < 20000) { $nextLevel=20000; $nextName='Silver' ; }
                        elseif ($gross < 40000) { $nextLevel=40000; $nextName='Gold' ; }
                        elseif ($gross < 120000) { $nextLevel=120000; $nextName='Diamond' ; }
                        else { $nextLevel=$gross; $nextName='Diamond Max' ; }
                        $pct=min(100, round(($gross / $nextLevel) * 100));
                        @endphp
                        <div class="d-flex justify-content-between mb-1">
                        <small>Cumulative Gross: <strong>&#8377;{{ number_format($gross, 0) }}</strong></small>
                        <small>Next Level: <strong>{{ $nextName }}</strong> (&#8377;{{ number_format($nextLevel, 0) }})</small>
                </div>
                <div class="progress" style="height:12px;border-radius:6px;">
                    <div class="progress-bar" style="width:{{ $pct }}%;background:var(--theme-color);border-radius:6px;">{{ $pct }}%</div>
                </div>
                <small class="text-muted mt-1 d-block">Commission Rate: <strong>{{ $user_details[0]->commission_percentage ?? 0 }}%</strong></small>
            </div>
            @endisset

            {{-- Quick Actions --}}
            <div class="dash-card">
                <h6 class="fw-bold mb-3">Quick Actions</h6>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(110px,1fr));gap:.75rem;">
                    <a href="{{ route('products_list') }}" class="text-center p-3 rounded border text-decoration-none" style="color:var(--title-color);">
                        <i class="ri-shopping-bag-line d-block mb-1" style="font-size:1.8rem;color:var(--theme-color);"></i>
                        <small class="fw-semibold">Shop Now</small>
                    </a>
                    <a href="{{ route('team_details') }}" class="text-center p-3 rounded border text-decoration-none" style="color:var(--title-color);">
                        <i class="ri-team-line d-block mb-1" style="font-size:1.8rem;color:var(--theme-color);"></i>
                        <small class="fw-semibold">My Team</small>
                    </a>
                    <a href="{{ route('withdraw_amount') }}" class="text-center p-3 rounded border text-decoration-none" style="color:var(--title-color);">
                        <i class="ri-money-pound-box-line d-block mb-1" style="font-size:1.8rem;color:var(--theme-color);"></i>
                        <small class="fw-semibold">Withdraw</small>
                    </a>
                    <a href="{{ route('account_orders') }}" class="text-center p-3 rounded border text-decoration-none" style="color:var(--title-color);">
                        <i class="ri-list-check d-block mb-1" style="font-size:1.8rem;color:var(--theme-color);"></i>
                        <small class="fw-semibold">My Orders</small>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection