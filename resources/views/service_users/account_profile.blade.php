@extends('service_user_dashboard_layouts.master')
@section('page_title', 'My Profile | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="text-center p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    @if(($user_info[0]->user_profile_pic ?? '') != '')
                    <img src="{{ asset($user_info[0]->user_profile_pic) }}" alt="Profile" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid var(--theme-color);">
                    @else
                    <div style="width:120px;height:120px;border-radius:50%;background:linear-gradient(135deg,var(--theme-color),#ff6600);display:flex;align-items:center;justify-content:center;margin:0 auto;">
                        <i class="ri-user-line" style="font-size:3rem;color:#fff;"></i>
                    </div>
                    @endif
                    <h5 class="fw-bold mt-3 mb-0">{{ $user_info[0]->member_name }}</h5>
                    <p class="text-muted">ID: {{ $user_info[0]->referral_id }}</p>
                    <a href="{{ route('edit_user_profile') }}" class="btn w-100" style="background:var(--theme-color);color:#fff;">
                        <i class="ri-edit-line me-1"></i> Edit Profile
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="p-4 rounded mb-4" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <h6 class="fw-bold mb-3" style="border-bottom:2px solid var(--theme-color);padding-bottom:.5rem;">Personal Information</h6>
                    <div class="row g-3">
                        <div class="col-md-6"><small class="text-muted">Full Name</small><p class="fw-semibold mb-0">{{ $user_info[0]->member_name }}</p></div>
                        <div class="col-md-6"><small class="text-muted">Mobile</small><p class="fw-semibold mb-0">{{ $user_info[0]->member_phone }}</p></div>
                        <div class="col-md-6"><small class="text-muted">Location</small><p class="fw-semibold mb-0">{{ $user_info[0]->location ?? 'Not set' }}</p></div>
                        <div class="col-md-6"><small class="text-muted">City</small><p class="fw-semibold mb-0">{{ $user_info[0]->city ?? 'Not set' }}</p></div>
                        <div class="col-md-6"><small class="text-muted">State</small><p class="fw-semibold mb-0">{{ $user_info[0]->state ?? 'Not set' }}</p></div>
                        <div class="col-md-6"><small class="text-muted">Pincode</small><p class="fw-semibold mb-0">{{ $user_info[0]->pincode ?? 'Not set' }}</p></div>
                        <div class="col-12"><small class="text-muted">Address</small><p class="fw-semibold mb-0">{{ $user_info[0]->address ?? 'Not set' }}</p></div>
                        <div class="col-md-6"><small class="text-muted">Referral ID</small><p class="fw-semibold mb-0">{{ $user_info[0]->referral_id }}</p></div>
                        <div class="col-md-6"><small class="text-muted">Referred By</small><p class="fw-semibold mb-0">{{ $user_info[0]->referral_by }}</p></div>
                    </div>
                </div>
                @if($user_bank_details->isNotEmpty())
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <h6 class="fw-bold mb-3" style="border-bottom:2px solid var(--theme-color);padding-bottom:.5rem;">Bank Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6"><small class="text-muted">Bank Name</small><p class="fw-semibold mb-0">{{ $user_bank_details[0]->bank_name }}</p></div>
                        <div class="col-md-6"><small class="text-muted">Account Number</small><p class="fw-semibold mb-0">{{ $user_bank_details[0]->account_number }}</p></div>
                        <div class="col-md-6"><small class="text-muted">IFSC</small><p class="fw-semibold mb-0">{{ $user_bank_details[0]->ifsc }}</p></div>
                        <div class="col-md-6"><small class="text-muted">PAN Number</small><p class="fw-semibold mb-0">{{ $user_bank_details[0]->pancard_number }}</p></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
