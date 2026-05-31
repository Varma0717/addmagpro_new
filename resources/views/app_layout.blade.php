<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddMagPro - Shop Smart, Save More</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-50">
    <!-- Navigation Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">AM</span>
                    </div>
                    <span class="font-bold text-xl text-gray-900 hidden sm:inline">AddMagPro</span>
                </a>

                <!-- Search Bar (Desktop) -->
                <div class="flex-1 mx-4 hidden md:block">
                    <form action="/search" method="get" class="relative">
                        <input
                            type="text"
                            name="q"
                            placeholder="Search products..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm"
                            autocomplete="off">
                        <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Side Navigation -->
                <nav class="flex items-center space-x-4 md:space-x-6">
                    <div id="auth-section">
                        <!-- This will be populated by JavaScript based on auth state -->
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-white mb-4">About Us</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">About AddMagPro</a></li>
                        <li><a href="#" class="hover:text-white">Careers</a></li>
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-4">Support</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Help Center</a></li>
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">Track Order</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-4">Legal</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white">Terms & Conditions</a></li>
                        <li><a href="#" class="hover:text-white">Refund Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-white mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8">
                <div class="text-center text-sm text-gray-400">
                    <p>&copy; 2026 AddMagPro. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Initialize auth section
        function initAuthSection() {
            const authSection = document.getElementById('auth-section');
            const token = localStorage.getItem('auth_token');

            if (token) {
                // User is logged in
                authSection.innerHTML = `
                    <!-- Wishlist -->
                    <a href="/wishlist" class="relative group">
                        <i class="fas fa-heart text-gray-600 hover:text-red-500 text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="wishlist-count">0</span>
                    </a>

                    <!-- Cart -->
                    <a href="/cart" class="relative group">
                        <i class="fas fa-shopping-cart text-gray-600 hover:text-blue-500 text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="cart-count">0</span>
                    </a>

                    <!-- User Menu -->
                    <div class="relative group">
                        <button class="flex items-center space-x-1 text-gray-700 hover:text-blue-600">
                            <img src="https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff" alt="Avatar" class="w-8 h-8 rounded-full">
                            <i class="fas fa-chevron-down text-xs hidden md:inline"></i>
                        </button>

                        <div class="absolute right-0 w-48 bg-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none group-hover:pointer-events-auto mt-1">
                            <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                <i class="fas fa-user mr-2 w-4"></i>My Profile
                            </a>
                            <a href="/orders" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                <i class="fas fa-box mr-2 w-4"></i>My Orders
                            </a>
                            <a href="/wallet" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                <i class="fas fa-wallet mr-2 w-4"></i>My Wallet
                            </a>
                            <a href="/referral" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                <i class="fas fa-link mr-2 w-4"></i>Referrals
                            </a>
                            <button onclick="logout()" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                <i class="fas fa-sign-out-alt mr-2 w-4"></i>Logout
                            </button>
                        </div>
                    </div>
                `;
                updateCartCount();
                updateWishlistCount();
            } else {
                // User is not logged in
                authSection.innerHTML = `
                    <a href="/login" class="text-gray-700 hover:text-blue-600 font-medium text-sm">Login</a>
                    <a href="/register" class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">Sign Up</a>
                `;
            }
        }

        // Update cart count
        async function updateCartCount() {
            try {
                const token = localStorage.getItem('auth_token');
                if (!token) return;

                const response = await fetch('/api/v1/cart', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success && data.data && data.data.items) {
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.data.items.length;
                    }
                }
            } catch (e) {
                console.log('Error updating cart count:', e);
            }
        }

        // Update wishlist count
        async function updateWishlistCount() {
            try {
                const token = localStorage.getItem('auth_token');
                if (!token) return;

                const response = await fetch('/api/v1/wishlist/count', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    const wishlistCount = document.getElementById('wishlist-count');
                    if (wishlistCount) {
                        wishlistCount.textContent = data.data.count || 0;
                    }
                }
            } catch (e) {
                console.log('Error updating wishlist count:', e);
            }
        }

        // Logout handler
        async function logout() {
            try {
                const token = localStorage.getItem('auth_token');
                if (token) {
                    await fetch('/api/v1/auth/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    });
                }
            } catch (e) {
                console.log('Logout error:', e);
            } finally {
                localStorage.removeItem('auth_token');
                window.location.href = '/';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initAuthSection);
    </script>
</body>

</html>