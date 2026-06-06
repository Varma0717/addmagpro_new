<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserWalletTransaction;
use App\Services\WalletService;
use App\Services\RazorpayService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletApiController extends Controller
{
    use ApiResponse;

    protected WalletService $walletService;
    protected RazorpayService $razorpayService;

    public function __construct(WalletService $walletService, RazorpayService $razorpayService)
    {
        $this->walletService = $walletService;
        $this->razorpayService = $razorpayService;
        $this->middleware('auth:sanctum');
    }

    /**
     * Get wallet balance and overview
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = $user->walletTransactions()
            ->latest()
            ->limit(20)
            ->get()
            ->map(function ($tx) {
                return [
                    'id' => (int) $tx->id,
                    'type' => (string) $tx->type,
                    'amount' => (float) $tx->amount,
                    'description' => (string) ($tx->description ?? ''),
                    'reference_type' => (string) ($tx->transaction_type ?? ''),
                    'balance_after' => (float) ($tx->balance_after ?? 0),
                    'created_at' => $tx->created_at,
                ];
            })
            ->values();

        $withdrawRequests = $user->walletTransactions()
            ->where('transaction_type', 'withdraw_request')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($tx) {
                return [
                    'id' => (int) $tx->id,
                    'request_no' => 'WDR-' . str_pad((string) $tx->id, 6, '0', STR_PAD_LEFT),
                    'amount' => (float) $tx->amount,
                    'status' => (string) ($tx->status ?? 'pending'),
                    'remarks' => (string) ($tx->description ?? ''),
                    'created_at' => $tx->created_at,
                ];
            })
            ->values();

        return $this->successResponse([
            'balance' => (float) $user->wallet_balance,
            'preset_amounts' => [100, 200, 500, 1000, 2000, 5000],
            'transactions' => $transactions,
            'recent_withdraw_requests' => $withdrawRequests,
            'total_transactions' => $user->walletTransactions()->count(),
            'pending_transactions' => $user->walletTransactions()
                ->where('status', 'pending')
                ->count(),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
        ], 'Wallet retrieved successfully');
    }

    /**
     * Initiate wallet topup via Razorpay
     */
    public function createTopup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:' . config('wallet.min_topup') . '|max:' . config('wallet.max_topup'),
            'payment_method' => 'sometimes|in:razorpay,upi,card',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            $amount = (int) ($request->amount * 100); // Convert to paise

            // Create Razorpay order
            $razorpayOrder = $this->razorpayService->createOrder(
                orderId: 'TOPUP_' . $user->id . '_' . time(),
                amount: $amount,
                currency: 'INR',
                customerName: $user->name,
                customerEmail: $user->email,
                customerPhone: $user->phone,
                description: 'Wallet Topup'
            );

            // Store pending transaction
            $transaction = UserWalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'transaction_type' => 'topup',
                'amount' => $request->amount,
                'balance_before' => $user->wallet_balance,
                'balance_after' => $user->wallet_balance + $request->amount,
                'reference_id' => $razorpayOrder['id'],
                'status' => 'pending',
                'description' => 'Pending Razorpay topup',
                'metadata' => [
                    'razorpay_order_id' => $razorpayOrder['id'],
                    'payment_method' => $request->get('payment_method', 'razorpay'),
                ],
            ]);

            return $this->successResponse([
                'order_id' => $razorpayOrder['id'],
                'amount' => $request->amount,
                'currency' => 'INR',
                'razorpay_key' => config('razorpay.key_id'),
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone,
                'transaction_id' => $transaction->id,
            ], 'Topup order created', 201);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create topup order: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Verify Razorpay payment and credit wallet
     */
    public function verifyTopup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();

            // Verify payment signature
            $isValid = $this->razorpayService->verifyPaymentSignature(
                orderId: $request->razorpay_order_id,
                paymentId: $request->razorpay_payment_id,
                signature: $request->razorpay_signature
            );

            if (!$isValid) {
                return $this->errorResponse('Invalid payment signature', [], 400);
            }

            // Get payment details
            $payment = $this->razorpayService->getPayment($request->razorpay_payment_id);

            if ($payment['status'] !== 'captured') {
                return $this->errorResponse('Payment not captured', [], 400);
            }

            // Find and update transaction
            $transaction = UserWalletTransaction::where('reference_id', $request->razorpay_order_id)
                ->where('user_id', $user->id)
                ->first();

            if (!$transaction) {
                return $this->notFoundResponse('Transaction not found');
            }

            if ($transaction->status === 'completed') {
                // Already verified
                return $this->successResponse([
                    'message' => 'Payment already verified',
                    'transaction_id' => $transaction->id,
                    'balance' => (float) $user->wallet_balance,
                ], 'Payment already processed');
            }

            // Credit wallet
            $amount = $payment['amount'] / 100; // Convert from paise
            $topupTransaction = $this->walletService->topupWallet(
                user: $user,
                amount: $amount,
                referenceId: $request->razorpay_payment_id,
                metadata: [
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_order_id' => $request->razorpay_order_id,
                ]
            );

            // Mark pending transaction as completed
            $transaction->update(['status' => 'completed']);

            return $this->successResponse([
                'transaction_id' => $topupTransaction->id,
                'amount_credited' => $amount,
                'new_balance' => (float) $user->fresh()->wallet_balance,
            ], 'Payment verified and wallet credited', 200);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to verify payment: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Send money to another user
     */
    public function sendMoney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_identifier' => 'required|string', // email or phone
            'amount' => 'required|numeric|min:1',
            'description' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $sender = $request->user();

            // Find recipient
            $recipient = User::where('email', $request->recipient_identifier)
                ->orWhere('phone', $request->recipient_identifier)
                ->first();

            if (!$recipient) {
                return $this->notFoundResponse('Recipient not found');
            }

            // Send money
            $result = $this->walletService->sendMoney(
                sender: $sender,
                receiver: $recipient,
                amount: $request->amount,
                description: $request->get('description')
            );

            return $this->successResponse([
                'transfer_id' => $result['reference_id'],
                'sender_balance' => (float) $sender->fresh()->wallet_balance,
                'recipient' => [
                    'id' => $recipient->id,
                    'name' => $recipient->name,
                    'email' => $recipient->email,
                ],
            ], 'Money transferred successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage(),
                [],
                400
            );
        }
    }

    /**
     * Self-transfer (wallet to bank)
     */
    public function selfTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100',
            'account_holder_name' => 'required|string',
            'account_number' => 'required|string|size:12',
            'ifsc_code' => 'required|string|size:11',
            'description' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();

            if ($user->wallet_balance < $request->amount) {
                return $this->errorResponse('Insufficient wallet balance', [], 400);
            }

            // Create withdrawal request (pending admin approval)
            $transaction = UserWalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'debit',
                'transaction_type' => 'transfer_send', // Reusing for self-transfer
                'amount' => $request->amount,
                'balance_before' => $user->wallet_balance,
                'balance_after' => $user->wallet_balance - $request->amount,
                'status' => 'pending',
                'description' => 'Self-transfer to bank account',
                'metadata' => [
                    'account_holder_name' => $request->account_holder_name,
                    'account_number' => $request->account_number,
                    'ifsc_code' => $request->ifsc_code,
                    'transfer_type' => 'bank_transfer',
                ],
            ]);

            return $this->successResponse([
                'transfer_id' => $transaction->id,
                'amount' => $request->amount,
                'status' => 'pending_approval',
                'message' => 'Withdrawal request submitted. Admin will process within 24 hours.',
            ], 'Self-transfer request created', 201);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create transfer request: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Create a wallet withdraw request used by mobile app
     */
    public function createWithdrawRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100',
            'remarks' => 'sometimes|nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            $amount = (float) $request->amount;

            if ((float) $user->wallet_balance < $amount) {
                return $this->errorResponse('Insufficient wallet balance', [], 400);
            }

            $transaction = UserWalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'debit',
                'transaction_type' => 'withdraw_request',
                'amount' => $amount,
                'balance_before' => (float) $user->wallet_balance,
                // Balance is not deducted immediately; admin approval flow can settle it later.
                'balance_after' => (float) $user->wallet_balance,
                'reference_id' => 'WDR_' . $user->id . '_' . time(),
                'status' => 'pending',
                'description' => (string) $request->get('remarks', 'Wallet withdrawal request'),
                'metadata' => [
                    'source' => 'mobile-app',
                ],
            ]);

            return $this->successResponse([
                'id' => (int) $transaction->id,
                'request_no' => 'WDR-' . str_pad((string) $transaction->id, 6, '0', STR_PAD_LEFT),
                'amount' => (float) $transaction->amount,
                'status' => (string) $transaction->status,
                'remarks' => (string) ($transaction->description ?? ''),
                'created_at' => $transaction->created_at,
            ], 'Withdraw request created', 201);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create withdraw request: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get wallet transaction history
     */
    public function transactions(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $type = $request->get('type'); // credit, debit
            $transactionType = $request->get('transaction_type'); // topup, purchase, etc.

            $query = $request->user()->walletTransactions();

            if ($type) {
                $query->where('type', $type);
            }

            if ($transactionType) {
                $query->where('transaction_type', $transactionType);
            }

            $transactions = $query->latest()->paginate($perPage);

            return $this->paginatedResponse(
                $transactions,
                'Transactions retrieved'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch transactions: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get a single transaction
     */
    public function getTransaction(Request $request, int $transactionId)
    {
        try {
            $transaction = $request->user()
                ->walletTransactions()
                ->find($transactionId);

            if (!$transaction) {
                return $this->notFoundResponse('Transaction not found');
            }

            return $this->successResponse($transaction, 'Transaction retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch transaction: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get wallet statistics
     */
    public function statistics(Request $request)
    {
        try {
            $user = $request->user();

            $totalCredit = $user->walletTransactions()
                ->where('type', 'credit')
                ->where('status', 'completed')
                ->sum('amount');

            $totalDebit = $user->walletTransactions()
                ->where('type', 'debit')
                ->where('status', 'completed')
                ->sum('amount');

            $monthlyCredit = $user->walletTransactions()
                ->where('type', 'credit')
                ->where('status', 'completed')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('amount');

            $monthlyDebit = $user->walletTransactions()
                ->where('type', 'debit')
                ->where('status', 'completed')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('amount');

            return $this->successResponse([
                'current_balance' => (float) $user->wallet_balance,
                'lifetime_credit' => (float) $totalCredit,
                'lifetime_debit' => (float) $totalDebit,
                'this_month_credit' => (float) $monthlyCredit,
                'this_month_debit' => (float) $monthlyDebit,
                'total_transactions' => $user->walletTransactions()->count(),
            ], 'Statistics retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch statistics: ' . $e->getMessage(),
                [],
                500
            );
        }
    }
}
