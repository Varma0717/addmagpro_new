<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserWalletTransaction;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * Add money to wallet (topup)
     */
    public function topupWallet(User $user, float $amount, string $referenceId, array $metadata = []): UserWalletTransaction
    {
        try {
            return DB::transaction(function () use ($user, $amount, $referenceId, $metadata) {
                $balanceBefore = $user->wallet_balance;
                $balanceAfter = $balanceBefore + $amount;

                $transaction = UserWalletTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'credit',
                    'transaction_type' => 'topup',
                    'amount' => $amount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'reference_id' => $referenceId,
                    'status' => 'completed',
                    'description' => 'Wallet topup via Razorpay',
                    'metadata' => $metadata,
                ]);

                // Update user wallet balance
                $user->update(['wallet_balance' => $balanceAfter]);

                return $transaction;
            });
        } catch (\Exception $e) {
            throw new ApiException('Failed to topup wallet: ' . $e->getMessage(), 500, 'WALLET_TOPUP_FAILED');
        }
    }

    /**
     * Deduct money for purchase
     */
    public function deductForPurchase(User $user, float $amount, int $orderId, string $referenceId = null): UserWalletTransaction
    {
        if ($user->wallet_balance < $amount) {
            throw new ApiException('Insufficient wallet balance', 400, 'INSUFFICIENT_BALANCE');
        }

        try {
            return DB::transaction(function () use ($user, $amount, $orderId, $referenceId) {
                $balanceBefore = $user->wallet_balance;
                $balanceAfter = $balanceBefore - $amount;

                $transaction = UserWalletTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'debit',
                    'transaction_type' => 'purchase',
                    'amount' => $amount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'reference_id' => $referenceId ?? 'ORDER_' . $orderId,
                    'status' => 'completed',
                    'description' => 'Payment for Order #' . $orderId,
                    'metadata' => ['order_id' => $orderId],
                ]);

                $user->update(['wallet_balance' => $balanceAfter]);

                return $transaction;
            });
        } catch (\Exception $e) {
            throw new ApiException('Failed to deduct from wallet: ' . $e->getMessage(), 500, 'WALLET_DEDUCT_FAILED');
        }
    }

    /**
     * Send money to another user
     */
    public function sendMoney(User $sender, User $receiver, float $amount, string $description = null): array
    {
        if ($sender->id === $receiver->id) {
            throw new ApiException('Cannot send money to yourself', 400, 'INVALID_TRANSFER');
        }

        if ($sender->wallet_balance < $amount) {
            throw new ApiException('Insufficient wallet balance', 400, 'INSUFFICIENT_BALANCE');
        }

        try {
            return DB::transaction(function () use ($sender, $receiver, $amount, $description) {
                $referenceId = 'TRANSFER_' . uniqid();

                // Deduct from sender
                $senderBalanceBefore = $sender->wallet_balance;
                $senderBalanceAfter = $senderBalanceBefore - $amount;

                $senderTransaction = UserWalletTransaction::create([
                    'user_id' => $sender->id,
                    'type' => 'debit',
                    'transaction_type' => 'transfer_send',
                    'amount' => $amount,
                    'balance_before' => $senderBalanceBefore,
                    'balance_after' => $senderBalanceAfter,
                    'reference_id' => $referenceId,
                    'status' => 'completed',
                    'description' => $description ?? 'Money sent to ' . $receiver->name,
                    'metadata' => ['receiver_id' => $receiver->id],
                ]);

                $sender->update(['wallet_balance' => $senderBalanceAfter]);

                // Credit to receiver
                $receiverBalanceBefore = $receiver->wallet_balance;
                $receiverBalanceAfter = $receiverBalanceBefore + $amount;

                $receiverTransaction = UserWalletTransaction::create([
                    'user_id' => $receiver->id,
                    'type' => 'credit',
                    'transaction_type' => 'transfer_receive',
                    'amount' => $amount,
                    'balance_before' => $receiverBalanceBefore,
                    'balance_after' => $receiverBalanceAfter,
                    'reference_id' => $referenceId,
                    'status' => 'completed',
                    'description' => 'Money received from ' . $sender->name,
                    'metadata' => ['sender_id' => $sender->id],
                ]);

                $receiver->update(['wallet_balance' => $receiverBalanceAfter]);

                return [
                    'sender_transaction' => $senderTransaction,
                    'receiver_transaction' => $receiverTransaction,
                    'reference_id' => $referenceId,
                ];
            });
        } catch (\Exception $e) {
            throw new ApiException('Failed to transfer money: ' . $e->getMessage(), 500, 'TRANSFER_FAILED');
        }
    }

    /**
     * Refund money to wallet
     */
    public function refundToWallet(User $user, float $amount, string $orderId, string $reason): UserWalletTransaction
    {
        try {
            return DB::transaction(function () use ($user, $amount, $orderId, $reason) {
                $balanceBefore = $user->wallet_balance;
                $balanceAfter = $balanceBefore + $amount;

                $transaction = UserWalletTransaction::create([
                    'user_id' => $user->id,
                    'type' => 'credit',
                    'transaction_type' => 'refund',
                    'amount' => $amount,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'reference_id' => 'REFUND_' . $orderId,
                    'status' => 'completed',
                    'description' => $reason,
                    'metadata' => ['order_id' => $orderId],
                ]);

                $user->update(['wallet_balance' => $balanceAfter]);

                return $transaction;
            });
        } catch (\Exception $e) {
            throw new ApiException('Failed to process refund: ' . $e->getMessage(), 500, 'REFUND_FAILED');
        }
    }

    /**
     * Credit referral bonus
     */
    public function creditReferralBonus(User $referrer, User $referred, float $referrerBonus, float $referredBonus): array
    {
        try {
            return DB::transaction(function () use ($referrer, $referred, $referrerBonus, $referredBonus) {
                $refId = 'REF_' . $referred->id . '_' . time();

                // Credit referrer
                $referrerTransaction = null;
                if ($referrerBonus > 0) {
                    $rBefore = $referrer->wallet_balance;
                    $rAfter = $rBefore + $referrerBonus;

                    $referrerTransaction = UserWalletTransaction::create([
                        'user_id' => $referrer->id,
                        'type' => 'credit',
                        'transaction_type' => 'referral_bonus',
                        'amount' => $referrerBonus,
                        'balance_before' => $rBefore,
                        'balance_after' => $rAfter,
                        'reference_id' => $refId,
                        'status' => 'completed',
                        'description' => 'Referral bonus for ' . $referred->name,
                        'metadata' => ['referred_user_id' => $referred->id],
                    ]);

                    $referrer->update(['wallet_balance' => $rAfter]);
                }

                // Credit referred user
                $referredTransaction = null;
                if ($referredBonus > 0) {
                    $rBefore = $referred->wallet_balance;
                    $rAfter = $rBefore + $referredBonus;

                    $referredTransaction = UserWalletTransaction::create([
                        'user_id' => $referred->id,
                        'type' => 'credit',
                        'transaction_type' => 'referral_bonus',
                        'amount' => $referredBonus,
                        'balance_before' => $rBefore,
                        'balance_after' => $rAfter,
                        'reference_id' => $refId,
                        'status' => 'completed',
                        'description' => 'Referral signup bonus',
                        'metadata' => ['referrer_user_id' => $referrer->id],
                    ]);

                    $referred->update(['wallet_balance' => $rAfter]);
                }

                return [
                    'referrer_transaction' => $referrerTransaction,
                    'referred_transaction' => $referredTransaction,
                    'reference_id' => $refId,
                ];
            });
        } catch (\Exception $e) {
            throw new ApiException('Failed to credit referral bonus: ' . $e->getMessage(), 500, 'REFERRAL_BONUS_FAILED');
        }
    }

    /**
     * Get wallet balance
     */
    public function getBalance(User $user): float
    {
        return (float) $user->wallet_balance;
    }

    /**
     * Get transaction history
     */
    public function getTransactionHistory(User $user, int $perPage = 10)
    {
        return $user->walletTransactions()
            ->latest()
            ->paginate($perPage);
    }
}
