@extends('admin.layout')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Key Metrics -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Users</p>
                <p class="text-3xl font-bold text-gray-900" id="total-users">0</p>
                <p class="text-xs text-green-600 mt-1">+12% this month</p>
            </div>
            <i class="fas fa-users text-4xl text-blue-600 opacity-20"></i>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900" id="total-orders">0</p>
                <p class="text-xs text-green-600 mt-1">+8% this month</p>
            </div>
            <i class="fas fa-shopping-bag text-4xl text-green-600 opacity-20"></i>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-900">₹<span id="total-revenue">0</span></p>
                <p class="text-xs text-green-600 mt-1">+15% this month</p>
            </div>
            <i class="fas fa-rupee-sign text-4xl text-orange-600 opacity-20"></i>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Active Products</p>
                <p class="text-3xl font-bold text-gray-900" id="total-products">0</p>
                <p class="text-xs text-green-600 mt-1">+5% this month</p>
            </div>
            <i class="fas fa-box text-4xl text-purple-600 opacity-20"></i>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Revenue Trend (Last 7 Days)</h3>
        <canvas id="revenueChart" height="80"></canvas>
    </div>

    <!-- Orders Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Orders Trend (Last 7 Days)</h3>
        <canvas id="ordersChart" height="80"></canvas>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Orders</h3>
    <table class="w-full">
        <thead class="border-b">
            <tr>
                <th class="text-left px-4 py-2 text-sm font-semibold text-gray-900">Order ID</th>
                <th class="text-left px-4 py-2 text-sm font-semibold text-gray-900">Customer</th>
                <th class="text-left px-4 py-2 text-sm font-semibold text-gray-900">Amount</th>
                <th class="text-left px-4 py-2 text-sm font-semibold text-gray-900">Status</th>
                <th class="text-left px-4 py-2 text-sm font-semibold text-gray-900">Date</th>
            </tr>
        </thead>
        <tbody id="recent-orders">
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">Loading...</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    // Fetch dashboard data
    async function loadDashboard() {
        try {
            const response = await fetch('/api/v1/admin/dashboard');
            const data = await response.json();

            if (data.success) {
                const dashboard = data.data;

                // Update metrics
                document.getElementById('total-users').textContent = dashboard.total_users || 0;
                document.getElementById('total-orders').textContent = dashboard.total_orders || 0;
                document.getElementById('total-revenue').textContent = Math.round(dashboard.total_revenue || 0);
                document.getElementById('total-products').textContent = dashboard.total_products || 0;

                // Update charts
                if (dashboard.revenue_trend) {
                    createRevenueChart(dashboard.revenue_trend);
                }
                if (dashboard.orders_trend) {
                    createOrdersChart(dashboard.orders_trend);
                }
                if (dashboard.recent_orders) {
                    loadRecentOrders(dashboard.recent_orders);
                }
            }
        } catch (e) {
            console.error('Error:', e);
        }
    }

    function createRevenueChart(data) {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels || [],
                datasets: [{
                    label: 'Revenue',
                    data: data.values || [],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function createOrdersChart(data) {
        const ctx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels || [],
                datasets: [{
                    label: 'Orders',
                    data: data.values || [],
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function loadRecentOrders(orders) {
        const html = orders.length === 0 ?
            '<tr><td colspan="5" class="text-center py-4 text-gray-500">No recent orders</td></tr>' :
            orders.map(order => `
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm text-gray-900 font-medium">#${order.id}</td>
                    <td class="px-4 py-2 text-sm text-gray-600">${order.user?.name || 'Unknown'}</td>
                    <td class="px-4 py-2 text-sm font-semibold text-gray-900">₹${Math.round(order.total)}</td>
                    <td class="px-4 py-2 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-semibold ${
                            order.status === 'completed' ? 'bg-green-100 text-green-800' :
                            order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                            'bg-gray-100 text-gray-800'
                        }">
                            ${order.status}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-600">${new Date(order.created_at).toLocaleDateString()}</td>
                </tr>
            `).join('');

        document.getElementById('recent-orders').innerHTML = html;
    }

    loadDashboard();
</script>
@endsection