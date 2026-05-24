@extends('service_user_dashboard_layouts.master')
@section('page_title', 'List Your Store | AddMagPro')
@section('extra_css')
<style>
.form-card { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.07); padding:1.5rem; margin-bottom:1.5rem; }
.form-card h6 { font-weight:700; color:var(--title-color); padding-bottom:.5rem; border-bottom:2px solid var(--theme-color); margin-bottom:1.2rem; }
</style>
@endsection
@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav><ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user_stores_list') }}">Stores</a></li>
                <li class="breadcrumb-item active">List Your Store</li>
            </ol></nav>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="custom-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4 text-center">Store Registration</h4>
                <form action="{{ route('razorpay') }}" method="POST" enctype="multipart/form-data" id="payment-form">
                    @csrf
                    <input type="hidden" name="service_user_id" value="{{ $user_details[0]->service_id }}">
                    <input type="hidden" name="cumulative_gross" value="{{ $user_details[0]->cumulative_gross }}">
                    <input type="hidden" name="commission_percentage" value="{{ $user_details[0]->commission_percentage }}">
                    <input type="hidden" name="referral_id" value="{{ $user_details[0]->referral_id }}">
                    <input type="hidden" name="referral_by" value="{{ $user_details[0]->referral_by }}">
                    <input type="hidden" name="business_type" value="{{ $business_type }}">
                    <input type="hidden" name="password" value="{{ $user_details[0]->password }}">
                    <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id">

                    <div class="form-card">
                        <h6><i class="ri-store-line me-2"></i>Store Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Store Photo</label>
                                <input type="file" name="service_image" id="service_image" accept="image/*" class="form-control" onchange="displayImage(event)" required>
                                <div class="mt-2 text-center">
                                    <img id="previewImg" src="{{ asset('assets/images/img2.jpg') }}" style="width:100px;height:100px;border-radius:8px;object-fit:cover;border:2px solid var(--theme-color);">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex flex-column gap-3">
                                <div>
                                    <label class="form-label fw-semibold">Owner Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user_details[0]->member_name }}" readonly>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" value="{{ $user_details[0]->member_phone }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">PAN Number</label>
                                <input type="text" class="form-control" name="pannumber" placeholder="PAN Number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $user_details[0]->location }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <h6><i class="ri-map-pin-line me-2"></i>Location &amp; Category</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">State</label>
                                <select id="state" name="state" class="form-control" onchange="updateDistricts()" required>
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->state_id }}">{{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">District</label>
                                <select name="district" id="district" class="form-control" required>
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Store Type</label>
                                <select name="profession" class="form-control" required>
                                    <option value="">Select Store Type</option>
                                    @foreach($services_details as $s)
                                    <option value="{{ $s->StoreID }}">{{ $s->StoreName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Store Description</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="Brief about your store" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <h6><i class="ri-coupon-line me-2"></i>Coupon &amp; Payment</h6>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Coupon Code (Optional)</label>
                                <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter coupon code">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" class="btn w-100" style="background:var(--theme-color);color:#fff;" id="validate-coupon">Apply</button>
                            </div>
                            <div class="col-12">
                                <span id="coupon-error" class="text-danger d-none"><i class="ri-error-warning-line me-1"></i>Invalid coupon.</span>
                                <span id="coupon-success" class="text-success d-none"><i class="ri-check-line me-1"></i>Coupon applied!</span>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn w-100 py-3 fw-bold" style="background:var(--theme-color);color:#fff;font-size:1.1rem;" id="razorpay-button">
                                    <i class="ri-secure-payment-line me-2"></i>Pay &#8377;1050
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('extra_js')

<script>
const districtsData = @json($districts);
function updateDistricts() {
    const stateId = document.getElementById('state').value;
    const districtSelect = document.getElementById('district');
    districtSelect.innerHTML = '<option value="">Select District</option>';
    if (stateId) {
        districtsData.filter(d => d.state_id == stateId).forEach(d => {
            const o = document.createElement('option');
            o.value = d.district_id; o.textContent = d.district_name;
            districtSelect.appendChild(o);
        });
    }
}
</script>
<script>
document.getElementById('validate-coupon').onclick = function() {
    const couponCode = document.getElementById('coupon_code').value;
    $.ajax({
        url: "{{ route('validate_coupon') }}",
        type: 'POST',
        data: { _token: "{{ csrf_token() }}", coupon_code: couponCode },
        success: function(response) {
            if (response.valid) {
                document.getElementById('razorpay-button').innerHTML = '<i class="ri-secure-payment-line me-2"></i>Pay &#8377;1';
                document.getElementById('coupon-error').classList.add('d-none');
                document.getElementById('coupon-success').classList.remove('d-none');
            } else {
                document.getElementById('coupon-error').classList.remove('d-none');
                document.getElementById('coupon-success').classList.add('d-none');
            }
        },
        error: function() { alert('Error processing coupon.'); }
    });
};
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('razorpay-button').onclick = function(e) {
    e.preventDefault();
    const couponApplied = !document.getElementById('coupon-success').classList.contains('d-none');
    const paymentAmount = couponApplied ? 100 : 105000;
    if (!document.getElementById('pincode').value || !document.getElementById('description').value) {
        alert('Please fill all required fields first.'); return;
    }
    var options = {
        "key": "{{ config('services.razorpay.key') }}",
        "amount": paymentAmount, "currency": "INR",
        "name": "AddMagPro",
        "description": "Business Listing Registration",
        "image": "{{ asset('assets/kartify/images/logo.png') }}",
        "handler": function(response) {
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('payment-form').submit();
        },
        "prefill": { "name": "AddMagPro", "email": "addmagpro@gmail.com", "contact": "7702381784" },
        "theme": { "color": "#aa5500" }
    };
    new Razorpay(options).open();
};
</script>
<script>
function displayImage(e) {
    const img = document.getElementById('previewImg');
    img.src = URL.createObjectURL(e.target.files[0]);
}
</script>

@endsection
