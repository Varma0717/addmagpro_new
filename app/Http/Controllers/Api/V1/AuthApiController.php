<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service\ServiceUser;
use App\Http\Resources\AuthUserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
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
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:8|confirmed',
        ];

        $hasEmail = $this->hasUsersColumn('email');
        $hasPhone = $this->hasUsersColumn('phone');
        $hasReferralCode = $this->hasUsersColumn('referral_code');

        if ($hasEmail) {
            $rules['email'] = 'nullable|email|unique:users,email';
        }

        if ($hasPhone) {
            $rules['phone'] = 'required|string|unique:users,phone';
        } else {
            $rules['phone'] = 'required|string';
        }

        if ($hasReferralCode) {
            $rules['referral_code'] = 'sometimes|nullable|string|exists:users,referral_code';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        $email = $request->email;
        if (!$email || trim((string) $email) === '') {
            $email = 'user' . $request->phone . '@addmagpro.local';
        }

        $create = [
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ];

        if ($hasEmail) {
            $create['email'] = $email;
        }
        if ($hasPhone) {
            $create['phone'] = $request->phone;
        }
        if ($hasReferralCode) {
            $create['referral_code'] = 'REF' . strtoupper(Str::random(8));
        }
        if ($this->hasUsersColumn('kyc_status')) {
            $create['kyc_status'] = 'pending';
        }

        // Create user
        $user = User::create($create);

        if ($hasReferralCode && $this->hasUsersColumn('referred_by_user_id') && $request->filled('referral_code')) {
            $referrer = User::where('referral_code', strtoupper((string) $request->referral_code))->first();
            if ($referrer) {
                $user->update(['referred_by_user_id' => $referrer->id]);
            }
        }

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

        // Find user in v1 users table.
        $userQuery = User::query();
        $canQueryUser = false;

        if ($this->hasUsersColumn('phone')) {
            $userQuery->where('phone', $request->phone);
            $canQueryUser = true;
        }
        if ($this->hasUsersColumn('email')) {
            if ($canQueryUser) {
                $userQuery->orWhere('email', $request->phone);
            } else {
                $userQuery->where('email', $request->phone);
                $canQueryUser = true;
            }
        }

        $user = $canQueryUser ? $userQuery->first() : null;

        if ($user && Hash::check($request->password, (string) $user->password)) {
            $token = $user->createToken('auth-token')->plainTextToken;

            return $this->successResponse([
                'user' => new AuthUserResource($user),
                'token' => $token,
            ], 'Login successful');
        }

        // Fallback: support legacy website credentials from service_users.
        $legacyUser = ServiceUser::where('member_phone', $request->phone)->first();
        if ($legacyUser && $this->verifyLegacyPassword($request->password, $legacyUser)) {
            $user = $this->findOrCreateUserFromLegacy($legacyUser, $request->password);

            if (!$user) {
                return $this->errorResponse('Unable to map legacy account for mobile login', [], 500);
            }

            $token = $user->createToken('auth-token')->plainTextToken;

            return $this->successResponse([
                'user' => new AuthUserResource($user),
                'token' => $token,
            ], 'Login successful');
        }

        return $this->unauthorizedResponse('Invalid credentials', 401);
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

    private function hasUsersColumn(string $column): bool
    {
        return Schema::hasColumn('users', $column);
    }

    private function verifyLegacyPassword(string $plainPassword, ServiceUser $legacyUser): bool
    {
        $hash = (string) ($legacyUser->password ?? '');
        if ($hash !== '' && Hash::check($plainPassword, $hash)) {
            return true;
        }

        $open = (string) ($legacyUser->open_password ?? '');
        return $open !== '' && hash_equals($open, $plainPassword);
    }

    private function findOrCreateUserFromLegacy(ServiceUser $legacyUser, string $plainPassword): ?User
    {
        $phone = (string) ($legacyUser->member_phone ?? '');
        $email = 'user' . $phone . '@addmagpro.local';

        $query = User::query();
        $searchable = false;

        if ($phone !== '' && $this->hasUsersColumn('phone')) {
            $query->where('phone', $phone);
            $searchable = true;
        }
        if ($this->hasUsersColumn('email')) {
            if ($searchable) {
                $query->orWhere('email', $email);
            } else {
                $query->where('email', $email);
                $searchable = true;
            }
        }

        $user = $searchable ? $query->first() : null;
        if ($user) {
            return $user;
        }

        $create = [
            'name' => (string) ($legacyUser->member_name ?? 'User'),
            'password' => Hash::make($plainPassword),
        ];

        if ($this->hasUsersColumn('email')) {
            $create['email'] = $email;
        }
        if ($this->hasUsersColumn('phone')) {
            $create['phone'] = $phone;
        }
        if ($this->hasUsersColumn('referral_code')) {
            $create['referral_code'] = 'REF' . strtoupper(Str::random(8));
        }
        if ($this->hasUsersColumn('kyc_status')) {
            $create['kyc_status'] = 'pending';
        }

        return User::create($create);
    }
}
