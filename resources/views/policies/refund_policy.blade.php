@extends('policy_layouts.master')
@section('page_title', 'Refund Policy | AddMagPro')
@section('mainsection')
<section style="padding:3rem 0;">
    <div class="custom-container">
        <div style="max-width:860px;margin:0 auto;">
            <div style="background:#fff;border-radius:12px;padding:2.5rem;box-shadow:0 2px 12px rgba(0,0,0,.06);">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:48px;height:48px;background:rgba(255,153,0,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="ri-refund-2-line" style="font-size:1.5rem;color:var(--theme-color);"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">Refund Policy</h2>
                        <small class="text-muted">Last updated: Jun 05th 2024</small>
                    </div>
                </div>

                <p>We follow a <strong>No Refunds</strong> policy once an order has been placed. Please read this policy carefully before making any purchase on our platform.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">No Refunds Policy</h5>
                <p>Once you place an order and payment is confirmed, no refunds or cancellations will be processed. The transaction is considered final. This policy applies to all purchases made on AddMagPro.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Exceptions</h5>
                <p>Refunds will only be considered in the following exceptional circumstances:</p>
                <ul>
                    <li>Product/service was not delivered due to a fault on our end.</li>
                    <li>Wrong product was delivered (different from what was ordered).</li>
                    <li>Product was delivered in a damaged condition.</li>
                </ul>
                <p>In such cases, please contact us within 48 hours of receiving the product with photographic evidence.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Membership Fees</h5>
                <p>Membership registration fees (&#8377;1050) are strictly non-refundable once the account is activated.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Contact for Disputes</h5>
                <p>For any disputes or concerns, please <a href="{{ route('contact_us') }}" style="color:var(--theme-color);">contact us</a> and we will try to resolve the issue as quickly as possible.</p>
            </div>
        </div>
    </div>
</section>
@endsection
