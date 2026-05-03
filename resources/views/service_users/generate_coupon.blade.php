@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Generate Coupons | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">Coupons</h4>
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="p-4 rounded text-center" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <i class="ri-coupon-line" style="font-size:2.5rem;color:var(--theme-color);"></i>
                    <h3 class="fw-bold my-2">{{ $pin_user['total_pins'] }}</h3>
                    <p class="text-muted mb-0">Available Coupon Points</p>
                    <small class="text-muted">(1050 points required per coupon)</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <h6 class="fw-bold mb-3">Generate New Coupon</h6>
                    <form action="{{ route('generate_new_coupon') }}" method="POST" onsubmit="return validateCouponCode()">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter 6-char code" maxlength="6" required>
                            <button type="submit" class="btn" style="background:var(--theme-color);color:#fff;">Generate</button>
                        </div>
                        <small class="text-muted mt-1 d-block">Must be exactly 6 characters with at least 1 letter.</small>
                    </form>
                </div>
            </div>
        </div>
        <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
            <h6 class="fw-bold mb-3">My Coupons</h6>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background:rgba(255,153,0,.08);">
                        <tr><th>#</th><th>Coupon Code</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($user_generated_coupons as $i => $coupon)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td class="fw-semibold">{{ $coupon->coupon_code }}</td>
                            <td>
                                @if($coupon->status == 'Active')
                                <span class="badge" style="background:#e8f5e9;color:#388e3c;">Active</span>
                                @else
                                <span class="badge" style="background:#fce4ec;color:#c62828;">{{ $coupon->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted">No coupons generated yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('extra_js')
<script>
function validateCouponCode() {
    const code = document.getElementById('coupon_code').value;
    if (!/^(?=.*[A-Za-z])[A-Za-z0-9]{6}$/.test(code)) {
        alert('Coupon code must be exactly 6 characters and include at least 1 letter.');
        return false;
    }
    return true;
}
</script>
@endsection
