<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderApiController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $perPage = max(1, min(100, (int) $request->get('per_page', 10)));
            $orders = DB::table('orders_list')
                ->where(function ($q) use ($user) {
                    $q->where('customer_name', $user->name)
                        ->orWhere('customer_name', $user->phone)
                        ->orWhere('customer_name', $user->email);
                })
                ->orderByDesc('order_date')
                ->paginate($perPage);

            $items = collect($orders->items())
                ->map(fn($order) => $this->formatOrderSummary($order))
                ->values();

            return response()->json([
                'success' => true,
                'data' => $items,
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total(),
                    'last_page' => $orders->lastPage(),
                    'from' => $orders->firstItem(),
                    'to' => $orders->lastItem(),
                    'has_more' => $orders->hasMorePages(),
                ],
                'message' => 'Orders retrieved',
                'timestamp' => now()->toIso8601String(),
            ]);
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch orders: ' . $e->getMessage(), [], 500);
        }
    }

    public function show(Request $request, int $orderId)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $order = DB::table('orders_list')
                ->where('order_id', $orderId)
                ->where(function ($q) use ($user) {
                    $q->where('customer_name', $user->name)
                        ->orWhere('customer_name', $user->phone)
                        ->orWhere('customer_name', $user->email);
                })
                ->first();

            if (!$order) {
                return $this->notFoundResponse('Order not found');
            }

            $items = DB::table('orders_list as o')
                ->leftJoin('products_list as p', 'o.product_id', '=', 'p.product_id')
                ->where('o.order_id', $orderId)
                ->select([
                    'o.order_id',
                    'o.product_id',
                    'o.amount',
                    'p.product_name',
                    'p.unit_price',
                    'p.product_images',
                ])
                ->get()
                ->map(function ($row) {
                    return [
                        'id' => (int) $row->order_id,
                        'product_id' => (int) ($row->product_id ?? 0),
                        'product_name' => (string) ($row->product_name ?? 'Product'),
                        'quantity' => 1,
                        'unit_price' => (float) ($row->unit_price ?? $row->amount ?? 0),
                        'price' => (float) ($row->unit_price ?? $row->amount ?? 0),
                        'subtotal' => (float) ($row->amount ?? $row->unit_price ?? 0),
                        'image_url' => $row->product_images,
                        'product' => [
                            'id' => (int) ($row->product_id ?? 0),
                            'name' => (string) ($row->product_name ?? 'Product'),
                            'primary_image_url' => $row->product_images,
                            'image_url' => $row->product_images,
                        ],
                    ];
                })
                ->values();

            $total = (float) ($order->amount ?? 0);

            return $this->successResponse([
                'id' => (int) $order->order_id,
                'order_number' => 'ORD-' . (int) $order->order_id,
                'status' => 'confirmed',
                'payment_method' => null,
                'payment_status' => null,
                'total' => $total,
                'subtotal' => $total,
                'discount' => 0,
                'discount_amount' => 0,
                'shipping_address' => null,
                'items' => $items,
                'created_at' => $order->created_at,
            ], 'Order details retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch order: ' . $e->getMessage(), [], 500);
        }
    }

    public function create(Request $request)
    {
        return $this->errorResponse('Order creation from app cart is not enabled yet on this server', [], 400);
    }

    public function cancel(Request $request, int $orderId)
    {
        return $this->errorResponse('Order cancellation is not enabled yet on this server', [], 400);
    }

    public function requestReturn(Request $request, int $orderId)
    {
        return $this->errorResponse('Order return is not enabled yet on this server', [], 400);
    }

    public function track(Request $request, $orderId)
    {
        return $this->successResponse([
            'order_id' => (int) $orderId,
            'status' => 'confirmed',
            'timeline' => [
                ['status' => 'pending', 'message' => 'Order placed', 'completed' => true],
                ['status' => 'confirmed', 'message' => 'Order confirmed', 'completed' => true],
                ['status' => 'shipped', 'message' => 'Preparing for dispatch', 'completed' => false],
                ['status' => 'delivered', 'message' => 'Delivered', 'completed' => false],
            ],
        ], 'Order tracking retrieved');
    }

    public function statistics(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $query = DB::table('orders_list')->where(function ($q) use ($user) {
                $q->where('customer_name', $user->name)
                    ->orWhere('customer_name', $user->phone)
                    ->orWhere('customer_name', $user->email);
            });

            $totalOrders = (clone $query)->count();
            $totalSpent = (float) ((clone $query)->sum('amount') ?? 0);

            return $this->successResponse([
                'total_orders' => $totalOrders,
                'pending_orders' => 0,
                'delivered_orders' => 0,
                'cancelled_orders' => 0,
                'total_spent' => $totalSpent,
                'this_month_orders' => 0,
            ], 'Order statistics retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch order statistics: ' . $e->getMessage(), [], 500);
        }
    }

    private function formatOrderSummary(object $order): array
    {
        return [
            'id' => (int) $order->order_id,
            'order_number' => 'ORD-' . (int) $order->order_id,
            'status' => 'confirmed',
            'payment_method' => null,
            'payment_status' => null,
            'items_count' => 1,
            'total' => (float) ($order->amount ?? 0),
            'created_at' => $order->created_at,
        ];
    }
}
