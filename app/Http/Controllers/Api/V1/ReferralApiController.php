<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserReferral;
use App\Services\WalletService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferralApiController extends Controller
{
    use ApiResponse;

    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
        $this->middleware('auth:sanctum');
    }

    /**
     * Get my referral code and stats
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        // Generate referral code if not exists
        if (!$user->referral_code) {
            $user->generateReferralCode();
        }

        $totalReferrals = UserReferral::where('referrer_id', $user->id)->count();

        $completedReferrals = UserReferral::where('referrer_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $totalEarnings = UserReferral::where('referrer_id', $user->id)
            ->where('status', 'completed')
            ->sum('referrer_bonus');

        $claimedBonus = UserReferral::where('referrer_id', $user->id)
            ->where('referrer_bonus_claimed', true)
            ->sum('referrer_bonus');

        $unclaimedBonus = $totalEarnings - $claimedBonus;

        return $this->successResponse([
            'referral_code' => $user->referral_code,
            'referral_link' => $this->generateReferralLink($user->referral_code),
            'total_referrals' => $totalReferrals,
            'completed_referrals' => $completedReferrals,
            'pending_referrals' => $totalReferrals - $completedReferrals,
            'total_earnings' => (float) $totalEarnings,
            'claimed_bonus' => (float) $claimedBonus,
            'unclaimed_bonus' => (float) $unclaimedBonus,
            'next_milestone' => $this->getNextMilestone($completedReferrals),
        ], 'Referral profile retrieved');
    }

    /**
     * Get list of my referrals
     */
    public function list(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $status = $request->get('status'); // completed, pending, expired

        $query = UserReferral::where('referrer_id', $request->user()->id)
            ->with('referredUser:id,name,email,phone,created_at');

        if ($status) {
            $query->where('status', $status);
        }

        $referrals = $query->latest()->paginate($perPage);

        // Transform data
        collect($referrals->items())->transform(function ($referral) {
            return [
                'id' => $referral->id,
                'referred_user' => $referral->referredUser ? [
                    'id' => $referral->referredUser->id,
                    'name' => $referral->referredUser->name,
                    'email' => $referral->referredUser->email,
                    'phone' => $referral->referredUser->phone,
                    'joined_at' => $referral->referredUser->created_at,
                ] : null,
                'status' => $referral->status,
                'referrer_bonus' => (float) $referral->referrer_bonus,
                'referred_bonus' => (float) $referral->referred_bonus,
                'referrer_bonus_claimed' => $referral->referrer_bonus_claimed,
                'referred_bonus_claimed' => $referral->referred_bonus_claimed,
                'bonus_credited_at' => $referral->bonus_credited_at,
                'created_at' => $referral->created_at,
            ];
        });

        return $this->paginatedResponse($referrals, 'Referrals retrieved');
    }

    /**
     * Get single referral details
     */
    public function show(Request $request, int $referralId)
    {
        $referral = UserReferral::where('referrer_id', $request->user()->id)
            ->with('referredUser')
            ->find($referralId);

        if (!$referral) {
            return $this->notFoundResponse('Referral not found');
        }

        return $this->successResponse([
            'id' => $referral->id,
            'referred_user' => [
                'id' => $referral->referredUser->id,
                'name' => $referral->referredUser->name,
                'email' => $referral->referredUser->email,
                'phone' => $referral->referredUser->phone,
                'avatar_url' => $referral->referredUser->avatar_url,
                'joined_at' => $referral->referredUser->created_at,
            ],
            'status' => $referral->status,
            'referrer_bonus' => (float) $referral->referrer_bonus,
            'referred_bonus' => (float) $referral->referred_bonus,
            'referrer_bonus_claimed' => $referral->referrer_bonus_claimed,
            'referred_bonus_claimed' => $referral->referred_bonus_claimed,
            'bonus_credited_at' => $referral->bonus_credited_at,
            'notes' => $referral->notes,
            'created_at' => $referral->created_at,
        ], 'Referral details retrieved');
    }

    /**
     * Generate shareable referral link
     */
    public function share(Request $request)
    {
        $user = $request->user();

        if (!$user->referral_code) {
            $user->generateReferralCode();
        }

        $referralLink = $this->generateReferralLink($user->referral_code);

        return $this->successResponse([
            'referral_code' => $user->referral_code,
            'referral_link' => $referralLink,
            'share_text' => "Join AdMagPro with my referral code: {$user->referral_code} and get ₹300 bonus! Use this link: {$referralLink}",
            'share_urls' => [
                'whatsapp' => 'https://wa.me/?text=' . urlencode("Join AdMagPro with my referral code: {$user->referral_code}! {$referralLink}"),
                'telegram' => 'https://t.me/share/url?url=' . urlencode($referralLink),
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($referralLink),
                'twitter' => 'https://twitter.com/intent/tweet?url=' . urlencode($referralLink) . '&text=' . urlencode("Join AdMagPro with my referral code: {$user->referral_code}!"),
            ],
        ], 'Referral link generated');
    }

    /**
     * Register via referral code (new user signup)
     */
    public function registerWithCode(Request $request)
    {
        $validated = $request->validate([
            'referral_code' => 'required|string|exists:users,referral_code',
        ]);

        try {
            $referrer = User::where('referral_code', $validated['referral_code'])->first();

            if (!$referrer) {
                return $this->notFoundResponse('Invalid referral code');
            }

            // This would be called after user registration
            // The user is already authenticated at this point
            $newUser = $request->user();

            // Check if referral already exists
            $existingReferral = UserReferral::where('referrer_id', $referrer->id)
                ->where('referred_user_id', $newUser->id)
                ->exists();

            if ($existingReferral) {
                return $this->errorResponse('Referral already registered', [], 400);
            }

            // Create referral relationship
            $referralBonus = config('wallet.referral_bonus') / 100; // Convert to rupees
            $referredBonus = config('wallet.referred_bonus') / 100;

            $referral = UserReferral::create([
                'referrer_id' => $referrer->id,
                'referred_user_id' => $newUser->id,
                'status' => 'pending', // Will be 'completed' after first purchase
                'referrer_bonus' => $referralBonus,
                'referred_bonus' => $referredBonus,
                'referrer_bonus_claimed' => false,
                'referred_bonus_claimed' => false,
            ]);

            // Update referred user
            $newUser->update(['referred_by_user_id' => $referrer->id]);

            // Credit referred user bonus immediately
            $this->walletService->creditReferralBonus(
                $referrer,
                $newUser,
                0, // Don't credit referrer yet (wait for first purchase)
                $referredBonus
            );

            return $this->successResponse([
                'referral_id' => $referral->id,
                'referrer' => [
                    'id' => $referrer->id,
                    'name' => $referrer->name,
                ],
                'bonus_credited' => $referredBonus,
                'message' => "Welcome! You received ₹{$referredBonus} bonus",
            ], 'Referral registered successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to register referral: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Claim referrer bonus
     */
    public function claimBonus(Request $request, int $referralId)
    {
        try {
            $user = $request->user();

            $referral = UserReferral::where('referrer_id', $user->id)
                ->where('id', $referralId)
                ->first();

            if (!$referral) {
                return $this->notFoundResponse('Referral not found');
            }

            if ($referral->referrer_bonus_claimed) {
                return $this->errorResponse('Bonus already claimed', [], 400);
            }

            if ($referral->status !== 'completed') {
                return $this->errorResponse('Referral not yet completed', [], 400);
            }

            if ($referral->referrer_bonus <= 0) {
                return $this->errorResponse('No bonus to claim', [], 400);
            }

            // Credit bonus to wallet
            $this->walletService->topupWallet(
                $user,
                (float) $referral->referrer_bonus,
                'REFERRAL_' . $referral->id,
                ['referral_id' => $referral->id]
            );

            // Mark bonus as claimed
            $referral->update([
                'referrer_bonus_claimed' => true,
                'bonus_credited_at' => now(),
            ]);

            return $this->successResponse([
                'referral_id' => $referral->id,
                'amount_credited' => (float) $referral->referrer_bonus,
                'new_balance' => (float) $user->fresh()->wallet_balance,
            ], 'Bonus claimed successfully');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to claim bonus: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Mark referral as completed (after first purchase)
     */
    public function completeReferral(Request $request, int $referralId)
    {
        $validated = $request->validate([
            'referred_user_id' => 'required|exists:users,id',
        ]);

        try {
            $referral = UserReferral::find($referralId);

            if (!$referral) {
                return $this->notFoundResponse('Referral not found');
            }

            if ($referral->status === 'completed') {
                return $this->errorResponse('Referral already completed', [], 400);
            }

            // Update referral status
            $referral->update(['status' => 'completed']);

            // Credit referrer bonus if not claimed
            if (!$referral->referrer_bonus_claimed && $referral->referrer_bonus > 0) {
                $this->walletService->topupWallet(
                    User::find($referral->referrer_id),
                    (float) $referral->referrer_bonus,
                    'REFERRAL_' . $referral->id,
                    ['referral_id' => $referral->id]
                );
            }

            return $this->successResponse([
                'referral_id' => $referral->id,
                'status' => 'completed',
                'bonus_credited' => (float) $referral->referrer_bonus,
            ], 'Referral marked as completed');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to complete referral: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get referral statistics
     */
    public function statistics(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total_referrals' => UserReferral::where('referrer_id', $user->id)->count(),
            'completed_referrals' => UserReferral::where('referrer_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'pending_referrals' => UserReferral::where('referrer_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'expired_referrals' => UserReferral::where('referrer_id', $user->id)
                ->where('status', 'expired')
                ->count(),
            'total_earned' => (float) UserReferral::where('referrer_id', $user->id)
                ->where('status', 'completed')
                ->sum('referrer_bonus'),
            'total_claimed' => (float) UserReferral::where('referrer_id', $user->id)
                ->where('referrer_bonus_claimed', true)
                ->sum('referrer_bonus'),
            'this_month_referrals' => UserReferral::where('referrer_id', $user->id)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        return $this->successResponse($stats, 'Referral statistics retrieved');
    }

    // Helper Methods

    /**
     * Generate referral link
     */
    private function generateReferralLink(string $code): string
    {
        $appUrl = config('app.url');
        return "{$appUrl}/referral/{$code}";
    }

    /**
     * Get next referral milestone
     */
    private function getNextMilestone(int $referralCount): array
    {
        $milestones = [
            ['count' => 5, 'reward' => 500, 'label' => '5 Referrals'],
            ['count' => 10, 'reward' => 1500, 'label' => '10 Referrals'],
            ['count' => 25, 'reward' => 5000, 'label' => '25 Referrals'],
            ['count' => 50, 'reward' => 12000, 'label' => '50 Referrals'],
            ['count' => 100, 'reward' => 30000, 'label' => '100 Referrals'],
        ];

        foreach ($milestones as $milestone) {
            if ($referralCount < $milestone['count']) {
                return [
                    'target' => $milestone['count'],
                    'current' => $referralCount,
                    'remaining' => $milestone['count'] - $referralCount,
                    'reward' => $milestone['reward'],
                    'label' => $milestone['label'],
                ];
            }
        }

        return [
            'target' => 100,
            'current' => $referralCount,
            'remaining' => 0,
            'reward' => 0,
            'label' => 'All milestones unlocked!',
        ];
    }
}
