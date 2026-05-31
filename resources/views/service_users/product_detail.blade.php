<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--favicon-->
  <link rel="icon" href="{{asset('assets/user_assets/images/favicon-32x32.webp')}}" type="image/webp" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

  <!-- CSS files -->
  <link href="{{asset('assets/user_assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <!-- Plugins -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/user_assets/plugins/slick/slick.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('assets/user_assets/plugins/slick/slick-theme.css')}}" />

  <link href="{{asset('assets/user_assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/user_assets/css/dark-theme.css')}}" rel="stylesheet">

  <title>AddMagPro | product-details</title>
</head>

<body>

  <!--start top header-->
  <header class="top-header">
    <nav class="navbar navbar-expand-xl w-100 navbar-dark container gap-3">
      <a class="navbar-brand d-none d-xl-inline" href="index.html"><img src="{{asset('assets/user_assets/images/logo.png')}}" class="logo-img" alt=""></a>
      <a class="mobile-menu-btn d-inline d-xl-none" href="javascript:;" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasNavbar">
        <i class="bi bi-list"></i>
      </a>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
        <div class="offcanvas-header">
          <div class="offcanvas-logo"><img src="{{asset('assets/user_assets/images/logo.png')}}" class="logo-img" alt="">
          </div>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body primary-menu">
          <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
            <li class="nav-item">
              <a class="nav-link" href="{{route('welcome_page')}}">Home</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                Memberships
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('services_list')}}">Services</a></li>
                <li><a class="dropdown-item" href="{{route('user_stores_list')}}">Stores</a></li>
                <li><a class="dropdown-item" href="product-details.html">Products</a></li>

              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('welcome_page')}}">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('welcome_page')}}">Contact</a>
            </li>
            <!-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                Account
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="account-dashboard.html">Dashboard</a></li>
                <li><a class="dropdown-item" href="account-orders.html">My Orders</a></li>
                <li><a class="dropdown-item" href="account-profile.html">My Profile</a></li>
                <li><a class="dropdown-item" href="account-edit-profile.html">Edit Profile</a></li>
                <li><a class="dropdown-item" href="account-saved-address.html">Addresses</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="authentication-login.html">Login</a></li>
                <li><a class="dropdown-item" href="authentication-register.html">Register</a></li>
                <li><a class="dropdown-item" href="authentication-reset-password.html">Password</a></li>
              </ul>
            </li> -->

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
        <!-- <li class="nav-item">
          <a class="nav-link" href="search.html"><i class="bi bi-search"></i></a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="{{route('wishlist')}}"><i class="bi bi-suit-heart"></i></a>
        </li>
        <li class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
          <a class="nav-link position-relative" href="javascript:;">
            <div class="cart-badge">{{$cart_count}}</div>
            <i class="bi bi-basket2"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('user_dashboard')}}"><img src="./assets/user_assets/images/avatars/01.webp" alt="" style="max-width: 50px; border-radius: 100%; align-self: center;" class="profile-img"></a>
        </li>
      </ul>
    </nav>
  </header>
  <!--end top header-->


  <!--start page content-->
  <div class="page-content">


    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
      <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{route('welcome_page')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Page Details</li>
          </ol>
        </nav>
      </div>
    </div>
    <!--end breadcrumb-->


    <!--start product details-->
    <section class="py-4">
      <div class="container">
        <div class="row g-4">
          <div class="col-12 col-xl-7">
            <div class="product-images">
              <div class="product-zoom-images">
                <div class="row row-cols-2 g-3">
                  <div class="col">
                    <div class="img-thumb-container overflow-hidden position-relative" data-fancybox="gallery" data-src="{{asset('assets/user_assets/images/product-images/01.jpg')}}">
                      <img src="{{asset($product_detail[0]->product_images)}}" class="img-fluid" alt="">
                    </div>
                  </div>
                  <div class="col">
                    <div class="img-thumb-container overflow-hidden position-relative" data-fancybox="gallery" data-src="{{asset('assets/user_assets/images/product-images/02.jpg')}}">
                      <img src="https://rukminim2.flixcart.com/image/416/416/xif0q/mobile/1/l/2/-original-imagzm8pyjbrzjxs.jpeg?q=70&crop=false" class="img-fluid" alt="">
                    </div>
                  </div>
                  <div class="col">
                    <div class="img-thumb-container overflow-hidden position-relative" data-fancybox="gallery" data-src="{{asset('assets/user_assets/images/product-images/03.jpg')}}">
                      <img src="https://rukminim2.flixcart.com/image/416/416/xif0q/mobile/g/m/t/-original-imagmg6gyhzhh3fb.jpeg?q=70&crop=false" class="img-fluid" alt="">
                    </div>
                  </div>
                  <div class="col">
                    <div class="img-thumb-container overflow-hidden position-relative" data-fancybox="gallery" data-src="{{asset('assets/user_assets/images/product-images/04.jpg')}}">
                      <img src="https://rukminim2.flixcart.com/image/416/416/xif0q/mobile/q/y/u/-original-imagmg6ggzazdevx.jpeg?q=70&crop=false" class="img-fluid" alt="">
                    </div>
                  </div>
                  <div class="col">
                    <div class="img-thumb-container overflow-hidden position-relative" data-fancybox="gallery" data-src="{{asset('assets/user_assets/images/product-images/05.jpg')}}">
                      <img src="https://rukminim2.flixcart.com/image/416/416/xif0q/mobile/p/4/u/-original-imagmg6gynphgrh8.jpeg?q=70&crop=false" class="img-fluid" alt="">
                    </div>
                  </div>
                  <div class="col">
                    <div class="img-thumb-container overflow-hidden position-relative" data-fancybox="gallery" data-src="{{asset('assets/user_assets/images/product-images/06.jpg')}}">
                      <img src="https://rukminim2.flixcart.com/image/416/416/xif0q/mobile/1/l/2/-original-imagzm8pyjbrzjxs.jpeg?q=70&crop=false" class="img-fluid" alt="">
                    </div>
                  </div>

                </div><!--end row-->
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-5">
            <div class="product-info">
              <h4 class="product-title fw-bold mb-1">Samsung S23 Ultra</h4>
              <p class="mb-0">Women Pink & Off-White Printed Kurta with Palazzos</p>
              <div class="product-rating">
                <div class="hstack gap-2 border p-1 mt-3 width-content">
                  <div><span class="rating-number">4.8</span><i class="bi bi-star-fill ms-1 text-warning"></i></div>
                  <div class="vr"></div>
                  <div>162 Ratings</div>
                </div>
              </div>
              <hr>
              <div class="product-price d-flex align-items-center gap-3">
                <div class="h4 fw-bold">1,20,000</div>
                <div class="h5 fw-light text-muted text-decoration-line-through">$2089</div>
                <div class="h4 fw-bold text-danger">(70% off)</div>
              </div>
              <p class="fw-bold mb-0 mt-1 text-success">inclusive of all taxes</p>

              <div class="more-colors mt-4">
                <h6 class="fw-bold mb-3">More Colors</h6>
                <div class="d-flex align-items-center gap-3">
                  <div class="">
                    <a href="javascript:;">
                      <img src="{{asset('assets/user_assets/images/featured-products/01.webp')}}" width="65" alt="">
                    </a>
                  </div>
                  <div class="">
                    <a href="javascript:;">
                      <img src="{{asset('assets/user_assets/images/featured-products/02.webp')}}" width="65" alt="">
                    </a>
                  </div>
                  <div class="">
                    <a href="javascript:;">
                      <img src="{{asset('assets/user_assets/images/featured-products/03.webp')}}" width="65" alt="">
                    </a>
                  </div>
                  <div class="">
                    <a href="javascript:;">
                      <img src="{{asset('assets/user_assets/images/featured-products/04.webp')}}" width="65" alt="">
                    </a>
                  </div>
                </div>
              </div>

              <div class="size-chart mt-4">
                <h6 class="fw-bold mb-3">Select Size</h6>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                  <div class="">
                    <button type="button">XS</button>
                  </div>
                  <div class="">
                    <button type="button">S</button>
                  </div>
                  <div class="">
                    <button type="button">M</button>
                  </div>
                  <div class="">
                    <button type="button">L</button>
                  </div>
                  <div class="">
                    <button type="button">XL</button>
                  </div>
                  <div class="">
                    <button type="button">XXL</button>
                  </div>
                </div>
              </div>
              <div class="cart-buttons mt-3">
                <div class="buttons d-flex flex-column flex-lg-row gap-3 mt-4">
                  <a href="{{route('add_to_cart',['product_id'=>$product_detail[0]->product_id])}}" class="btn btn-lg btn-dark btn-ecomm px-5 py-3 col-lg-6"><i class="bi bi-basket2 me-2"></i>Add to Bag</a>
                  <a href="{{route('add_to_wishlist',['product_id'=>$product_detail[0]->product_id])}}" class="btn btn-lg btn-outline-dark btn-ecomm px-5 py-3"><i class="bi bi-suit-heart me-2"></i>Wishlist</a>
                </div>
              </div>
              <hr class="my-3">
              <div class="product-info">
                <h6 class="fw-bold mb-3">Product Details</h6>
                <p class="mb-1">There are many variations of passages of Lorem Ipsum</p>
                <p class="mb-1">All the Lorem Ipsum generators on the Internet tend to repeat</p>
                <p class="mb-1">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece</p>
                <p class="mb-1">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
              </div>
              <hr class="my-3">


              <hr class="my-3">

            </div>
    </section>
    <!--start product details-->


    <!--start product details-->
    <section class="section-padding">
      <div class="container">
        <div class="separator pb-3">
          <div class="line"></div>
          <h3 class="mb-0 h3 fw-bold">Similar Products</h3>
          <div class="line"></div>
        </div>
        <div class="similar-products">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-4">
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/best-sellar/03.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/new-arrival/02.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/best-sellar/02.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/new-arrival/04.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/new-arrival/05.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/trending-product/03.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/featured-products/05.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/trending-product/05.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/trending-product/01.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col">
              <a href="javascript:;">
                <div class="card rounded-0">
                  <img src="{{asset('assets/user_assets/images/trending-product/02.webp')}}" alt="" class="card-img-top rounded-0">
                  <div class="card-body border-top">
                    <h5 class="mb-0 fw-bold product-short-title">Syndrona</h5>
                    <p class="mb-0 product-short-name">Color Printed Kurta</p>
                    <div class="product-price d-flex align-items-center gap-3 mt-2">
                      <div class="h6 fw-bold">$458</div>
                      <div class="h6 fw-light text-muted text-decoration-line-through">$2089</div>
                      <div class="h6 fw-bold text-danger">(70% off)</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>


          </div>
          <!--end row-->
        </div>
      </div>
    </section>
    <!--end product details-->


  </div>
  <!--end page content-->


  <!--start footer-->
  <section class="footer-section bg-section-2 section-padding">
    <div class="container">
      <div class="row row-cols-1 row-cols-lg-4 g-4">
        <div class="col">
          <div class="footer-widget-6">
            <img src="{{asset('assets/user_assets/images/logo.webp')}}" class="logo-img mb-3" alt="">
            <h5 class="mb-3 fw-bold">About Us</h5>
            <p class="mb-2">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>

            <a class="link-dark" href="javascript:;">Read More</a>
          </div>
        </div>
        <div class="col">
          <div class="footer-widget-7">
            <h5 class="mb-3 fw-bold">Explore</h5>
            <ul class="widget-link list-unstyled">
              <li><a href="javascript:;">Fashion</a></li>
              <li><a href="javascript:;">Women</a></li>
              <li><a href="javascript:;">Furniture</a></li>
              <li><a href="javascript:;">Shoes</a></li>
              <li><a href="javascript:;">Topwear</a></li>
              <li><a href="javascript:;">Brands</a></li>
              <li><a href="javascript:;">Kids</a></li>
            </ul>
          </div>
        </div>
        <div class="col">
          <div class="footer-widget-8">
            <h5 class="mb-3 fw-bold">Company</h5>
            <ul class="widget-link list-unstyled">
              <li><a href="javascript:;">About Us</a></li>
              <li><a href="javascript:;">Contact Us</a></li>
              <li><a href="javascript:;">FAQ</a></li>
              <li><a href="javascript:;">Privacy</a></li>
              <li><a href="javascript:;">Terms</a></li>
              <li><a href="javascript:;">Complaints</a></li>
            </ul>
          </div>
        </div>
        <div class="col">
          <div class="footer-widget-9">
            <h5 class="mb-3 fw-bold">Follow Us</h5>
            <div class="social-link d-flex align-items-center gap-2">
              <a href="javascript:;"><i class="bi bi-facebook"></i></a>
              <a href="javascript:;"><i class="bi bi-twitter"></i></a>
              <a href="javascript:;"><i class="bi bi-linkedin"></i></a>
              <a href="javascript:;"><i class="bi bi-youtube"></i></a>
              <a href="javascript:;"><i class="bi bi-instagram"></i></a>
            </div>
            <div class="mb-4 mt-4">
              <h5 class="mb-0 fw-bold">Support</h5>
              <p class="mb-0 text-muted">support@example.com</p>
            </div>
            <div class="">
              <h5 class="mb-0 fw-bold">Toll Free</h5>
              <p class="mb-0 text-muted">1800- 8xx 2xx</p>
            </div>
          </div>
        </div>
      </div><!--end row-->
      <div class="my-5"></div>
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <h5 class="fw-bold mb-3">Download Mobile App</h5>
          </div>
          <div class="app-icon d-flex flex-column flex-sm-row align-items-center justify-content-center gap-2">
            <div>
              <a href="javascript:;">
                <img src="{{asset('assets/user_assets/images/play-store.webp')}}" width="160" alt="">
              </a>
            </div>
            <div>
              <a href="javascript:;">
                <img src="{{asset('assets/user_assets/images/apple-store.webp')}}" width="160" alt="">
              </a>
            </div>
          </div>
        </div>
      </div><!--end row-->

    </div>
  </section>
  <!--end footer-->

  <footer class="footer-strip text-center py-3 bg-section-2 border-top positon-absolute bottom-0">
    <p class="mb-0 text-muted">© 2022. www.example.com | All rights reserved.</p>
  </footer>


  <!--start cart-->
  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
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
            <p class="mb-0"><strong>1 X {{$cart_product->purchase_price}}.00</strong>
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



  <!--Start Back To Top Button-->
  <a href="javaScript:;" class="back-to-top"><i class="bi bi-arrow-up"></i></a>
  <!--End Back To Top Button-->


  <!-- JavaScript files -->
  <script src="{{asset('assets/user_assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/user_assets/js/jquery.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js')}}"></script>
  <script src="{{asset('assets/user_assets/plugins/slick/slick.min.js')}}"></script>
  <script src="{{asset('assets/user_assets/js/main.js')}}"></script>
  <script src="{{asset('assets/user_assets/js/index.js')}}"></script>


</body>

</html>