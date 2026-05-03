<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AddMagPro</title>
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/vendors/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/kartify/css/style.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
        }

        .login-card .brand {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--theme-color);
        }

        .login-card .form-control {
            border-radius: 10px;
            border: 1.5px solid #e0e0e0;
            padding: .65rem 1rem;
            font-size: .9rem;
        }

        .login-card .form-control:focus {
            border-color: var(--theme-color);
            box-shadow: 0 0 0 3px rgba(255, 153, 0, .15);
        }

        .btn-login {
            background: var(--theme-color);
            color: #fff;
            border: none;
            border-radius: 10px;
            width: 100%;
            padding: .75rem;
            font-size: 1rem;
            font-weight: 700;
        }

        .btn-login:hover {
            background: #e68900;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="brand">AddMag<span style="color:#333;">Pro</span></div>
            <p class="text-muted mt-1" style="font-size:.9rem;">Sign in to your account</p>
        </div>
        <form action="{{ route('landing_page') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:.875rem;">Mobile Number</label>
                <div class="input-group">
                    <span class="input-group-text" style="border-radius:10px 0 0 10px;border:1.5px solid #e0e0e0;border-right:none;background:#f9f9f9;">
                        <i class="ri-smartphone-line" style="color:#888;"></i>
                    </span>
                    <input type="text" class="form-control" name="mobile_no" placeholder="Enter mobile number" required style="border-radius:0 10px 10px 0;">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:.875rem;">Password</label>
                <div class="input-group">
                    <span class="input-group-text" style="border-radius:10px 0 0 10px;border:1.5px solid #e0e0e0;border-right:none;background:#f9f9f9;">
                        <i class="ri-lock-line" style="color:#888;"></i>
                    </span>
                    <input type="password" class="form-control" name="password" id="lpPassword" placeholder="Enter password" required style="border-radius:0 10px 10px 0;">
                    <button type="button" class="input-group-text" onclick="togglePass()" style="border:1.5px solid #e0e0e0;border-left:none;border-radius:0 10px 10px 0;background:#f9f9f9;cursor:pointer;">
                        <i class="ri-eye-line" id="lpEyeIcon" style="color:#888;"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-login">Sign In</button>
        </form>
        <p class="text-center mt-3" style="font-size:.875rem;">
            Don't have an account? <a href="{{ route('service_user_registration') }}" style="color:var(--theme-color);font-weight:600;">Register</a>
        </p>
        <p class="text-center" style="font-size:.875rem;">
            <a href="{{ route('welcome_page') }}" style="color:#888;">← Back to Home</a>
        </p>
    </div>
    <script src="{{ asset('assets/kartify/js/bootstrap/bootstrap.bundle.js') }}"></script>
    <script>
        function togglePass() {
            const f = document.getElementById('lpPassword');
            const i = document.getElementById('lpEyeIcon');
            if (f.type === 'password') {
                f.type = 'text';
                i.className = 'ri-eye-off-line';
            } else {
                f.type = 'password';
                i.className = 'ri-eye-line';
            }
        }
    </script>
</body>

</html>