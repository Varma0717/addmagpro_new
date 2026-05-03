@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Register Discount Vendor | AddMagPro')
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
                <li class="breadcrumb-item active">Register Discount Vendor</li>
            </ol></nav>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="custom-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4 text-center">Become a Discount Vendor</h4>
                <p class="text-center text-muted mb-4">Register your store and offer exclusive discounts to AddMagPro members.</p>

                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('shop_registeration') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-card">
                        <h6><i class="ri-store-line me-2"></i>Shop Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Shop Banner</label>
                                <input type="file" name="category_image" class="form-control" accept="image/*" onchange="displayImage(event)" required>
                                <div class="mt-2 text-center">
                                    <img id="previewImg" src="{{ asset('assets/images/img2.jpg') }}" style="width:100%;max-height:150px;border-radius:8px;object-fit:cover;">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex flex-column gap-3">
                                <div>
                                    <label class="form-label fw-semibold">Owner Name</label>
                                    <input type="text" class="form-control" name="owner_name" value="{{ $user_details[0]->member_name ?? '' }}" required>
                                </div>
                                <div>
                                    <label class="form-label fw-semibold">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" value="{{ $user_details[0]->member_phone ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Shop Name</label>
                                <input type="text" class="form-control" name="shop_name" placeholder="Your shop name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">GST Number</label>
                                <input type="text" class="form-control" name="gst_number" placeholder="GST Number">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Shop Description</label>
                                <textarea class="form-control" name="shop_description" rows="3" placeholder="Describe your shop and offerings" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <h6><i class="ri-map-pin-line me-2"></i>Location</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Shop Address" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Location</label>
                                <input type="text" class="form-control" name="location" placeholder="Area / Locality" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">State</label>
                                <input type="text" class="form-control" name="state" placeholder="State" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">District</label>
                                <input type="text" class="form-control" name="district" placeholder="District" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pincode</label>
                                <input type="text" class="form-control" name="pincode" placeholder="Pincode" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Discount Margin (%)</label>
                                <input type="number" class="form-control" name="margin" placeholder="e.g., 10" min="1" max="100" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 py-3 fw-bold" style="background:var(--theme-color);color:#fff;font-size:1.1rem;">
                        <i class="ri-store-add-line me-2"></i> Register My Store
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('extra_js')
<script>
function displayImage(e) {
    const img = document.getElementById('previewImg');
    img.src = URL.createObjectURL(e.target.files[0]);
}
</script>
@endsection
