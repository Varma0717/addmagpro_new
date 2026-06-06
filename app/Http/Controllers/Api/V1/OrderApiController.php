<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
            $query = DB::table('orders_list');
            $this->applyUserFilter($query, $user);

            $orders = $query
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

            $query = DB::table('orders_list');
            $orderIdColumn = $this->resolveOrderIdColumn();
            $query->where($orderIdColumn, $orderId);
            $this->applyUserFilter($query, $user);

            $order = $query->first();

            if (!$order) {
                return $this->notFoundResponse('Order not found');
            }

            $items = $this->resolveOrderItems($order, $orderId);
            $total = (float) ($order->total_amount ?? $order->amount ?? 0);

            return $this->successResponse([
                'id' => (int) ($order->{$orderIdColumn} ?? $orderId),
                'order_number' => (string) ($order->unique_id ?? ('ORD-' . (int) ($order->{$orderIdColumn} ?? $orderId))),
                'status' => (string) ($order->status ?? 'confirmed'),
                'payment_method' => $order->payment_method ?? null,
                'payment_status' => null,
                'total' => $total,
                'subtotal' => $total,
                'discount' => 0,
                'discount_amount' => 0,
                'shipping_address' => $order->address ?? null,
                'items' => $items,
                'created_at' => $order->created_at ?? $order->order_date ?? null,
            ], 'Order details retrieved');
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to fetch order: ' . $e->getMessage(), [], 500);
        }
    }

    public function create(Request $request)
    {
        $validator = validator($request->all(), [
            'shipping_address' => 'required|string|min:5',
            'shipping_city' => 'required|string|min:2',
            'shipping_state' => 'required|string|min:2',
            'shipping_postal_code' => 'required|string|min:4|max:10',
            'shipping_phone' => 'required|string|min:8|max:20',
            'payment_method' => 'required|string',
            'notes' => 'sometimes|nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray(), 422);
        }

        try {
            $user = $request->user();
            if (!$user) {
                return $this->unauthorizedResponse('Authentication required', 401);
            }

            $cartRows = DB::table('cart_products as c')
                ->leftJoin('products_list as p', 'c.product_id', '=', 'p.product_id')
                ->where('c.service_user_id', $user->id)
                ->select([
                    'c.product_id',
                    'c.quantity',
                    'p.product_name',
                    'p.unit_price',
                    'p.product_images',
                ])
                ->get();

            if ($cartRows->isEmpty()) {
                return $this->errorResponse('Cart is empty', [], 400);
            }

            $lineItems = $cartRows->map(function ($row) {
                $qty = max(1, (int) ($row->quantity ?? 1));
                $price = (float) ($row->unit_price ?? 0);

                return [
                    'product_id' => (int) ($row->product_id ?? 0),
                    'product_name' => (string) ($row->product_name ?? 'Product'),
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $price * $qty,
                    'image_url' => $row->product_images,
                ];
            })->values();

            $totalAmount = (float) $lineItems->sum('subtotal');

            $order = Order::create([
                'user_id' => $user->id,
                'first_name' => $user->name,
                'email' => $user->email,
                'mobile_no' => $request->shipping_phone,
                'address' => $request->shipping_address,
                'zip_code' => $request->shipping_postal_code,
                'city' => $request->shipping_city,
                'state' => $request->shipping_state,
                'oredered_products' => $lineItems->toJson(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'confirmation_status' => 0,
                'location' => $request->shipping_address,
                'unique_id' => 'ORD-' . strtoupper(Str::random(10)),
            ]);

            DB::table('cart_products')
                ->where('service_user_id', $user->id)
                ->delete();

            return $this->successResponse([
                'id' => (int) ($order->order_id ?? $order->id),
                'order_number' => (string) ($order->unique_id ?? ('ORD-' . (int) ($order->order_id ?? $order->id))),
                'status' => (string) ($order->status ?? 'pending'),
                'total' => (float) ($order->total_amount ?? 0),
            ], 'Order created successfully', 201);
        } catch (\Throwable $e) {
            return $this->errorResponse('Failed to create order: ' . $e->getMessage(), [], 500);
        }
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

            $query = DB::table('orders_list');
            $this->applyUserFilter($query, $user);

            $totalOrders = (clone $query)->count();
            $amountColumn = Schema::hasColumn('orders_list', 'total_amount') ? 'total_amount' : 'amount';
            $totalSpent = (float) ((clone $query)->sum($amountColumn) ?? 0);

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
        $idColumn = property_exists($order, 'order_id') ? 'order_id' : (property_exists($order, 'id') ? 'id' : null);
        $id = (int) ($idColumn ? ($order->{$idColumn} ?? 0) : 0);
        $total = (float) ($order->total_amount ?? $order->amount ?? 0);

        return [
            'id' => $id,
            'order_number' => (string) ($order->unique_id ?? ('ORD-' . $id)),
            'status' => (string) ($order->status ?? 'confirmed'),
            'payment_method' => $order->payment_method ?? null,
            'payment_status' => null,
            'items_count' => 1,
            'total' => $total,
            'created_at' => $order->created_at ?? $order->order_date ?? null,
        ];
    }

    private function resolveOrderIdColumn(): string
    {
        return Schema::hasColumn('orders_list', 'order_id') ? 'order_id' : 'id';
    }

    private function applyUserFilter($query, $user): void
    {
        if (Schema::hasColumn('orders_list', 'user_id')) {
            $query->where('user_id', $user->id);
            return;
        }

        $candidates = [];
        if (Schema::hasColumn('orders_list', 'customer_name')) {
            $candidates[] = ['customer_name', $user->name];
            $candidates[] = ['customer_name', $user->phone];
            $candidates[] = ['customer_name', $user->email];
        }
        if (Schema::hasColumn('orders_list', 'first_name')) {
            $candidates[] = ['first_name', $user->name];
        }
        if (Schema::hasColumn('orders_list', 'mobile_no')) {
            $candidates[] = ['mobile_no', $user->phone];
        }
        if (Schema::hasColumn('orders_list', 'email')) {
            $candidates[] = ['email', $user->email];
        }

        if (empty($candidates)) {
            $query->whereRaw('1 = 0');
            return;
        }

        $query->where(function ($q) use ($candidates) {
            foreach ($candidates as [$column, $value]) {
                if ($value !== null && $value !== '') {
                    $q->orWhere($column, $value);
                }
            }
        });
    }

    private function resolveOrderItems(object $order, int $orderId)
    {
        $raw = $order->oredered_products ?? null;
        if (is_string($raw) && trim($raw) !== '') {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $items = collect($decoded)
                    ->filter(fn($item) => is_array($item))
                    ->map(function ($item) use ($orderId) {
                        $productId = (int) ($item['product_id'] ?? 0);
                        $name = (string) ($item['product_name'] ?? 'Product');
                        $qty = max(1, (int) ($item['quantity'] ?? 1));
                        $unitPrice = (float) ($item['unit_price'] ?? 0);
                        $subtotal = (float) ($item['subtotal'] ?? ($unitPrice * $qty));
                        $image = $item['image_url'] ?? null;

                        return [
                            'id' => $orderId,
                            'product_id' => $productId,
                            'product_name' => $name,
                            'quantity' => $qty,
                            'unit_price' => $unitPrice,
                            'price' => $unitPrice,
                            'subtotal' => $subtotal,
                            'image_url' => $image,
                            'product' => [
                                'id' => $productId,
                                'name' => $name,
                                'primary_image_url' => $image,
                                'image_url' => $image,
                            ],
                        ];
                    })
                    ->values();

                if ($items->isNotEmpty()) {
                    return $items;
                }
            }
        }

        $idColumn = $this->resolveOrderIdColumn();
        return DB::table('orders_list as o')
            ->leftJoin('products_list as p', 'o.product_id', '=', 'p.product_id')
            ->where('o.' . $idColumn, $orderId)
            ->select([
                'o.' . $idColumn . ' as order_row_id',
                'o.product_id',
                'o.amount',
                'p.product_name',
                'p.unit_price',
                'p.product_images',
            ])
            ->get()
            ->map(function ($row) use ($orderId) {
                return [
                    'id' => (int) $orderId,
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
    }
}
