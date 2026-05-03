<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/user_assets/images/favicon-32x32.webp') }}" type="image/webp" />

    <!-- CSS files -->
    <link href="{{ asset('assets/user_assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Plugins -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/user_assets/plugins/slick/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/user_assets/plugins/slick/slick-theme.css') }}" />

    <link href="{{ asset('assets/user_assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/user_assets/css/dark-theme.css') }}" rel="stylesheet">

    <title>Add Mag Pro |</title>
    <style>
        .quantity-controls {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            background-color: #ddd;
            border: 1px solid #ccc;
            padding: 10px;
            cursor: pointer;
        }

        .quantity-btn:hover {
            background-color: #ccc;
        }

        .quantity-input {
            width: 40px;
            text-align: center;
            border: 1px solid #ccc;
            margin: 0 10px;
        }
    </style>
</head>

<body>

    <!--page loader-->
    <!-- <div class="loader-wrapper">
        <div class="d-flex justify-content-center align-items-center position-absolute top-50 start-50 translate-middle">
            <div class="spinner-border text-dark" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div> -->
    <!--end loader-->

    <!--start top header-->
    <header class="top-header">
        <nav class="navbar navbar-expand-xl w-100 navbar-dark container gap-3">
            <a class="navbar-brand d-none d-xl-inline" href="index.html"><img src="{{ asset('assets/user_assets/images/logo.png') }}" class="logo-img" alt=""></a>
            <a class="mobile-menu-btn d-inline d-xl-none" href="javascript:;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <i class="bi bi-list"></i>
            </a>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header">
                    <div class="offcanvas-logo"><img src="{{ asset('assets/user_assets/images/logo.png') }}" class="logo-img" alt="">
                    </div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body primary-menu">
                    <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('welcome_page') }}">Home</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                                Memberships
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('services_list') }}">Services</a></li>
                                <li><a class="dropdown-item" href="{{ route('user_stores_list') }}">Stores</a></li>
                                <li><a class="dropdown-item" href="product-details.html">Products</a></li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('welcome_page') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('welcome_page') }}">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="navbar-nav secondary-menu flex-row  d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link dark-mode-icon" href="javascript:;">
                        <div class="mode-icon">
                            <i class="bi bi-moon"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('wishlist') }}"><i class="bi bi-suit-heart"></i></a>
                </li>
                <li class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
                    <a class="nav-link position-relative" href="javascript:;">
                        <div class="cart-badge">{{ $cart_count }}</div>
                        <i class="bi bi-basket2"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user_dashboard') }}"><img src="{{ asset('assets/user_assets/images/avatars/01.webp') }}" alt="" style="max-width: 50px; border-radius: 100%; align-self: center;" class="profile-img"></a>
                </li>
            </ul>
        </nav>
    </header>
    <!--end top header-->

    <!--start page content-->
    <div class="page-content">

        <!--start breadcrumb-->
        <div class="py-4 border-bottom">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Categories</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <!--start product grid-->
        <section class="py-4">
            <h5 class="mb-0 fw-bold d-none">Product Grid</h5>
            <div class="container-fluid">
                <div class="btn btn-dark btn-ecomm d-xl-none position-fixed top-50 start-0 translate-middle-y" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarFilter"><span><i class="bi bi-funnel me-1"></i> Filters</span></div>
                <div class="row">

                    <div class="col-12 col-xl-12">
                        <div class="shop-center-sidebar">

                            <div class="product-grid mt-4">
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
                                    @foreach($products_based_on_category as $product)
                                    <div class="col">
                                        <div class="card border shadow-none">
                                            <div class="position-relative overflow-hidden">
                                                <div class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                                                </div>
                                                <a href="">
                                                    <img src="{{ asset($product->product_images) }}" class="card-img-top professional-img" alt="Image Not Found">
                                                </a>
                                            </div>
                                            <div class="card-body border-top">
                                                <h5 class="mb-0 fw-bold product-short-title">{{ $product->product_name }}</h5>
                                                <p class="mb-0 product-short-name">{{ $product->product_description }}</p>
                                                <div class="product-price d-flex align-items-center gap-2 mt-2">
                                                    <div class="h6 fw-bold">{{ $product->purchase_price }}</div>
                                                    <div class="h6  fw-light text-muted text-decoration-line-through">{{ $product->unit_price }}</div>
                                                    <div class="mt-2 ">
                                                        <a href="{{ route('add_to_cart', ['product_id' => $product->product_id, 'quantity' => 1]) }}" class="btn btn-primary" id="add-to-cart-{{ $product->product_id }}">Add to Cart</a>
                                                    </div>
                                                    <div class="quantity-controls ">
                                                        <button class="quantity-btn" onclick="decreaseQuantity('quantity-{{ $product->product_id }}', '{{ $product->product_id }}')">-</button>
                                                        <input type="text" id="quantity-{{ $product->product_id }}" class="quantity-input" value="1" readonly>
                                                        <button class="quantity-btn" onclick="increaseQuantity('quantity-{{ $product->product_id }}', '{{ $product->product_id }}')">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </section>
        <!--start product details-->
    </div>
    <!--end page content-->

      <!--start cart-->
  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasRight"
    aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-section-2">
      <h5 class="mb-0 fw-bold" id="offcanvasRightLabel">{{$cart_count}} items in the cart</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="cart-list">
      @foreach($cart_products as $cart_product)
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset($cart_product->product_images)}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">{{$cart_product->product_name}}</h6>
            <p>{{$cart_product->product_description}}</p>
            <p class="mb-0"><strong>{{$cart_product->quantity}} X {{$cart_product->quantity*$cart_product->purchase_price}}</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="{{route('remove_item_cart',['product_id'=>$cart_product->product_id])}}" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        @endforeach
        
      
      </div>
    </div>
    <div class="offcanvas-footer p-3 border-top">
      <div class="d-grid">
        <a href="{{route('billing_details_form')}}" type="button" class="btn btn-lg btn-dark btn-ecomm px-5 py-3">Checkout</a>
      </div>
    </div>

  </div>
  <!--end cat-->

    <!--start footer-->
    <!--<section class="footer-section bg-section-2 section-padding">-->
    <!--    <div class="container-fluid">-->
    <!--        <div class="row">-->
    <!--            <div class="col col-lg-2 col-md-4 col-6">-->
    <!--                <div class="footer-item mt-3">-->
    <!--                    <h5 class="footer-item-title">Company</h5>-->
    <!--                    <ul class="footer-item-links">-->
    <!--                        <li><a href="about.html">About</a></li>-->
    <!--                        <li><a href="index.html#">Careers</a></li>-->
    <!--                        <li><a href="index.html#">Partners</a></li>-->
    <!--                        <li><a href="index.html#">Contact</a></li>-->
    <!--                    </ul>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col col-lg-2 col-md-4 col-6">-->
    <!--                <div class="footer-item mt-3">-->
    <!--                    <h5 class="footer-item-title">Learn More</h5>-->
    <!--                    <ul class="footer-item-links">-->
    <!--                        <li><a href="index.html#">How it Works</a></li>-->
    <!--                        <li><a href="index.html#">Privacy Policy</a></li>-->
    <!--                        <li><a href="index.html#">Terms of Service</a></li>-->
    <!--                        <li><a href="index.html#">FAQ</a></li>-->
    <!--                    </ul>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col col-lg-2 col-md-4 col-6">-->
    <!--                <div class="footer-item mt-3">-->
    <!--                    <h5 class="footer-item-title">Support</h5>-->
    <!--                    <ul class="footer-item-links">-->
    <!--                        <li><a href="index.html#">Contact Us</a></li>-->
    <!--                        <li><a href="index.html#">Help Center</a></li>-->
    <!--                        <li><a href="index.html#">Support</a></li>-->
    <!--                        <li><a href="index.html#">Career</a></li>-->
    <!--                    </ul>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col col-lg-2 col-md-4 col-6">-->
    <!--                <div class="footer-item mt-3">-->
    <!--                    <h5 class="footer-item-title">Follow Us</h5>-->
    <!--                    <ul class="footer-item-links">-->
    <!--                        <li><a href="index.html#"><i class="bi bi-facebook"></i> Facebook</a></li>-->
    <!--                        <li><a href="index.html#"><i class="bi bi-twitter"></i> Twitter</a></li>-->
    <!--                        <li><a href="index.html#"><i class="bi bi-linkedin"></i> LinkedIn</a></li>-->
    <!--                        <li><a href="index.html#"><i class="bi bi-instagram"></i> Instagram</a></li>-->
    <!--                    </ul>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col col-lg-2 col-md-4 col-6">-->
    <!--                <div class="footer-item mt-3">-->
    <!--                    <h5 class="footer-item-title">Our App</h5>-->
    <!--                    <ul class="footer-item-links">-->
    <!--                        <li><a href="index.html#"><i class="bi bi-apple"></i> iOS App</a></li>-->
    <!--                        <li><a href="index.html#"><i class="bi bi-android"></i> Android App</a></li>-->
    <!--                        <li><a href="index.html#"><i class="bi bi-windows"></i> Windows App</a></li>-->
    <!--                        <li><a href="index.html#"><i class="bi bi-mac"></i> macOS App</a></li>-->
    <!--                    </ul>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col col-lg-2 col-md-4 col-6">-->
    <!--                <div class="footer-item mt-3">-->
    <!--                    <h5 class="footer-item-title">Community</h5>-->
    <!--                    <ul class="footer-item-links">-->
    <!--                        <li><a href="index.html#">Developers</a></li>-->
    <!--                        <li><a href="index.html#">Influencers</a></li>-->
    <!--                        <li><a href="index.html#">Forum</a></li>-->
    <!--                        <li><a href="index.html#">Invite Friends</a></li>-->
    <!--                    </ul>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
    <!--end footer-->

    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('assets/user_assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        function increaseQuantity(quantityId, productId) {
            var input = document.getElementById(quantityId);
            var currentValue = parseInt(input.value);
            input.value = currentValue + 1;
            updateCartLink(productId, currentValue + 1);
        }

        function decreaseQuantity(quantityId, productId) {
            var input = document.getElementById(quantityId);
            var currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateCartLink(productId, currentValue - 1);
            }
        }

        function updateCartLink(productId, quantity) {
            var cartLink = document.getElementById('add-to-cart-' + productId);
            var url = "{{ route('add_to_cart', ['product_id' => ':productId', 'quantity' => ':quantity']) }}"
                        .replace(':productId', productId)
                        .replace(':quantity', quantity);
            cartLink.href = url;
        }
    </script>
</body>

</html>
