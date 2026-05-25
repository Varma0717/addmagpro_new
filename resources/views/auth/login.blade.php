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

        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-3">
            @foreach($errors->all() as $error)
            <p class="text-red-600 text-sm">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="you@example.com"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    type="password"
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
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold transition">
                Sign In
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-center text-gray-600 text-sm">
                Don't have an account?
                <a href="/register" class="text-blue-600 hover:text-blue-700 font-semibold">Sign up</a>
            </p>
        </div>

        <div class="mt-4">
            <p class="text-center text-xs text-gray-500 mb-3">Or continue with</p>
            <button class="w-full border border-gray-300 py-2 rounded-lg hover:bg-gray-50 flex items-center justify-center gap-2">
                <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5">
                <span class="text-sm text-gray-700">Google</span>
            </button>
        </div>
    </div>
</div>
@endsection