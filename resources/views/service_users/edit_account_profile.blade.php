@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Edit Profile | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4">Edit Profile</h4>
                <form action="{{ route('edit_user_profile_submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user_info[0]->service_id }}">
                    <input type="hidden" name="bank_new_enter" value="{{ $user_bank_details->isEmpty() ? '1' : '0' }}">
                    <div class="p-4 rounded mb-4" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                        <h6 class="fw-bold mb-3" style="border-bottom:2px solid var(--theme-color);padding-bottom:.5rem;">Personal Information</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Profile Photo</label>
                                <input type="file" class="form-control" name="category_image" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $user_info[0]->member_name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Location</label>
                                <input type="text" class="form-control" name="location" value="{{ $user_info[0]->location ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $user_info[0]->address ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">City</label>
                                <input type="text" class="form-control" name="city" value="{{ $user_info[0]->city ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pincode</label>
                                <input type="text" class="form-control" name="pincode" value="{{ $user_info[0]->pincode ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">State</label>
                                <input type="text" class="form-control" name="state" value="{{ $user_info[0]->state ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
                            </div>
                        </div>
                    </div>
                    @if($user_bank_details->isEmpty())
                    <div class="p-4 rounded mb-4" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                        <h6 class="fw-bold mb-3" style="border-bottom:2px solid var(--theme-color);padding-bottom:.5rem;">Bank Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">PAN Number</label>
                                <input type="text" class="form-control" name="pan_number" placeholder="PAN Number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bank Name</label>
                                <input type="text" class="form-control" name="bank_name" placeholder="Bank Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Account Number</label>
                                <input type="text" class="form-control" name="account_num" placeholder="Account Number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc" placeholder="IFSC Code">
                            </div>
                        </div>
                    </div>
                    @endif
                    <button type="submit" class="btn w-100 py-3 fw-bold" style="background:var(--theme-color);color:#fff;">
                        <i class="ri-save-line me-2"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
