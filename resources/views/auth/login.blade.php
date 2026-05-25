@extends('app_layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                <span class="text-white font-bold text-lg">AM</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">AddMagPro</h1>
            <p class="text-gray-600 mt-2">Sign in to your account</p>
        </div>

        <div id="error-message" class="mb-4 bg-red-50 border border-red-200 rounded-lg p-3 hidden">
            <p class="text-red-600 text-sm" id="error-text"></p>
        </div>

        <form id="login-form" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="you@example.com"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="••••••••"
                    required>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                <a href="/forgot-password" class="text-sm text-blue-600 hover:text-blue-700">Forgot password?</a>
            </div>

            <button
                type="submit"
                id="submit-btn"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold transition disabled:opacity-50">
                Sign In
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-center text-gray-600 text-sm">
                Don't have an account?
                <a href="/register" class="text-blue-600 hover:text-blue-700 font-semibold">Sign up</a>
            </p>
        </div>
    </div>
</div>

<script>
    document.getElementById('login-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const submitBtn = document.getElementById('submit-btn');
        const errorMessage = document.getElementById('error-message');

        submitBtn.disabled = true;
        errorMessage.classList.add('hidden');

        try {
            const response = await fetch('/api/v1/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email,
                    password
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Save token to localStorage
                localStorage.setItem('auth_token', data.data.token);
                // Redirect to home
                window.location.href = '/home';
            } else {
                errorMessage.classList.remove('hidden');
                document.getElementById('error-text').textContent = data.message || 'Login failed';
            }
        } catch (error) {
            errorMessage.classList.remove('hidden');
            document.getElementById('error-text').textContent = 'Network error. Please try again.';
        } finally {
            submitBtn.disabled = false;
        }
    });
</script>
@endsection