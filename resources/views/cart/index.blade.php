@extends('app_layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    @auth
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div id="cart-items" class="bg-white rounded-lg shadow-sm">
                <div class="p-6 space-y-4" id="items-list">
                    <p class="text-gray-500 text-center py-8">Loading cart...</p>
                </div>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>

                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>₹<span id="subtotal">0</span></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Discount</span>
                        <span>-₹<span id="discount">0</span></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax (18% GST)</span>
                        <span>₹<span id="tax">0</span></span>
                    </div>
                    <div class="border-t pt-3 flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span>₹<span id="total">0</span></span>
                    </div>
                </div>

                <button onclick="proceedToCheckout()" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold mb-3">
                    Proceed to Checkout
                </button>
                <a href="/products" class="block text-center text-blue-600 hover:text-blue-700 font-semibold">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-600 mb-4">Please login to view your cart</p>
        <a href="/login" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Sign In
        </a>
    </div>
    @endauth
</div>

<script>
    const token = localStorage.getItem('auth_token');

    async function loadCart() {
        try {
            const response = await fetch('/api/v1/cart', {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            const data = await response.json();

            if (data.success) {
                const items = data.data.items || [];
                const itemsHtml = items.length === 0 ?
                    '<div class="text-center text-gray-500 py-8">Your cart is empty</div>' :
                    items.map(item => `
                        <div class="flex gap-4 pb-4 border-b">
                            <img src="https://via.placeholder.com/80" alt="" class="w-20 h-20 object-cover rounded">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">${item.product?.name || 'Product'}</h3>
                                <p class="text-gray-600">₹${item.product?.final_price || 0}</p>
                                <div class="flex gap-2 mt-2">
                                    <button onclick="updateCart(${item.id}, ${item.quantity - 1})" class="px-2 py-1 border rounded">-</button>
                                    <span class="px-3 py-1">${item.quantity}</span>
                                    <button onclick="updateCart(${item.id}, ${item.quantity + 1})" class="px-2 py-1 border rounded">+</button>
                                    <button onclick="removeFromCart(${item.id})" class="ml-auto text-red-600">Remove</button>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">₹${(item.product?.final_price || 0) * item.quantity}</p>
                            </div>
                        </div>
                    `).join('');

                document.getElementById('items-list').innerHTML = itemsHtml;
                updateSummary(data.data);
            }
        } catch (e) {
            console.error('Error loading cart:', e);
        }
    }

    function updateSummary(cart) {
        const subtotal = cart.subtotal || 0;
        const discount = cart.discount || 0;
        const tax = Math.round((subtotal - discount) * 0.18);
        const total = subtotal - discount + tax;

        document.getElementById('subtotal').textContent = Math.round(subtotal);
        document.getElementById('discount').textContent = Math.round(discount);
        document.getElementById('tax').textContent = tax;
        document.getElementById('total').textContent = Math.round(total);
    }

    async function updateCart(itemId, quantity) {
        if (quantity <= 0) return removeFromCart(itemId);

        await fetch(`/api/v1/cart/items/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                quantity
            })
        });
        loadCart();
    }

    async function removeFromCart(itemId) {
        await fetch(`/api/v1/cart/items/${itemId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
        loadCart();
    }

    function proceedToCheckout() {
        window.location.href = '/checkout';
    }

    loadCart();
</script>
@endsection