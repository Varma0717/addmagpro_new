@extends('policy_layouts.master')
@section('page_title', 'Shipping Policy | AddMagPro')
@section('mainsection')
<section style="padding:3rem 0;">
    <div class="custom-container">
        <div style="max-width:860px;margin:0 auto;">
            <div style="background:#fff;border-radius:12px;padding:2.5rem;box-shadow:0 2px 12px rgba(0,0,0,.06);">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:48px;height:48px;background:rgba(255,153,0,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="ri-truck-line" style="font-size:1.5rem;color:var(--theme-color);"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">Shipping Policy</h2>
                        <small class="text-muted">Last updated: Jun 05th 2024</small>
                    </div>
                </div>

                <h5 class="fw-bold mt-2 mb-2" style="color:var(--theme-color);">Processing Time</h5>
                <p>All orders are processed within 1–2 business days after payment confirmation. Orders are not processed or shipped on weekends or public holidays.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Shipping Methods &amp; Delivery</h5>
                <div class="table-responsive">
                    <table class="table" style="border-radius:8px;overflow:hidden;">
                        <thead style="background:rgba(255,153,0,.08);">
                            <tr><th>Method</th><th>Estimated Delivery</th><th>Cost</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>Standard Shipping</td><td>5–7 business days</td><td>Calculated at checkout</td></tr>
                            <tr><td>Express Shipping</td><td>2–3 business days</td><td>Calculated at checkout</td></tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Delivery Locations</h5>
                <p>We currently ship to all locations within India. International shipping is not available at this time.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Tracking Your Order</h5>
                <p>Once your order is shipped, you will receive a confirmation notification. You can track your order status from your <a href="{{ route('account_orders') }}" style="color:var(--theme-color);">account dashboard</a>.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Lost or Damaged Items</h5>
                <p>If your order was damaged during transit or you believe it was lost, please <a href="{{ route('contact_us') }}" style="color:var(--theme-color);">contact us</a> within 48 hours of the expected delivery date.</p>
            </div>
        </div>
    </div>
</section>
@endsection
