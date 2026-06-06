@extends('layouts.master')
@section('page_title', 'Admin Operations | AddMagPro Admin')
@section('mainsection')
<div class="admin-page">
    <section class="admin-section">
        <div class="admin-section-body">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                <div>
                    <h2 class="admin-page-title">Admin Operations Hub</h2>
                    <p class="admin-page-subtitle">Manage catalog, vendors and wallet operations for website + mobile APIs.</p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Categories</div>
                            <div class="stat-value">{{ $categoryCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Services</div>
                            <div class="stat-value">{{ $serviceCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Stores</div>
                            <div class="stat-value">{{ $storeCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Vendors</div>
                            <div class="stat-value">{{ $vendorCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Products</div>
                            <div class="stat-value">{{ $productCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Pending Vendors</div>
                            <div class="stat-value">{{ $pendingVendorCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Pending Withdrawals</div>
                            <div class="stat-value">{{ $pendingWithdrawCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card admin-card">
                <div class="card-header admin-card-header">
                    <h4>Quick Management</h4>
                </div>
                <div class="card-body admin-card-body">
                    <div class="row g-2">
                        <div class="col-md-4"><a class="btn btn-theme w-100" href="{{ route('admin_ops_categories') }}">Manage Categories</a></div>
                        <div class="col-md-4"><a class="btn btn-theme w-100" href="{{ route('admin_ops_services') }}">Manage Services</a></div>
                        <div class="col-md-4"><a class="btn btn-theme w-100" href="{{ route('admin_ops_stores') }}">Manage Stores</a></div>
                        <div class="col-md-4"><a class="btn btn-theme w-100" href="{{ route('admin_ops_vendors') }}">Manage Vendors</a></div>
                        <div class="col-md-4"><a class="btn btn-theme w-100" href="{{ route('admin_ops_products') }}">Manage Products</a></div>
                        <div class="col-md-4"><a class="btn btn-theme w-100" href="{{ route('admin_ops_wallet') }}">Wallet Admin View</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection