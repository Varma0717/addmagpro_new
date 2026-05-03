@extends('policy_layouts.master')
@section('page_title', 'Contact Us | AddMagPro')
@section('mainsection')
<section style="padding:3rem 0;">
    <div class="custom-container">
        <h2 class="fw-bold mb-1">Contact Us</h2>
        <p class="text-muted mb-4">We're here to help. Reach out to us anytime.</p>
        <div class="row g-4">
            <div class="col-lg-5">
                <div style="background:#fff;border-radius:12px;padding:2rem;box-shadow:0 2px 12px rgba(0,0,0,.06);">
                    <h5 class="fw-bold mb-3">Get in Touch</h5>
                    <div class="d-flex gap-3 mb-3">
                        <div style="width:42px;height:42px;background:rgba(255,153,0,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="ri-map-pin-line" style="color:var(--theme-color);font-size:1.2rem;"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0">Address</p>
                            <small class="text-muted">N YUGENDHERINI, Building No-8-3-940, 8-3-940/A, Yellareddy Guda, Hyderabad TG 500038.</small>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-3">
                        <div style="width:42px;height:42px;background:rgba(255,153,0,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="ri-phone-line" style="color:var(--theme-color);font-size:1.2rem;"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0">Phone</p>
                            <small class="text-muted">+91-8522852201</small>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div style="width:42px;height:42px;background:rgba(255,153,0,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="ri-mail-line" style="color:var(--theme-color);font-size:1.2rem;"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0">Email</p>
                            <small class="text-muted">support@addmagpro.com</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div style="background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.06);">
                    <iframe class="w-100" height="360" style="border:0;display:block;"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3806.5447520194334!2d78.4449179!3d17.4336219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb91b23144c0eb%3A0x10b9cdb4a508cf25!2sTELANGANA%20ADD%20MAG!5e0!3m2!1sen!2sin!4v1717569398512!5m2!1sen!2sin"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
