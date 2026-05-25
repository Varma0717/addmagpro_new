<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | AddMagPro Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white">
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-xl font-bold">AddMagPro Admin</h1>
            </div>
            <nav class="p-6 space-y-2">
                <a href="/admin" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->is('admin') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-chart-line mr-2"></i>Dashboard
                </a>
                <a href="/admin/products" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->is('admin/products*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-box mr-2"></i>Products
                </a>
                <a href="/admin/orders" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->is('admin/orders*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-shopping-bag mr-2"></i>Orders
                </a>
                <a href="/admin/users" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->is('admin/users*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-users mr-2"></i>Users
                </a>
                <a href="/admin/categories" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->is('admin/categories*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-folder mr-2"></i>Categories
                </a>
                <a href="/admin/coupons" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->is('admin/coupons*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-tags mr-2"></i>Coupons
                </a>
                <a href="/admin/analytics" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->is('admin/analytics*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-chart-bar mr-2"></i>Analytics
                </a>
                <a href="/admin/settings" class="block px-4 py-2 rounded hover:bg-gray-800 {{ request()->is('admin/settings*') ? 'bg-blue-600' : '' }}">
                    <i class="fas fa-cog mr-2"></i>Settings
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-6 border-t border-gray-800">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-gray-800">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="px-8 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center gap-4">
                        <a href="/" target="_blank" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-external-link-alt"></i> View Site
                        </a>
                        <div class="text-gray-600">
                            <i class="fas fa-user-circle text-2xl"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-8">
                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>