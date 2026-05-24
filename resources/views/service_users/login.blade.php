@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Login | AddMagPro')

@section('extra_css')
<style>
.auth-section { min-height: calc(100vh - 200px); display:flex; align-items:center; padding: 3rem 0; }
.auth-card { background:#fff; border-radius:16px; box-shadow:0 4px 30px rgba(0,0,0,.1); overflow:hidden; }
.auth-left { background: linear-gradient(135deg, var(--theme-color) 0%, #7a2800 100%); color:#fff; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:3rem 2rem; text-align:center; }
.auth-left img { max-width:160px; filter:brightness(0) invert(1); }
.auth-left h3 { font-size:1.6rem; font-weight:700; margin-top:1.5rem; }
.auth-left p { opacity:.85; font-size:.95rem; }
.auth-right { padding:3rem 2rem; }
.auth-right h2 { font-weight:700; margin-bottom:.5rem; color:var(--title-color); }
.auth-right p { color:var(--content-color); margin-bottom:2rem; }
.form-control:focus { border-color:var(--theme-color); box-shadow:0 0 0 .2rem rgba(255,153,0,.2); }
.btn-auth { background:var(--theme-color); color:#fff; width:100%; padding:.75rem; border-radius:8px; font-weight:600; border:none; font-size:1rem; }
.btn-auth:hover { background:#7a2800; color:#fff; }
.divider { display:flex; align-items:center; gap:1rem; margin:1.5rem 0; color:var(--content-color); }
.divider::before, .divider::after { content:''; flex:1; height:1px; background:#e9ecef; }
</style>
@endsection

@section('mainsection')
<section class="auth-section">
    <div class="custom-container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <div class="auth-card">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-flex auth-left">
                            <div>
                                <a href="{{ route('welcome_page') }}">
                                    <img src="{{ asset('assets/user_assets/images/logo.png') }}" alt="AddMagPro" class="img-fluid">
                                </a>
                                <h3>Welcome Back!</h3>
                                <p>Log in to your AddMagPro account and continue earning rewards while you shop.</p>
                                <div class="mt-3">
                                    <i class="ri-shield-check-line" style="font-size:1.2rem;"></i>
                                    <span class="ms-2">Secure &amp; Encrypted Login</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 auth-right">
                            <h2>Sign In</h2>
                            <p>Enter your credentials to access your account</p>
                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            <form action="{{ route('service_user_login') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="mobile_no" class="form-label fw-semibold">Mobile Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-phone-line"></i></span>
                                        <input type="number" class="form-control @error('mobile_no') is-invalid @enderror" id="mobile_no" name="mobile_no" placeholder="Enter your mobile number" value="{{ old('mobile_no') }}" required>
                                        @error('mobile_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-lock-line"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password" required>
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn-auth mt-2">
                                    <i class="ri-login-box-line me-2"></i>Sign In
                                </button>
                            </form>
                            <div class="divider">or</div>
                            <div class="text-center">
                                <p class="mb-0">New to AddMagPro?
                                    <a href="{{ route('service_user_registration') }}" style="color:var(--theme-color);font-weight:600;">Create Account</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
