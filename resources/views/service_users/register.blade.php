@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Register | AddMagPro')

@section('extra_css')
<style>
.auth-section { min-height: calc(100vh - 200px); display:flex; align-items:center; padding: 3rem 0; }
.auth-card { background:#fff; border-radius:16px; box-shadow:0 4px 30px rgba(0,0,0,.1); overflow:hidden; }
.auth-left { background: linear-gradient(135deg, var(--theme-color) 0%, #ff6600 100%); color:#fff; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:3rem 2rem; text-align:center; }
.auth-left img { max-width:160px; filter:brightness(0) invert(1); }
.auth-left h3 { font-size:1.6rem; font-weight:700; margin-top:1.5rem; }
.auth-left p { opacity:.85; font-size:.95rem; }
.auth-right { padding:3rem 2rem; }
.auth-right h2 { font-weight:700; margin-bottom:.5rem; color:var(--title-color); }
.auth-right p { color:var(--content-color); margin-bottom:2rem; }
.form-control:focus { border-color:var(--theme-color); box-shadow:0 0 0 .2rem rgba(255,153,0,.2); }
.btn-auth { background:var(--theme-color); color:#fff; width:100%; padding:.75rem; border-radius:8px; font-weight:600; border:none; font-size:1rem; }
.btn-auth:hover { background:#e68a00; color:#fff; }
.referral-badge { background:rgba(255,153,0,.1); border:1px solid var(--theme-color); border-radius:8px; padding:.6rem 1rem; color:var(--theme-color); font-weight:600; margin-bottom:1.5rem; display:inline-flex; align-items:center; gap:.5rem; }
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
                                <h3>Join AddMagPro</h3>
                                <p>Create your account and start earning rewards while you shop and refer friends.</p>
                                <div class="mt-3 d-flex flex-column gap-2">
                                    <div><i class="ri-gift-line me-2"></i>Earn cashback on purchases</div>
                                    <div><i class="ri-team-line me-2"></i>Refer friends &amp; earn more</div>
                                    <div><i class="ri-wallet-line me-2"></i>Withdraw your earnings</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 auth-right">
                            <h2>Create Account</h2>
                            @isset($referal_name)
                            @if($referal_name)
                            <div class="referral-badge">
                                <i class="ri-user-add-line"></i>
                                Referred by: {{ strtoupper($referal_name) }}
                            </div>
                            @endif
                            @endisset
                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            <form action="{{ route('service_user_registration') }}" method="POST">
                                @csrf
                                <input type="hidden" name="referral_by" value="{{ $referral_by ?? '' }}">
                                <div class="mb-3">
                                    <label for="member_name" class="form-label fw-semibold">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-user-line"></i></span>
                                        <input type="text" class="form-control @error('member_name') is-invalid @enderror" id="member_name" name="member_name" placeholder="Your full name" value="{{ old('member_name') }}" required>
                                        @error('member_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile_no" class="form-label fw-semibold">Mobile Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-phone-line"></i></span>
                                        <input type="number" class="form-control @error('mobile_no') is-invalid @enderror" id="mobile_no" name="mobile_no" placeholder="10-digit mobile number" value="{{ old('mobile_no') }}" required>
                                        @error('mobile_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Create Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-lock-line"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimum 6 characters" required>
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label fw-semibold">Location / City</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" placeholder="Your city or area" value="{{ old('location') }}" required>
                                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                                    <label class="form-check-label" for="agreeTerms" style="font-size:.88rem;">
                                        I agree to the
                                        <a href="{{ route('terms_and_conditions') }}" style="color:var(--theme-color);">Terms &amp; Conditions</a>
                                        and
                                        <a href="{{ route('privacy_policy') }}" style="color:var(--theme-color);">Privacy Policy</a>
                                    </label>
                                </div>
                                <button type="submit" class="btn-auth">
                                    <i class="ri-user-add-line me-2"></i>Create Account
                                </button>
                            </form>
                            <div class="text-center mt-3">
                                <p class="mb-0">Already have an account?
                                    <a href="{{ route('service_user_login') }}" style="color:var(--theme-color);font-weight:600;">Sign In</a>
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
