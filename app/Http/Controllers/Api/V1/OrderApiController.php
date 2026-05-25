<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CouponUsage;
use App\Services\WalletService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderApiController extends Controller
{
    use ApiResponse;

    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
        $this->middleware('auth:sanctum');
    }

    /**
     * Get user's orders
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $perPage = $request->get('per_page', 10);
            $status = $request->get('status'); // pending, confirmed, shipped, delivered, cancelled, returned

            $query = Order::where('user_id', $user->id)
                ->with('items.product')
                ->latest();

            if ($status) {
                $query->where('status', $status);
            }

            $orders = $query->paginate($perPage);

            collect($orders->items())->transform(function ($order) {
                return $this->formatOrderResponse($order);
            });

            return $this->paginatedResponse($orders, 'Orders retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch orders: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get single order details
     */
    public function show(Request $request, int $orderId)
    {
        try {
            $user = $request->user();
            $order = Order::where('user_id', $user->id)
                ->with('items.product')
                ->find($orderId);

            if (!$order) {
                return $this->notFoundResponse('Order not found');
            }

            return $this->successResponse($this->formatOrderResponse($order), 'Order details retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch order: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Create order from cart
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_postal_code' => 'required|string',
            'shipping_phone' => 'required|string',
            'billing_address' => 'nullable|string',
            'billing_city' => 'nullable|string',
            'billing_state' => 'nullable|string',
            'billing_postal_code' => 'nullable|string',
            'billing_phone' => 'nullable|string',
            'payment_method' => 'required|in:card,wallet,upi,netbanking',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            $cart = $user->cart()->with('items.product')->first();

            if (!$cart || $cart->items->isEmpty()) {
                return $this->errorResponse('Cart is empty', [], 400);
            }

            // Validate stock availability
            foreach ($cart->items as $item) {
                if ($item->product->stock_quantity < $item->quantity) {
                    return $this->errorResponse(
                        'Insufficient stock for ' . $item->product->name,
                        ['product_id' => $item->product->id],
                        400
                    );
                }
            }

            // Use transaction to ensure data consistency
            $order = DB::transaction(function () use ($request, $user, $cart) {
                // Create order
                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => $this->generateOrderNumber(),
                    'status' => 'pending',
                    'subtotal' => $cart->subtotal,
                    'tax_amount' => $cart->tax_amount,
                    'discount_amount' => $cart->discount_amount,
                    'total' => $cart->total,
                    'shipping_address' => $request->shipping_address,
                    'shipping_city' => $request->shipping_city,
                    'shipping_state' => $request->shipping_state,
                    'shipping_postal_code' => $request->shipping_postal_code,
                    'shipping_phone' => $request->shipping_phone,
                    'billing_address' => $request->billing_address ?? $request->shipping_address,
                    'billing_city' => $request->billing_city ?? $request->shipping_city,
                    'billing_state' => $request->billing_state ?? $request->shipping_state,
                    'billing_postal_code' => $request->billing_postal_code ?? $request->shipping_postal_code,
                    'billing_phone' => $request->billing_phone ?? $request->shipping_phone,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
                    'notes' => $request->notes,
                ]);

                // Create order items
                foreach ($cart->items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->price,
                        'subtotal' => $item->subtotal,
                    ]);

                    // Reduce product stock
                    $item->product->decrement('stock_quantity', $item->quantity);
                }

                // Record coupon usage if applied
                if ($cart->coupon_code) {
                    $coupon = \App\Models\Coupon::where('code', $cart->coupon_code)->first();
                    if ($coupon) {
                        CouponUsage::create([
                            'coupon_id' => $coupon->id,
                            'user_id' => $user->id,
                            'order_id' => $order->id,
                        ]);
                    }
                }

                return $order;
            });

            // Handle payment
            if ($request->payment_method === 'wallet') {
                if ($user->wallet_balance < $order->total) {
                    // Rollback order creation
                    $order->delete();
                    return $this->errorResponse('Insufficient wallet balance', [], 400);
                }

                // Deduct from wallet
                try {
                    $this->walletService->deductForPurchase($user, $order->total, $order->id, 'ORDER_' . $order->id);
                    $order->update(['payment_status' => 'completed']);
                } catch (\Exception $e) {
                    return $this->errorResponse('Payment failed: ' . $e->getMessage(), [], 400);
                }
            }

            // Clear cart
            $cart->items()->delete();
            $cart->delete();

            return $this->successResponse(
                $this->formatOrderResponse($order),
                'Order created successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create order: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Cancel order
     */
    public function cancel(Request $request, int $orderId)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            $order = Order::where('user_id', $user->id)->find($orderId);

            if (!$order) {
                return $this->notFoundResponse('Order not found');
            }

            if (!in_array($order->status, ['pending', 'confirmed'])) {
                return $this->errorResponse(
                    'Cannot cancel order with status: ' . $order->status,
                    [],
                    400
                );
            }

            // Use transaction
            DB::transaction(function () use ($order, $request) {
                // Restore product stock
                foreach ($order->items as $item) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }

                // Refund if paid
                if ($order->payment_status === 'completed') {
                    if ($order->payment_method === 'wallet') {
                        $this->walletService->refundToWallet(
                            $order->user,
                            $order->total,
                            $order->id,
                            'Order cancellation - ' . ($request->reason ?? 'No reason provided')
                        );
                    }
                }

                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'refunded',
                    'cancelled_at' => now(),
                ]);
            });

            return $this->successResponse(
                $this->formatOrderResponse($order),
                'Order cancelled successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to cancel order: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Request return
     */
    public function requestReturn(Request $request, int $orderId)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            $order = Order::where('user_id', $user->id)->find($orderId);

            if (!$order) {
                return $this->notFoundResponse('Order not found');
            }

            if ($order->status !== 'delivered') {
                return $this->errorResponse('Only delivered orders can be returned', [], 400);
            }

            if (!$order->can_return) {
                return $this->errorResponse('Return window has expired (7 days)', [], 400);
            }

            $order->update(['status' => 'return_requested']);

            return $this->successResponse(
                $this->formatOrderResponse($order),
                'Return request submitted. We will review it shortly.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to request return: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Track order
     */
    public function track(Request $request, $orderId)
    {
        try {
            $user = $request->user();
            $order = Order::where('user_id', $user->id)->find($orderId);

            if (!$order) {
                return $this->notFoundResponse('Order not found');
            }

            $statusTimeline = [
                'pending' => ['status' => 'pending', 'message' => 'Order placed', 'completed' => true],
                'confirmed' => ['status' => 'confirmed', 'message' => 'Order confirmed', 'completed' => in_array($order->status, ['confirmed', 'shipped', 'delivered'])],
                'shipped' => ['status' => 'shipped', 'message' => 'Order shipped', 'completed' => in_array($order->status, ['shipped', 'delivered'])],
                'delivered' => ['status' => 'delivered', 'message' => 'Order delivered', 'completed' => $order->status === 'delivered'],
            ];

            return $this->successResponse([
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'tracking_number' => $order->tracking_number,
                'timeline' => array_values($statusTimeline),
                'estimated_delivery' => $order->updated_at->addDays(7),
            ], 'Order tracking retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to track order: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    /**
     * Get order statistics
     */
    public function statistics(Request $request)
    {
        try {
            $user = $request->user();

            $stats = [
                'total_orders' => Order::where('user_id', $user->id)->count(),
                'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
                'delivered_orders' => Order::where('user_id', $user->id)->where('status', 'delivered')->count(),
                'cancelled_orders' => Order::where('user_id', $user->id)->where('status', 'cancelled')->count(),
                'total_spent' => (float) Order::where('user_id', $user->id)
                    ->whereIn('status', ['delivered', 'shipped', 'confirmed'])
                    ->sum('total'),
                'this_month_orders' => Order::where('user_id', $user->id)
                    ->whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month)
                    ->count(),
            ];

            return $this->successResponse($stats, 'Order statistics retrieved');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch statistics: ' . $e->getMessage(),
                [],
                500
            );
        }
    }

    // Helper Methods

    /**
     * Format order response
     */
    private function formatOrderResponse($order): array
    {
        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'status' => $order->status,
            'items' => $order->items->map(fn($item) => [
                'id' => $item->id,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product_name,
                    'slug' => $item->product->slug,
                    'image_url' => $item->product->images()->where('is_primary', true)->first()?->image_url,
                ],
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'subtotal' => (float) $item->subtotal,
            ])->toArray(),
            'subtotal' => (float) $order->subtotal,
            'tax_amount' => (float) $order->tax_amount,
            'discount_amount' => (float) $order->discount_amount,
            'total' => (float) $order->total,
            'payment_method' => $order->payment_method,
            'payment_status' => $order->payment_status,
            'shipping_address' => $order->shipping_address,
            'shipping_city' => $order->shipping_city,
            'shipping_state' => $order->shipping_state,
            'shipping_postal_code' => $order->shipping_postal_code,
            'shipping_phone' => $order->shipping_phone,
            'tracking_number' => $order->tracking_number,
            'is_completed' => $order->is_completed,
            'can_return' => $order->can_return,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ];
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber(): string
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
    }
}
