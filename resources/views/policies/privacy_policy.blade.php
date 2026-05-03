@extends('policy_layouts.master')
@section('page_title', 'Privacy Policy | AddMagPro')
@section('mainsection')
<section style="padding:3rem 0;">
    <div class="custom-container">
        <div style="max-width:860px;margin:0 auto;">
            <div style="background:#fff;border-radius:12px;padding:2.5rem;box-shadow:0 2px 12px rgba(0,0,0,.06);">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:48px;height:48px;background:rgba(255,153,0,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="ri-shield-check-line" style="font-size:1.5rem;color:var(--theme-color);"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-0">Privacy Policy</h2>
                        <small class="text-muted">Last updated: Jun 05th 2024</small>
                    </div>
                </div>

                <p>This privacy policy sets out how <strong>KOOCHANA PUBLICATIONS PRIVATE LIMITED</strong> uses and protects any information that you give when you use this website. We are committed to ensuring that your privacy is protected.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Information We Collect</h5>
                <ul>
                    <li>Name and job title</li>
                    <li>Contact information including email address</li>
                    <li>Demographic information such as postcode, preferences and interests</li>
                    <li>Other information relevant to customer surveys and/or offers</li>
                </ul>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">How We Use Your Information</h5>
                <ul>
                    <li>Internal record keeping</li>
                    <li>To improve our products and services</li>
                    <li>To periodically send promotional emails about new products, special offers or other information which we think you may find interesting</li>
                    <li>To contact you for market research purposes</li>
                </ul>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Security</h5>
                <p>We are committed to ensuring that your information is secure. In order to prevent unauthorised access or disclosure, we have put in place suitable physical, electronic and managerial procedures to safeguard and secure the information we collect online.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Cookies</h5>
                <p>A cookie is a small file which asks permission to be placed on your computer's hard drive. We use traffic log cookies to identify which pages are being used. This helps us analyse data about web page traffic and improve our website. Overall, cookies help us provide you with a better website.</p>

                <h5 class="fw-bold mt-4 mb-2" style="color:var(--theme-color);">Controlling Your Personal Information</h5>
                <p>You may choose to restrict the collection or use of your personal information. If you have previously agreed to us using your personal information for direct marketing purposes, you may change your mind at any time by writing to us at the address below.</p>
                <p>We will not sell, distribute or lease your personal information to third parties unless we have your permission or are required by law to do so.</p>

                <div class="mt-4 p-3 rounded" style="background:rgba(255,153,0,.07);border-left:4px solid var(--theme-color);">
                    <p class="mb-0"><strong>Questions?</strong> If you have any questions about this privacy policy, <a href="{{ route('contact_us') }}" style="color:var(--theme-color);">contact us</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
