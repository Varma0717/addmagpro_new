{{-- ============================================================
     Kartify Header — AddMagPro Service User Portal
     ============================================================ --}}

{{-- ---- CART OFFCANVAS ---- --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title fw-bold">
      <i class="iconsax me-2" data-icon-name="basket-2"></i>
      My Cart <span class="badge text-bg-warning ms-1">{{ $cart_count ?? 0 }}</span>
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    @if(isset($cart_header_items) && count($cart_header_items) > 0)
    <ul class="cart-list">
      @foreach($cart_header_items as $item)
      <li class="cart-item d-flex gap-3 mb-3 pb-3 border-bottom">
        <a href="{{ route('products_list') }}" class="cart-img">
          <img src="{{ asset($item->product_images) }}" class="img-fluid" style="width:70px;height:70px;object-fit:cover;border-radius:8px;" alt="{{ $item->product_name }}">
        </a>
        <div class="flex-grow-1">
          <h6 class="mb-1 fw-semibold" style="font-size:.85rem;">{{ $item->product_name }}</h6>
          <p class="mb-1 text-muted" style="font-size:.8rem;">Qty: {{ $item->quantity ?? 1 }}</p>
          <span class="fw-bold" style="color:var(--theme-color);">₹{{ number_format($item->unit_price, 2) }}</span>
        </div>
        <a href="{{ route('remove_item_cart', $item->product_id) }}" class="text-danger" style="font-size:1.1rem;" title="Remove">
          <i class="ri-delete-bin-line"></i>
        </a>
      </li>
      @endforeach
    </ul>
    <div class="cart-footer mt-3">
      <div class="d-flex justify-content-between fw-bold mb-3">
        <span>Total</span>
        <span style="color:var(--theme-color);">₹{{ number_format($cart_header_items->sum(fn($i) => ($i->unit_price ?? 0) * ($i->quantity ?? 1)), 2) }}</span>
      </div>
      <a href="{{ route('billing_details_form') }}" class="btn w-100 text-white fw-bold" style="background:var(--theme-color);">Proceed to Checkout</a>
    </div>
    @else
    <div class="text-center py-5">
      <i class="iconsax mb-3" data-icon-name="basket-2" style="font-size:3rem;opacity:.3;"></i>
      <p class="text-muted">Your cart is empty</p>
      <a href="{{ route('products_list') }}" class="btn" style="background:var(--theme-color);color:#fff;">Shop Now</a>
    </div>
    @endif
  </div>
</div>

{{-- ---- WISHLIST OFFCANVAS ---- --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="wishlistOffcanvas">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title fw-bold">
      <i class="iconsax me-2" data-icon-name="heart"></i>
      Wishlist
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    @if(isset($wishlist_count) && $wishlist_count > 0)
    <p class="text-muted text-center">{{ $wishlist_count }} item(s) saved.</p>
    <a href="{{ route('wishlist') }}" class="btn w-100" style="background:var(--theme-color);color:#fff;">View Wishlist</a>
    @else
    <div class="text-center py-5">
      <i class="iconsax mb-3" data-icon-name="heart" style="font-size:3rem;opacity:.3;"></i>
      <p class="text-muted">Your wishlist is empty</p>
      <a href="{{ route('products_list') }}" class="btn" style="background:var(--theme-color);color:#fff;">Discover Products</a>
    </div>
    @endif
  </div>
</div>

{{-- ---- MAIN HEADER ---- --}}
<header class="header-style-1">

  {{-- Top Bar --}}
  <div class="top-header custom-container">
    <div class="left-header">
      <div class="social-box">
        <ul class="social-list">
          <li><a href="https://www.facebook.com/" target="_blank"><i class="ri-facebook-fill"></i></a></li>
          <li><a href="https://twitter.com/" target="_blank"><i class="ri-twitter-x-line"></i></a></li>
          <li><a href="https://www.instagram.com/" target="_blank"><i class="ri-instagram-line"></i></a></li>
        </ul>
      </div>
    </div>

    <div class="middle-header">
      <div class="middle-content">
        <p><span>JOIN ADDMAGPRO — EARN WHILE YOU SHOP &amp; SHARE</span></p>
      </div>
    </div>

    <div class="right-header">
      <ul class="content-list">
        @if(session('service_user_id'))
        <li><a href="{{ route('user_dashboard') }}">My Account</a></li>
        <li><a href="{{ route('service_user_logout') }}">Logout</a></li>
        @else
        <li><a href="{{ route('service_user_login') }}" class="login-btn">Log In</a></li>
        <li><a href="{{ route('service_user_registration') }}">Register</a></li>
        @endif
        <li><a href="{{ route('contact_us') }}">Contact Us</a></li>
        <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
      </ul>
    </div>
  </div>

  {{-- Main Header (Logo + Search + Icons) --}}
  <div class="main-header custom-container">
    <div class="left-header">
      <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
        <span class="navbar-toggler-icon"><i class="ri-menu-line"></i></span>
      </button>
      <a href="{{ route('welcome_page') }}" class="header-logo">
        <img src="{{ asset('assets/user_assets/images/logo.png') }}" class="img-fluid" style="max-height:48px;" alt="AddMagPro">
      </a>
    </div>

    <div class="middle-header searchInput" id="searchOffcanvas">
      <div class="search-overlay" id="searchOverlay"></div>
      <form class="search-form" action="{{ route('user_search_products') }}" method="GET">
        <div class="input-group">
          <div class="close-icon"><i class="ri-close-fill" id="close-btn"></i></div>
          <input id="searchInputBox" type="search" name="query" class="form-control" placeholder="Search products, services, stores...">
          <button class="search-button btn" type="submit">
            <i class="ri-search-line"></i>
          </button>
        </div>
      </form>
    </div>

    <div class="right-header">
      <ul class="header-icon">
        <li>
          <a href="#!" id="searchClick">
            <i class="iconsax search-btn" data-icon-name="search-normal-2"></i>
          </a>
        </li>
        {{-- User Dropdown --}}
        <li class="dropdown-box">
          <a href="#!">
            <i class="iconsax" data-icon-name="user-2"></i>
          </a>
          <ul class="dropdown-list user-dropdown">
            @if(session('service_user_id'))
            @isset($service_users_detail_info)
            <li class="user-box">
              <i class="iconsax" data-icon-name="user-2"></i>
              <div>
                <h6>{{ $service_users_detail_info->member_name ?? 'User' }}</h6>
                <p>{{ $service_users_detail_info->member_phone ?? '' }}</p>
              </div>
            </li>
            @endisset
            <li><a href="{{ route('user_dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('account_profile') }}">Profile</a></li>
            <li><a href="{{ route('account_orders') }}">My Orders</a></li>
            <li><a href="{{ route('user_wallet') }}">Wallet</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a href="{{ route('service_user_logout') }}" class="text-danger">Logout</a></li>
            @else
            <li>
              <a href="{{ route('service_user_login') }}" class="btn login-btn">Log In</a>
            </li>
            <li>
              <span>New here?</span>
              <a href="{{ route('service_user_registration') }}" class="btn signup-btn">Sign Up</a>
            </li>
            @endif
          </ul>
        </li>
        {{-- Wishlist --}}
        <li>
          <a data-bs-toggle="offcanvas" href="#wishlistOffcanvas">
            <i class="iconsax" data-icon-name="heart"></i>
            @if(isset($wishlist_count) && $wishlist_count > 0)
            <span class="label"><span>{{ $wishlist_count }}</span></span>
            @endif
          </a>
        </li>
        {{-- Cart --}}
        <li>
          <a data-bs-toggle="offcanvas" href="#cartOffcanvas">
            <i class="iconsax" data-icon-name="basket-2"></i>
            <span class="label"><span>{{ $cart_count ?? 0 }}</span></span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  {{-- Navigation Bar --}}
  <div class="nav-header custom-container d-flex">
    <div class="header-nav-middle w-100">
      <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
        <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
          <div class="offcanvas-header navbar-shadow">
            <h5>Menu</h5>
            <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas">
              <i class="ri-close-fill"></i>
            </button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('welcome_page') }}">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#!" data-bs-auto-close="outside" data-bs-toggle="dropdown">Products</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('products_list') }}">All Products</a></li>
                  <li><a class="dropdown-item" href="{{ route('latest_products_view') }}">Latest Products</a></li>
                  <li><a class="dropdown-item" href="{{ route('popular_discounts_products') }}">Popular Discounts</a></li>
                  <li><a class="dropdown-item" href="{{ route('vendors_full_view') }}">Vendors</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('services_list') }}">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('user_stores_list') }}">Stores</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('classifieds_list') }}">Classifieds</a>
              </li>
              @if(session('service_user_id'))
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#!" data-bs-auto-close="outside" data-bs-toggle="dropdown">My Account</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('user_dashboard') }}">Dashboard</a></li>
                  <li><a class="dropdown-item" href="{{ route('team_details') }}">Refer &amp; Earn</a></li>
                  <li><a class="dropdown-item" href="{{ route('user_wallet') }}">Wallet</a></li>
                  <li><a class="dropdown-item" href="{{ route('my_commission') }}">Commission</a></li>
                  <li><a class="dropdown-item" href="{{ route('generate_coupon') }}">Coupons</a></li>
                  <li><a class="dropdown-item" href="{{ route('id_activation') }}">KYC / ID Activation</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="{{ route('service_user_logout') }}">Logout</a></li>
                </ul>
              </li>
              @else
              <li class="nav-item">
                <a class="nav-link" href="{{ route('service_user_login') }}">Log In / Register</a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link" href="{{ route('contact_us') }}">Contact</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

</header>