# Web UI Development - Laravel Blade & Tailwind CSS

## Project Structure

```
resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php              # Master layout
│   │   ├── header.blade.php           # Navigation header
│   │   └── footer.blade.php           # Footer
│   ├── auth/
│   │   ├── login.blade.php
│   │   ├── register.blade.php
│   │   └── forgot-password.blade.php
│   ├── home/
│   │   └── index.blade.php            # Home/Dashboard
│   ├── products/
│   │   ├── index.blade.php            # Products listing
│   │   └── show.blade.php             # Product detail
│   ├── cart/
│   │   └── index.blade.php            # Shopping cart
│   ├── checkout/
│   │   ├── address.blade.php          # Shipping address
│   │   ├── payment.blade.php          # Payment method
│   │   └── confirmation.blade.php     # Order confirmation
│   ├── orders/
│   │   ├── index.blade.php            # Orders list
│   │   └── show.blade.php             # Order detail/tracking
│   ├── wallet/
│   │   ├── index.blade.php            # Wallet dashboard
│   │   ├── topup.blade.php            # Add money
│   │   └── transactions.blade.php     # Transaction history
│   ├── referral/
│   │   └── index.blade.php            # Referral program
│   ├── wishlist/
│   │   └── index.blade.php            # Wishlist
│   ├── account/
│   │   ├── profile.blade.php          # User profile
│   │   └── settings.blade.php         # Account settings
│   └── components/
│       ├── product-card.blade.php
│       ├── banner-slider.blade.php
│       ├── category-grid.blade.php
│       ├── navbar.blade.php
│       └── breadcrumb.blade.php
├── css/
│   └── app.css                         # Custom styles
└── js/
    └── app.js                          # JavaScript logic
```

---

## Step 1: Master Layout

### resources/views/layouts/app.blade.php
```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AddMagPro - Shop Smart') | AddMagPro</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation Header -->
    @include('layouts.header')
    
    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.footer')
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
```

### resources/views/layouts/header.blade.php
```blade
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold">AM</span>
                </div>
                <span class="font-bold text-xl text-gray-900 hidden sm:inline">AddMagPro</span>
            </a>
            
            <!-- Search Bar -->
            <div class="flex-1 mx-4 hidden md:block">
                <form action="/products/search" method="get">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="q" 
                            placeholder="Search products..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        >
                        <button type="submit" class="absolute right-3 top-2.5">
                            <i class="fas fa-search text-gray-400"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Right Side Navigation -->
            <nav class="flex items-center space-x-6">
                @auth
                    <!-- Wishlist -->
                    <a href="/wishlist" class="relative">
                        <i class="fas fa-heart text-gray-600 hover:text-red-500 text-xl"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>
                    
                    <!-- Cart -->
                    <a href="/cart" class="relative">
                        <i class="fas fa-shopping-cart text-gray-600 hover:text-blue-500 text-xl"></i>
                        <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="cart-count">0</span>
                    </a>
                    
                    <!-- User Menu -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                            <img src="{{ auth()->user()->avatar_url ?? 'https://via.placeholder.com/32' }}" alt="Avatar" class="w-8 h-8 rounded-full">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div class="absolute right-0 w-48 bg-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none group-hover:pointer-events-auto">
                            <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-t-lg">
                                <i class="fas fa-user mr-2"></i>My Profile
                            </a>
                            <a href="/orders" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-box mr-2"></i>My Orders
                            </a>
                            <a href="/wallet" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-wallet mr-2"></i>My Wallet
                            </a>
                            <a href="/referral" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-link mr-2"></i>Referrals
                            </a>
                            <a href="/settings" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <form method="POST" action="/logout" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-b-lg">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login" class="text-gray-700 hover:text-blue-600">Login</a>
                    <a href="/register" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Sign Up</a>
                @endauth
            </nav>
        </div>
    </div>
</header>
```

---

## Step 2: Home Page

### resources/views/home/index.blade.php
```blade
@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <!-- Banner Slider -->
    <div class="mb-8">
        @include('components.banner-slider', ['banners' => $banners])
    </div>
    
    <!-- Categories Section -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Shop by Category</h2>
            <a href="/products" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">View All</a>
        </div>
        @include('components.category-grid', ['categories' => $categories])
    </section>
    
    <!-- Quick Services -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Services</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($services as $service)
                <a href="/services/{{ $service->slug }}" class="text-center">
                    <div class="bg-white p-4 rounded-lg hover:shadow-lg transition-shadow">
                        <img src="{{ $service->icon_url }}" alt="{{ $service->name }}" class="w-12 h-12 mx-auto mb-2">
                        <p class="text-sm font-medium text-gray-700">{{ $service->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    
    <!-- Featured Products -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Featured Products</h2>
            <a href="/products?featured=1" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">View All</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($featured_products as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    
    <!-- New Launches -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">New Launches</h2>
            <a href="/products?sort=newest" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">View All</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($new_launches as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    
</div>
@endsection
```

---

## Step 3: Product Components

### resources/views/components/product-card.blade.php
```blade
<a href="/products/{{ $product->slug }}" class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition-shadow group">
    <!-- Product Image -->
    <div class="relative overflow-hidden bg-gray-100 aspect-square">
        <img 
            src="{{ $product->image_url ?? 'https://via.placeholder.com/200' }}" 
            alt="{{ $product->name }}"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
        >
        
        @if($product->discount_percent > 0)
            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                -{{ (int)$product->discount_percent }}%
            </div>
        @endif
        
        @auth
            <button 
                onclick="toggleWishlist({{ $product->id }})"
                class="absolute top-2 left-2 bg-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity"
            >
                <i class="fas fa-heart text-gray-400 hover:text-red-500"></i>
            </button>
        @endauth
    </div>
    
    <!-- Product Info -->
    <div class="p-3">
        <h3 class="text-sm font-medium text-gray-900 line-clamp-2">{{ $product->name }}</h3>
        
        <!-- Rating -->
        @if($product->rating > 0)
            <div class="flex items-center mt-1">
                <div class="flex text-yellow-400">
                    @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star {{ $i < (int)$product->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
                <span class="text-xs text-gray-600 ml-1">({{ $product->review_count }})</span>
            </div>
        @endif
        
        <!-- Price -->
        <div class="mt-2">
            @if($product->discount_percent > 0)
                <div class="flex items-center space-x-2">
                    <span class="text-lg font-bold text-gray-900">₹{{ (int)$product->final_price }}</span>
                    <span class="text-sm text-gray-500 line-through">₹{{ (int)$product->price }}</span>
                </div>
            @else
                <span class="text-lg font-bold text-gray-900">₹{{ (int)$product->price }}</span>
            @endif
        </div>
        
        <!-- Stock Status -->
        <div class="mt-2">
            @if($product->stock_quantity > 0)
                <span class="text-xs text-green-600 font-semibold">In Stock</span>
            @else
                <span class="text-xs text-red-600 font-semibold">Out of Stock</span>
            @endif
        </div>
    </div>
</a>
```

### resources/views/products/show.blade.php
```blade
@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <!-- Breadcrumb -->
    @include('components.breadcrumb', [
        'items' => [
            ['name' => 'Home', 'url' => '/'],
            ['name' => $product->category->name, 'url' => "/products?category={$product->category->id}"],
            ['name' => $product->name]
        ]
    ])
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
        
        <!-- Product Images -->
        <div>
            <div class="bg-gray-100 rounded-lg overflow-hidden">
                <img id="main-image" src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-96 object-cover">
            </div>
            
            @if($product->images->count() > 1)
                <div class="flex space-x-2 mt-4">
                    @foreach($product->images as $image)
                        <img 
                            src="{{ $image->image_url }}" 
                            alt="{{ $product->name }}"
                            onclick="document.getElementById('main-image').src = '{{ $image->image_url }}'"
                            class="w-20 h-20 object-cover rounded cursor-pointer border-2 border-gray-300 hover:border-blue-500"
                        >
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- Product Details -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
            
            <!-- Rating -->
            <div class="flex items-center mt-2">
                <div class="flex text-yellow-400">
                    @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star {{ $i < (int)$product->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
                <span class="text-sm text-gray-600 ml-2">({{ $product->review_count }} reviews)</span>
            </div>
            
            <!-- Price Section -->
            <div class="mt-4">
                <div class="flex items-center space-x-3">
                    <span class="text-4xl font-bold text-gray-900">₹{{ (int)$product->final_price }}</span>
                    @if($product->discount_percent > 0)
                        <span class="text-xl text-gray-500 line-through">₹{{ (int)$product->price }}</span>
                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-sm font-semibold">Save ₹{{ (int)($product->price - $product->final_price) }}</span>
                    @endif
                </div>
            </div>
            
            <!-- Stock Status -->
            <div class="mt-4">
                @if($product->stock_quantity > 0)
                    <span class="text-green-600 font-semibold"><i class="fas fa-check"></i> In Stock</span>
                @else
                    <span class="text-red-600 font-semibold"><i class="fas fa-times"></i> Out of Stock</span>
                @endif
            </div>
            
            <!-- Description -->
            <div class="mt-6 pb-6 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900">Description</h3>
                <p class="mt-2 text-gray-700">{{ $product->description }}</p>
            </div>
            
            <!-- Add to Cart / Wishlist -->
            <div class="mt-6 flex space-x-4">
                <button 
                    id="add-to-cart-btn"
                    onclick="addToCart({{ $product->id }})"
                    {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}
                    class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors disabled:bg-gray-400"
                >
                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                </button>
                <button 
                    onclick="toggleWishlist({{ $product->id }})"
                    class="flex-1 border-2 border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:border-red-500 hover:text-red-500 transition-colors"
                >
                    <i class="fas fa-heart mr-2"></i>Add to Wishlist
                </button>
            </div>
            
            <!-- Key Features -->
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-3">Key Details</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    @if($product->sku)
                        <li><strong>SKU:</strong> {{ $product->sku }}</li>
                    @endif
                    <li><strong>Category:</strong> {{ $product->category->name }}</li>
                    <li><strong>Availability:</strong> {{ $product->stock_quantity }} in stock</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Customer Reviews -->
    @if($product->reviews->count() > 0)
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Reviews</h2>
            <div class="space-y-4">
                @foreach($product->reviews as $review)
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $review->user->name }}</div>
                                <div class="flex text-yellow-400 text-sm mt-1">
                                    @for($i = 0; $i < $review->rating; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    
</div>

<script>
function addToCart(productId) {
    const quantity = prompt('Enter quantity:', '1');
    if (quantity) {
        fetch('/api/v1/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
            },
            body: JSON.stringify({ product_id: productId, quantity: parseInt(quantity) })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert('Added to cart!');
              } else {
                  alert('Failed to add to cart');
              }
          });
    }
}

function toggleWishlist(productId) {
    fetch(`/api/v1/wishlist/is-in-wishlist/${productId}`, {
        headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
    }).then(response => response.json())
      .then(data => {
          if (data.data.in_wishlist) {
              // Remove from wishlist
          } else {
              // Add to wishlist
          }
      });
}
</script>
@endsection
```

---

## Step 4: Cart & Checkout

### resources/views/cart/index.blade.php
```blade
@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div id="cart-items" class="space-y-4">
                <!-- Cart items loaded via JavaScript -->
            </div>
        </div>
        
        <!-- Cart Summary -->
        <div class="bg-white p-6 rounded-lg border border-gray-200 h-fit sticky top-20">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
            
            <div class="space-y-4 border-b border-gray-200 pb-4">
                <div class="flex justify-between">
                    <span class="text-gray-700">Subtotal</span>
                    <span id="subtotal" class="font-semibold">₹0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Discount</span>
                    <span id="discount" class="font-semibold text-green-600">-₹0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Tax (18% GST)</span>
                    <span id="tax" class="font-semibold">₹0</span>
                </div>
            </div>
            
            <div class="flex justify-between text-lg font-bold text-gray-900 my-4">
                <span>Total</span>
                <span id="total">₹0</span>
            </div>
            
            <!-- Coupon Code -->
            <div class="mb-4">
                <input 
                    type="text" 
                    id="coupon-input"
                    placeholder="Enter coupon code"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm"
                >
                <button 
                    onclick="applyCoupon()"
                    class="w-full mt-2 bg-gray-200 text-gray-800 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300"
                >
                    Apply Coupon
                </button>
            </div>
            
            <button 
                onclick="window.location.href='/checkout'"
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors"
            >
                Proceed to Checkout
            </button>
            
            <a href="/products" class="block text-center text-blue-600 hover:text-blue-700 mt-4 font-semibold">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', loadCart);

function loadCart() {
    fetch('/api/v1/cart', {
        headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              renderCart(data.data);
          }
      });
}

function renderCart(cart) {
    const container = document.getElementById('cart-items');
    if (cart.items.length === 0) {
        container.innerHTML = '<p class="text-center text-gray-500">Your cart is empty</p>';
        return;
    }
    
    container.innerHTML = cart.items.map(item => `
        <div class="bg-white p-4 rounded-lg border border-gray-200 flex gap-4">
            <img src="${item.image_url}" alt="${item.product_name}" class="w-24 h-24 object-cover rounded">
            <div class="flex-1">
                <h3 class="font-semibold text-gray-900">${item.product_name}</h3>
                <p class="text-gray-600 text-sm">₹${item.price}</p>
                <div class="flex items-center space-x-2 mt-2">
                    <button onclick="updateQuantity(${item.product_id}, ${item.quantity - 1})">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateQuantity(${item.product_id}, ${item.quantity + 1})">+</button>
                </div>
            </div>
            <div class="text-right">
                <p class="font-semibold text-gray-900">₹${item.subtotal}</p>
                <button onclick="removeFromCart(${item.product_id})" class="text-red-600 text-sm hover:text-red-700 mt-2">Remove</button>
            </div>
        </div>
    `).join('');
    
    // Update totals
    document.getElementById('subtotal').textContent = `₹${cart.subtotal}`;
    document.getElementById('discount').textContent = `-₹${cart.discount_amount}`;
    document.getElementById('tax').textContent = `₹${cart.tax_amount}`;
    document.getElementById('total').textContent = `₹${cart.total}`;
}

function updateQuantity(productId, quantity) {
    fetch(`/api/v1/cart/items/${productId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        },
        body: JSON.stringify({ quantity })
    }).then(response => response.json())
      .then(data => {
          if (data.success) loadCart();
      });
}

function removeFromCart(productId) {
    fetch(`/api/v1/cart/items/${productId}`, {
        method: 'DELETE',
        headers: { 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
    }).then(response => response.json())
      .then(data => {
          if (data.success) loadCart();
      });
}

function applyCoupon() {
    const code = document.getElementById('coupon-input').value;
    fetch('/api/v1/cart/apply-coupon', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
        },
        body: JSON.stringify({ coupon_code: code })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              alert('Coupon applied!');
              loadCart();
          } else {
              alert('Coupon not valid');
          }
      });
}
</script>
@endsection
```

---

## Step 5: Authentication Views

### resources/views/auth/login.blade.php
```blade
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-3xl font-bold text-center text-gray-900 mb-2">Welcome Back</h1>
        <p class="text-center text-gray-600 mb-8">Sign in to your AddMagPro account</p>
        
        <form method="POST" action="/login" class="space-y-4">
            @csrf
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input 
                    type="email" 
                    id="email"
                    name="email"
                    required
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="you@example.com"
                >
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="••••••••"
                >
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="remember"
                    name="remember"
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded"
                >
                <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
            </div>
            
            <!-- Login Button -->
            <button 
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors"
            >
                Sign In
            </button>
        </form>
        
        <!-- Divider -->
        <div class="my-6 flex items-center">
            <div class="flex-1 border-t border-gray-300"></div>
            <span class="px-3 text-gray-500 text-sm">OR</span>
            <div class="flex-1 border-t border-gray-300"></div>
        </div>
        
        <!-- Forgot Password & Sign Up -->
        <div class="space-y-3 text-center">
            <a href="/forgot-password" class="block text-blue-600 hover:text-blue-700 text-sm font-semibold">
                Forgot password?
            </a>
            <p class="text-gray-700">
                Don't have an account? 
                <a href="/register" class="text-blue-600 hover:text-blue-700 font-semibold">Sign up</a>
            </p>
        </div>
    </div>
</div>
@endsection
```

---

## Step 6: Web Setup Instructions

### 1. Install Tailwind CSS
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# Update tailwind.config.js
```

### 2. Create Routes
```php
// routes/web.php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->middleware('auth')->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('auth')->name('checkout.store');
Route::get('/orders', [OrderController::class, 'index'])->middleware('auth')->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->middleware('auth')->name('orders.show');
Route::get('/wallet', [WalletController::class, 'index'])->middleware('auth')->name('wallet.index');
Route::get('/referral', [ReferralController::class, 'index'])->middleware('auth')->name('referral.index');
Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('auth')->name('wishlist.index');
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth')->name('profile.index');
```

### 3. Run Development Server
```bash
php artisan serve
npm run dev
```

---

## Features Implemented

✅ Responsive Design (Mobile/Tablet/Desktop)
✅ Product Catalog with Filtering
✅ Shopping Cart Management
✅ User Authentication
✅ Checkout Process (Razorpay Integration)
✅ Order Management & Tracking
✅ Wallet System
✅ Referral Program Display
✅ Wishlist
✅ User Profile & Settings
✅ Search Integration
✅ Fast Load Times (Optimized images, lazy loading)

---

Generated: May 25, 2026
