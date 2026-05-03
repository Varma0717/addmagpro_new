@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Billing Details | AddMagPro')

@section('extra_css')
<style>
.checkout-card { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.07); padding:1.5rem; margin-bottom:1.5rem; }
.checkout-card h6 { font-weight:700; color:var(--title-color); padding-bottom:.5rem; border-bottom:2px solid var(--theme-color); margin-bottom:1.2rem; }
.form-control:focus { border-color:var(--theme-color); box-shadow:0 0 0 .2rem rgba(255,153,0,.2); }
</style>
@endsection

@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">Billing &amp; Shipping Details</h4>
        <form action="{{ route('billing_details_form_submit') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    {{-- Personal Details --}}
                    <div class="checkout-card">
                        <h6><i class="ri-user-line me-2"></i>Personal Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control" name="first_name" value="{{ $user_details->member_name ?? '' }}" placeholder="Full Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Location</label>
                                <input type="text" class="form-control" name="location" value="{{ $user_details->location ?? '' }}" placeholder="City / Area" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email address" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mobile No</label>
                                <input type="text" class="form-control" name="mobile_no" value="{{ $user_details->member_phone ?? '' }}" placeholder="Mobile Number" required>
                            </div>
                        </div>
                    </div>

                    {{-- Bank Details --}}
                    <div class="checkout-card">
                        <h6><i class="ri-bank-line me-2"></i>Bank Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Account Holder Name</label>
                                <input type="text" class="form-control" name="account_holder_name" value="{{ $user_details->member_name ?? '' }}" placeholder="As per bank records" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bank Name</label>
                                <input type="text" class="form-control" name="bank_name" value="{{ $bank_details->bank_name ?? '' }}" placeholder="Bank Name" {{ $bank_details->bank_name ?? '' ? 'readonly' : '' }} required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Account Number</label>
                                <input type="text" class="form-control" name="account_number" value="{{ $bank_details->account_number ?? '' }}" placeholder="Account Number" {{ $bank_details->account_number ?? '' ? 'readonly' : '' }} required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc" value="{{ $bank_details->ifsc ?? '' }}" placeholder="IFSC Code" {{ $bank_details->ifsc ?? '' ? 'readonly' : '' }} required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">PAN Number</label>
                                <input type="text" class="form-control" name="pan_number" value="{{ $bank_details->pancard_number ?? '' }}" placeholder="PAN Number" {{ $bank_details->pancard_number ?? '' ? 'readonly' : '' }} required>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Details --}}
                    <div class="checkout-card">
                        <h6><i class="ri-truck-line me-2"></i>Shipping Address</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Street Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $user_details->address ?? '' }}" placeholder="House No, Street, Area" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">City</label>
                                <input type="text" class="form-control" name="city_name" value="{{ $user_details->city ?? '' }}" placeholder="City" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pin Code</label>
                                <input type="text" class="form-control" name="zip_code" value="{{ $user_details->pincode ?? '' }}" placeholder="Pin Code" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">State</label>
                                <input type="text" class="form-control" name="country_name" value="{{ $user_details->state ?? '' }}" placeholder="State" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 py-3 fw-bold" style="background:var(--theme-color);color:#fff;font-size:1.1rem;">
                        <i class="ri-arrow-right-line me-2"></i>Proceed to Payment Summary
                    </button>
                </div>

                {{-- Cart Summary Sidebar --}}
                <div class="col-lg-4">
                    <div class="checkout-card">
                        <h6><i class="ri-shopping-cart-line me-2"></i>Cart Summary</h6>
                        @isset($cart_header_items)
                        @forelse($cart_header_items as $item)
                        <div class="d-flex gap-2 mb-2 pb-2 border-bottom">
                            <img src="{{ asset('assets/product_image/' . $item->product_image) }}" alt="{{ $item->product_name }}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-semibold" style="font-size:.85rem;">{{ $item->product_name }}</p>
                                <small class="text-muted">Qty: {{ $item->quantity ?? 1 }}</small>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center">No items in cart</p>
                        @endforelse
                        @endisset
                        <div class="text-center mt-2">
                            <a href="{{ route('welcome_page') }}" style="color:var(--theme-color);font-size:.85rem;">
                                <i class="ri-add-line"></i> Add more items
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
