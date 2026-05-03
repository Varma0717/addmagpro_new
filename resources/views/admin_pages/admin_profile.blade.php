@extends('layouts.master')
@section('mainsection')

<div class="admin-page">
    <section class="admin-section">
        <div class="admin-section-body">

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Admin Profile</h2>
                    <p class="text-muted mb-0 small">Your account information</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">

                    {{-- Avatar card --}}
                    <div class="card admin-card mb-3">
                        <div class="card-body admin-card-body text-center py-4">
                            <img src="{{asset('assets/vendor_assets/images/user.png')}}" alt="Admin Avatar"
                                style="width:110px;height:110px;border-radius:50%;object-fit:cover;border:3px solid var(--theme-color);">
                            <h5 class="mt-3 mb-0 fw-bold">{{ $admin[0]['name'] }}</h5>
                            <p class="text-muted small mb-0">{{ $admin[0]['email'] }}</p>
                        </div>
                    </div>

                    {{-- Info card --}}
                    <div class="card admin-card">
                        <div class="card-header admin-card-header">
                            <h4><i class="ri-user-settings-line me-2"></i>Profile Information</h4>
                        </div>
                        <div class="card-body admin-card-body">
                            <div class="row mb-3">
                                <div class="col-5 text-muted fw-500">Admin Name</div>
                                <div class="col-7 fw-bold">{{ $admin[0]['name'] }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5 text-muted fw-500">Email Address</div>
                                <div class="col-7 fw-bold">{{ $admin[0]['email'] }}</div>
                            </div>
                        </div>
                        <div class="card-footer admin-card-footer d-flex justify-content-end">
                            <button class="btn btn-theme"><i class="ri-edit-line me-1"></i>Change Password</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection