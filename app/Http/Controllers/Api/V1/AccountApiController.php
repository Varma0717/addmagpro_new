<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountApiController extends Controller
{
    use ApiResponse;

    /**
     * Get user profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        return $this->successResponse(
            new AuthUserResource($user),
            'Profile retrieved'
        );
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|min:3|max:255',
            'phone' => 'sometimes|string|unique:users,phone,' . $user->id,
            'avatar_url' => 'sometimes|url',
            'location_address' => 'sometimes|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        $user->update($request->only([
            'name',
            'phone',
            'avatar_url',
            'location_address',
        ]));

        return $this->successResponse(
            new AuthUserResource($user),
            'Profile updated successfully'
        );
    }

    /**
     * Get user addresses
     */
    public function addresses(Request $request)
    {
        if (!$request->user()) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        // TODO: Implement addresses table and return addresses
        return $this->successResponse([], 'Addresses retrieved');
    }

    /**
     * Add a new address
     */
    public function addAddress(Request $request)
    {
        if (!$request->user()) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:shipping,billing,both',
            'address' => 'required|string|min:10',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string|size:6',
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        // TODO: Save address to database

        return $this->successResponse(null, 'Address added successfully', 201);
    }

    /**
     * Register or update an FCM device token for the authenticated user
     */
    public function registerDeviceToken(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        $validator = Validator::make($request->all(), [
            'token' => 'required|string|max:512',
            'platform' => 'sometimes|string|in:android,ios,web',
            'device_name' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        $preferences = is_array($user->preferences) ? $user->preferences : [];
        $storedTokens = $preferences['device_tokens'] ?? [];
        if (!is_array($storedTokens)) {
            $storedTokens = [];
        }

        $token = trim((string) $request->token);
        $storedTokens = collect($storedTokens)
            ->filter(fn($item) => is_array($item) && ($item['token'] ?? null) !== $token)
            ->values()
            ->all();

        array_unshift($storedTokens, [
            'token' => $token,
            'platform' => (string) $request->get('platform', 'android'),
            'device_name' => (string) $request->get('device_name', 'mobile-device'),
            'updated_at' => now()->toIso8601String(),
        ]);

        // Keep only a small recent token set per user.
        $preferences['device_tokens'] = array_slice($storedTokens, 0, 20);
        $user->update(['preferences' => $preferences]);

        return $this->successResponse([
            'token' => $token,
            'registered' => true,
            'tokens_count' => count($preferences['device_tokens']),
        ], 'Device token registered');
    }

    /**
     * Remove an FCM device token for the authenticated user
     */
    public function removeDeviceToken(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        $validator = Validator::make($request->all(), [
            'token' => 'required|string|max:512',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        $preferences = is_array($user->preferences) ? $user->preferences : [];
        $storedTokens = $preferences['device_tokens'] ?? [];
        if (!is_array($storedTokens)) {
            $storedTokens = [];
        }

        $token = trim((string) $request->token);
        $remaining = collect($storedTokens)
            ->filter(fn($item) => is_array($item) && ($item['token'] ?? null) !== $token)
            ->values()
            ->all();

        $preferences['device_tokens'] = $remaining;
        $user->update(['preferences' => $preferences]);

        return $this->successResponse([
            'token' => $token,
            'removed' => true,
            'tokens_count' => count($remaining),
        ], 'Device token removed');
    }

    /**
     * Get user notifications
     */
    public function notifications(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        $perPage = $request->get('per_page', 10);

        $notifications = $user
            ->notifications()
            ->latest()
            ->paginate($perPage);

        return $this->paginatedResponse($notifications, 'Notifications retrieved');
    }

    /**
     * Mark notification as read
     */
    public function markNotificationRead(Request $request, string $notificationId)
    {
        $user = $request->user();
        if (!$user) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        $notification = $user->notifications()->where('id', $notificationId)->first();

        if (!$notification) {
            return $this->notFoundResponse('Notification not found');
        }

        $notification->markAsRead();

        return $this->successResponse(null, 'Notification marked as read');
    }

    /**
     * Get notification preferences
     */
    public function notificationPreferences(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        return $this->successResponse(
            $user->preferences,
            'Notification preferences retrieved'
        );
    }

    /**
     * Update notification preferences
     */
    public function updateNotificationPreferences(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return $this->unauthorizedResponse('Authentication required', 401);
        }

        $preferences = $user->preferences ?? [];
        $preferences['email_notifications'] = $request->get('email_notifications', true);
        $preferences['sms_notifications'] = $request->get('sms_notifications', true);
        $preferences['push_notifications'] = $request->get('push_notifications', true);
        $preferences['promotional_emails'] = $request->get('promotional_emails', true);

        $user->update(['preferences' => $preferences]);

        return $this->successResponse(
            $user->preferences,
            'Preferences updated'
        );
    }
}
