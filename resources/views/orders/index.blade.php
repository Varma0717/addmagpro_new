@extends('app_layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 pt-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>

    @auth
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Order ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Amount</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Action</th>
                </tr>
            </thead>
            <tbody id="orders-list">
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Loading orders...</td>
                </tr>
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-600 mb-4">Please login to view your orders</p>
        <a href="/login" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Sign In
        </a>
    </div>
    @endauth
</div>

<script>
    const token = localStorage.getItem('auth_token');

    async function loadOrders() {
        try {
            const response = await fetch('/api/v1/orders', {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            const data = await response.json();

            if (data.success) {
                const orders = data.data || [];
                const html = orders.length === 0 ?
                    '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No orders found</td></tr>' :
                    orders.map(order => `
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#${order.id}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">${new Date(order.created_at).toLocaleDateString()}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">₹${order.total}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold ${
                                    order.status === 'delivered' ? 'bg-green-100 text-green-800' :
                                    order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                    'bg-gray-100 text-gray-800'
                                }">
                                    ${order.status}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="/orders/${order.id}" class="text-blue-600 hover:text-blue-700 font-semibold">View</a>
                            </td>
                        </tr>
                    `).join('');

                document.getElementById('orders-list').innerHTML = html;
            }
        } catch (e) {
            console.error('Error:', e);
        }
    }

    loadOrders();
</script>
@endsection