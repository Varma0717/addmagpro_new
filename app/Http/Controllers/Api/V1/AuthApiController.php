<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\AuthUserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthApiController extends Controller
{
    use ApiResponse;

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'referral_code' => 'REF' . strtoupper(Str::random(8)),
            'kyc_status' => 'pending',
        ]);

        // Create a token for the user
        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->successResponse([
            'user' => new AuthUserResource($user),
            'token' => $token,
        ], 'User registered successfully', 201);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        // Find user by phone or email
        $user = User::where('phone', $request->phone)
            ->orWhere('email', $request->phone)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->unauthorizedResponse('Invalid credentials', 401);
        }

        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->successResponse([
            'user' => new AuthUserResource($user),
            'token' => $token,
        ], 'Login successful');
    }

    /**
     * Get current authenticated user
     */
    public function me(Request $request)
    {
        if (!$request->user()) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        return $this->successResponse(
            new AuthUserResource($request->user()),
            'User profile retrieved'
        );
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        if (!$request->user()) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        // Revoke all tokens
        $request->user()->tokens()->delete();

        return $this->successResponse(null, 'Logged out successfully');
    }

    /**
     * Refresh token (optional)
     */
    public function refresh(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        // Revoke old token
        $request->user()->currentAccessToken()?->delete();

        // Create new token
        $token = $user->createToken('auth-token')->plainTextToken;

        return $this->successResponse([
            'user' => new AuthUserResource($user),
            'token' => $token,
        ], 'Token refreshed');
    }
}
