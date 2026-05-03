@extends('service_user_dashboard_layouts.master')
@section('page_title', 'ID Activation | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="p-5 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <i class="ri-fingerprint-line" style="font-size:4rem;color:var(--theme-color);"></i>
                    <h4 class="fw-bold mt-3 mb-2">ID Activation</h4>
                    <p class="text-muted">Your AddMagPro membership ID activation information will appear here.</p>
                    <a href="{{ route('user_dashboard') }}" class="btn mt-3" style="background:var(--theme-color);color:#fff;">
                        <i class="ri-dashboard-line me-1"></i> Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
