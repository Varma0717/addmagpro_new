<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AddMagPro - Shop Smart') | AddMagPro</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50">
    <!-- Navigation Header -->
    @include('layouts.header')

    <!-- Main Content -->
    <main class="min-h-screen">
        <!-- Flash Messages -->
        @if($errors->any())
        <div class="max-w-7xl mx-auto px-4 py-4 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <strong>Errors:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 py-4 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 py-4 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Scripts -->
    <script>
        // Cart update function
        async function updateCartCount() {
            try {
                const response = await fetch('/api/v1/cart', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
                    }
                });
                const data = await response.json();
                if (data.success && data.data.items) {
                    document.getElementById('cart-count').textContent = data.data.items.length;
                }
            } catch (error) {
                console.error('Failed to update cart:', error);
            }
        }

        // Initialize cart count on page load
        if (localStorage.getItem('auth_token')) {
            updateCartCount();
        }

        // Wishlist toggle
        async function toggleWishlist(productId) {
            try {
                const response = await fetch(`/api/v1/wishlist/add`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });
                if (response.ok) {
                    alert('Added to wishlist!');
                }
            } catch (error) {
                console.error('Wishlist error:', error);
            }
        }
    </script>
</body>

</html>