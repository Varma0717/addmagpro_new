{{-- ============================================================
     Kartify Footer — AddMagPro Service User Portal
     ============================================================ --}}

<footer class="footer-section">
  <div class="custom-container">
    <div class="main-footer">
      {{-- Grid totals per breakpoint:
           xl: 3+2+2+2+3 = 12 ✓
           lg: 3+2+2+2+3 = 12 ✓
           md: 4+2+2+2+2 = 12 ✓
           sm: 12 then 6+6+6+6 wrap ✓ --}}
      <div class="row g-sm-4 g-3">

        {{-- Brand / Contact Column --}}
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
          <div class="footer-title-2">
            <h4>Contact Info</h4>
          </div>
          <ul class="footer-content-list">
            <li>
              <a href="tel:+919000000000" class="content-box">
                <div class="footer-content-icon">
                  <i class="ri-phone-line" style="font-size:18px;"></i>
                </div>
                <h4>+91 90000 00000</h4>
              </a>
            </li>
            <li>
              <a href="{{ route('contact_us') }}" class="content-box">
                <div class="footer-content-icon">
                  <i class="ri-map-pin-line" style="font-size:18px;"></i>
                </div>
                <h5>AddMagPro Network, India</h5>
              </a>
            </li>
            <li>
              <a href="mailto:support@addmagpro.com" class="content-box">
                <div class="footer-content-icon">
                  <i class="ri-mail-line" style="font-size:18px;"></i>
                </div>
                <h5>support@addmagpro.com</h5>
              </a>
            </li>
          </ul>
          <div class="social-icon-box">
            <h5 class="content-color">Stay Connected :</h5>
            <ul class="social-icon-list" style="display:flex;align-items:center;flex-wrap:wrap;gap:0;list-style:none;padding:0;margin:0;">
              <li><a href="https://www.facebook.com/" target="_blank"><i class="ri-facebook-fill"></i></a></li>
              <li><a href="https://twitter.com/" target="_blank"><i class="ri-twitter-x-line"></i></a></li>
              <li><a href="https://www.instagram.com/" target="_blank"><i class="ri-instagram-fill"></i></a></li>
              <li><a href="https://www.youtube.com/" target="_blank"><i class="ri-youtube-line"></i></a></li>
            </ul>
          </div>
        </div>

        {{-- Quick Links --}}
        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
          <div class="footer-title">
            <h4>Quick Links</h4>
          </div>
          <ul class="footer-list">
            <li><a href="{{ route('welcome_page') }}">Home</a></li>
            <li><a href="{{ route('products_list') }}">Products</a></li>
            <li><a href="{{ route('vendors_full_view') }}">Vendors</a></li>
            <li><a href="{{ route('popular_discounts_products') }}">Discount Shop</a></li>
            <li><a href="{{ route('latest_products_view') }}">New Arrivals</a></li>
          </ul>
        </div>

        {{-- Memberships --}}
        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
          <div class="footer-title">
            <h4>Memberships</h4>
          </div>
          <ul class="footer-list">
            <li><a href="{{ route('services_list') }}">Services</a></li>
            <li><a href="{{ route('user_stores_list') }}">Stores</a></li>
            <li><a href="{{ route('classifieds_list') }}">Classifieds</a></li>
            <li><a href="{{ route('add_your_shop') }}">Become a Vendor</a></li>
            @if(session('service_user_id'))
            <li><a href="{{ route('team_details') }}">Refer &amp; Earn</a></li>
            @endif
          </ul>
        </div>

        {{-- Policies --}}
        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
          <div class="footer-title">
            <h4>Policies</h4>
          </div>
          <ul class="footer-list">
            <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>
            <li><a href="{{ route('terms_and_conditions') }}">Terms &amp; Conditions</a></li>
            <li><a href="{{ route('refund_policy') }}">Refund Policy</a></li>
            <li><a href="{{ route('shipping_policy') }}">Shipping Policy</a></li>
            <li><a href="{{ route('contact_us') }}">Contact Us</a></li>
          </ul>
        </div>

        {{-- My Account --}}
        <div class="col-xl-3 col-lg-3 col-md-2 col-sm-6">
          <div class="footer-title-2">
            <h4>My Account</h4>
          </div>
          <ul class="footer-list-2">
            @if(session('service_user_id'))
            <li><a href="{{ route('user_dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('account_orders') }}">My Orders</a></li>
            <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
            <li><a href="{{ route('user_wallet') }}">Wallet</a></li>
            <li><a href="{{ route('my_commission') }}">Commission</a></li>
            @else
            <li><a href="{{ route('landingpage') }}">Log In</a></li>
            <li><a href="{{ route('service_user_registration') }}">Register</a></li>
            @endif
          </ul>
        </div>

      </div>
    </div>

    <div class="sub-footer">
      <a href="{{ route('welcome_page') }}" class="sub-footer-logo" style="display:block;">
        <img src="{{ asset('assets/user_assets/images/logo.png') }}" style="height:40px;width:auto;display:block;" alt="AddMagPro">
      </a>
      <ul class="payment-list">
        <li><img src="{{ asset('assets/kartify/images/inner-page/bank/1.png') }}" style="height:28px;width:auto;" alt="payment"></li>
        <li><img src="{{ asset('assets/kartify/images/inner-page/bank/2.png') }}" style="height:28px;width:auto;" alt="payment"></li>
        <li><img src="{{ asset('assets/kartify/images/inner-page/bank/3.png') }}" style="height:28px;width:auto;" alt="payment"></li>
      </ul>
    </div>
  </div>
</footer>

{{-- Scroll To Top Button --}}
<div class="tap-top-button">
  <button class="btn">
    <i class="iconsax" data-icon-name="arrow-up"></i>
  </button>
</div>

@yield('extra_js_inline')