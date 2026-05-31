# Admin Dashboard Development Guide

## Admin Panel Overview

Admin dashboard for managing all aspects of the AddMagPro platform. Built with Laravel & Livewire for real-time updates.

---

## Project Structure

```
app/Http/Controllers/Admin/
├── DashboardController.php
├── ProductsController.php
├── CategoriesController.php
├── OrdersController.php
├── UsersController.php
├── WalletController.php
├── ReferralsController.php
├── ServicesController.php
├── BannersController.php
├── CouponsController.php
└── ReportsController.php

resources/views/admin/
├── layouts/
│   ├── app.blade.php
│   ├── sidebar.blade.php
│   └── navbar.blade.php
├── dashboard/
│   └── index.blade.php
├── products/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── categories/
│   ├── index.blade.php
│   └── manage.blade.php
├── orders/
│   ├── index.blade.php
│   └── show.blade.php
├── users/
│   ├── index.blade.php
│   └── show.blade.php
├── wallet/
│   ├── index.blade.php
│   └── transactions.blade.php
├── referrals/
│   ├── index.blade.php
│   └── manage.blade.php
├── coupons/
│   ├── index.blade.php
│   └── manage.blade.php
├── reports/
│   ├── sales.blade.php
│   ├── users.blade.php
│   └── products.blade.php
└── settings/
    └── index.blade.php
```

---

## Step 1: Admin Dashboard

### app/Http/Controllers/Admin/DashboardController.php
```php
<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\UserWalletTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        // Key Metrics
        $totalUsers = User::where('created_at', '>=', $thisMonth)->count();
        $totalOrders = Order::where('created_at', '>=', $thisMonth)->count();
        $totalRevenue = Order::where('created_at', '>=', $thisMonth)
                             ->where('payment_status', 'completed')
                             ->sum('total');
        $totalProducts = Product::count();
        
        // Today's Stats
        $todayOrders = Order::where('created_at', '>=', $today)->count();
        $todayRevenue = Order::where('created_at', '>=', $today)
                             ->where('payment_status', 'completed')
                             ->sum('total');
        
        // Charts Data
        $last7Days = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total) as revenue')
                          ->where('payment_status', 'completed')
                          ->where('created_at', '>=', now()->subDays(7))
                          ->groupBy('date')
                          ->get();
        
        // Top Products
        $topProducts = Product::withCount('orderItems')
                             ->orderByDesc('order_items_count')
                             ->limit(10)
                             ->get();
        
        // Recent Orders
        $recentOrders = Order::with('user')
                            ->latest()
                            ->limit(10)
                            ->get();
        
        return view('admin.dashboard.index', [
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalProducts' => $totalProducts,
            'todayOrders' => $todayOrders,
            'todayRevenue' => $todayRevenue,
            'last7Days' => $last7Days,
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
```

### resources/views/admin/dashboard/index.blade.php
```blade
@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>
    
    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</p>
                    <p class="text-green-600 text-sm mt-2"><i class="fas fa-arrow-up"></i> This month</p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalOrders }}</p>
                    <p class="text-green-600 text-sm mt-2"><i class="fas fa-arrow-up"></i> This month</p>
                </div>
                <div class="bg-green-100 rounded-full p-4">
                    <i class="fas fa-shopping-bag text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">₹{{ number_format($totalRevenue, 0) }}</p>
                    <p class="text-green-600 text-sm mt-2"><i class="fas fa-arrow-up"></i> This month</p>
                </div>
                <div class="bg-purple-100 rounded-full p-4">
                    <i class="fas fa-rupiah text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Products -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProducts }}</p>
                    <a href="{{ route('admin.products.index') }}" class="text-blue-600 text-sm mt-2 hover:text-blue-700">View all →</a>
                </div>
                <div class="bg-orange-100 rounded-full p-4">
                    <i class="fas fa-box text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Revenue (Last 7 Days)</h2>
            <canvas id="revenueChart"></canvas>
        </div>
        
        <!-- Orders Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Orders (Last 7 Days)</h2>
            <canvas id="ordersChart"></canvas>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200">
                        <tr>
                            <th class="text-left py-2 px-2 font-semibold">Order ID</th>
                            <th class="text-left py-2 px-2 font-semibold">Customer</th>
                            <th class="text-left py-2 px-2 font-semibold">Amount</th>
                            <th class="text-left py-2 px-2 font-semibold">Status</th>
                            <th class="text-left py-2 px-2 font-semibold">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-2 text-blue-600 font-semibold">#{{ $order->order_number }}</td>
                                <td class="py-3 px-2">{{ $order->user->name }}</td>
                                <td class="py-3 px-2 font-semibold">₹{{ number_format($order->total, 2) }}</td>
                                <td class="py-3 px-2">
                                    <span class="px-2 py-1 rounded text-xs font-semibold 
                                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm mt-4 block">View all orders →</a>
        </div>
        
        <!-- Top Products -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Top Products</h2>
            <div class="space-y-4">
                @foreach($topProducts as $product)
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $product->name }}</p>
                            <p class="text-gray-600 text-xs">{{ $product->order_items_count }} orders</p>
                        </div>
                        <span class="font-bold text-gray-900">₹{{ number_format($product->price, 0) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: @json($last7Days->pluck('date')),
        datasets: [{
            label: 'Revenue (₹)',
            data: @json($last7Days->pluck('revenue')),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});

// Orders Chart
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
new Chart(ordersCtx, {
    type: 'bar',
    data: {
        labels: @json($last7Days->pluck('date')),
        datasets: [{
            label: 'Orders',
            data: @json($last7Days->pluck('count')),
            backgroundColor: '#10b981'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
@endsection
```

---

## Step 2: Product Management

### app/Http/Controllers/Admin/ProductsController.php
```php
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')
                          ->paginate(20);
        
        return view('admin.products.index', ['products' => $products]);
    }
    
    public function create(): View
    {
        $categories = Category::all();
        return view('admin.products.create', ['categories' => $categories]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);
        
        Product::create($validated);
        
        return redirect()->route('admin.products.index')
                       ->with('success', 'Product created successfully');
    }
    
    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }
    
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);
        
        $product->update($validated);
        
        return redirect()->route('admin.products.index')
                       ->with('success', 'Product updated successfully');
    }
    
    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products.index')
                       ->with('success', 'Product deleted successfully');
    }
}
```

### resources/views/admin/products/index.blade.php
```blade
@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Add Product
        </a>
    </div>
    
    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="get" class="flex gap-4">
            <input 
                type="text" 
                name="search" 
                placeholder="Search products..."
                value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg"
            >
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Categories</option>
                @foreach(\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Filter
            </button>
        </form>
    </div>
    
    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Product</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Category</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Price</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Stock</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $product->image_url ?? 'https://via.placeholder.com/50' }}" alt="{{ $product->name }}" class="w-12 h-12 rounded object-cover">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $product->sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-gray-700">{{ $product->category->name }}</td>
                        <td class="px-6 py-3 font-semibold text-gray-900">₹{{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded text-sm font-semibold {{ $product->stock_quantity > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <input type="checkbox" {{ $product->is_active ? 'checked' : '' }} class="rounded" onchange="updateStatus({{ $product->id }}, this.checked)">
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-700 mr-3">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
```

---

## Step 3: Orders Management

### resources/views/admin/orders/index.blade.php
```blade
@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Orders</h1>
    
    <!-- Status Filter -->
    <div class="bg-white rounded-lg shadow p-4 mb-6 flex gap-4">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            All Orders
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded {{ request('status') === 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Pending
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="px-4 py-2 rounded {{ request('status') === 'shipped' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Shipped
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="px-4 py-2 rounded {{ request('status') === 'delivered' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
            Delivered
        </a>
    </div>
    
    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Order ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Amount</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Payment</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-semibold text-blue-600">#{{ $order->order_number }}</td>
                        <td class="px-6 py-3">
                            <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                        </td>
                        <td class="px-6 py-3 font-semibold text-gray-900">₹{{ number_format($order->total, 2) }}</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded text-sm font-semibold bg-yellow-100 text-yellow-700">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded text-sm font-semibold {{ $order->payment_status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-700">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-700 font-semibold">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">No orders found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
```

---

## Step 4: Admin Routes

### routes/web.php (Admin Section)
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Products
    Route::resource('products', ProductsController::class, ['as' => 'admin']);
    
    // Categories
    Route::resource('categories', CategoriesController::class, ['as' => 'admin']);
    
    // Orders
    Route::resource('orders', OrdersController::class, ['only' => ['index', 'show'], 'as' => 'admin']);
    
    // Users
    Route::resource('users', UsersController::class, ['only' => ['index', 'show'], 'as' => 'admin']);
    
    // Wallet
    Route::get('wallet/transactions', [WalletController::class, 'transactions'])->name('admin.wallet.transactions');
    
    // Referrals
    Route::get('referrals', [ReferralsController::class, 'index'])->name('admin.referrals.index');
    
    // Coupons
    Route::resource('coupons', CouponsController::class, ['as' => 'admin']);
    
    // Banners
    Route::resource('banners', BannersController::class, ['as' => 'admin']);
    
    // Services
    Route::resource('services', ServicesController::class, ['as' => 'admin']);
    
    // Reports
    Route::get('reports/sales', [ReportsController::class, 'sales'])->name('admin.reports.sales');
    Route::get('reports/users', [ReportsController::class, 'users'])->name('admin.reports.users');
    Route::get('reports/products', [ReportsController::class, 'products'])->name('admin.reports.products');
});
```

---

## Step 5: Admin Middleware

### app/Http/Middleware/AdminMiddleware.php
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }
        
        return $next($request);
    }
}
```

---

## Step 6: Setup Instructions

### 1. Add Admin Field to Users Table
```php
php artisan make:migration add_is_admin_to_users_table

// In migration:
Schema::table('users', function (Blueprint $table) {
    $table->boolean('is_admin')->default(false);
});

php artisan migrate
```

### 2. Make First User Admin (Tinker)
```bash
php artisan tinker
>>> User::first()->update(['is_admin' => true])
```

### 3. Visit Admin Panel
Navigate to: `http://localhost/admagpro/admin`

---

## Admin Features

✅ Dashboard with key metrics
✅ Product management (CRUD)
✅ Category management
✅ Order management & tracking
✅ User management
✅ Wallet transactions
✅ Referral management
✅ Coupon management
✅ Banner management
✅ Services management
✅ Sales reports
✅ User analytics
✅ Search product performance

---

Generated: May 25, 2026
