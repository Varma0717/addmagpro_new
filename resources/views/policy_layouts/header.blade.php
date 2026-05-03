<header style="background:#fff;border-bottom:1px solid #eee;position:sticky;top:0;z-index:999;box-shadow:0 2px 8px rgba(0,0,0,.05);">
    <div class="custom-container">
        <div class="d-flex align-items-center justify-content-between" style="padding:.8rem 0;">
            <a href="{{ route('welcome_page') }}">
                <span style="font-size:1.4rem;font-weight:800;color:var(--theme-color);">AddMag<span style="color:#333;">Pro</span></span>
            </a>
            <nav class="d-none d-md-flex gap-3 align-items-center">
                <a href="{{ route('welcome_page') }}" style="color:#333;font-weight:500;font-size:.9rem;">Home</a>
                <a href="{{ route('privacy_policy') }}" style="color:#333;font-weight:500;font-size:.9rem;">Privacy</a>
                <a href="{{ route('terms_and_conditions') }}" style="color:#333;font-weight:500;font-size:.9rem;">Terms</a>
                <a href="{{ route('contact_us') }}" style="color:#333;font-weight:500;font-size:.9rem;">Contact</a>
                <a href="{{ route('service_user_login') }}" class="btn btn-sm" style="background:var(--theme-color);color:#fff;border-radius:6px;padding:.35rem .9rem;">Login</a>
            </nav>
        </div>
    </div>
</header>
