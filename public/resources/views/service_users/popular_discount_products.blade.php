<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--favicon-->
	<link rel="icon" href="{{asset('assets/user_assets/images/favicon-32x32.webp')}}" type="image/webp" />

  <!-- CSS files -->
  <link href="{{asset('assets/user_assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <!-- Plugins -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/user_assets/plugins/slick/slick.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('assets/user_assets/plugins/slick/slick-theme.css')}}" />

  <link href="{{asset('assets/user_assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/user_assets/css/dark-theme.css')}}" rel="stylesheet">

  <title>Add Mag Pro |</title>
</head>

<body>

  <!--page loader-->
  <div class="loader-wrapper">
   <div class="d-flex justify-content-center align-items-center position-absolute top-50 start-50 translate-middle">
     <div class="spinner-border text-dark" role="status">
       <span class="visually-hidden">Loading...</span>
     </div>
   </div>
 </div>
<!--end loader-->

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
    <div class="container-fluid">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0"> 
          <li class="breadcrumb-item"><a href="/welcome_page">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
          <li class="breadcrumb-item active" aria-current="page">Shop With Grid</li>
        </ol>
      </nav>
    </div>
   </div>
   <!--end breadcrumb-->


   <!--start product grid-->
   <section class="py-4">
    <h5 class="mb-0 fw-bold d-none">Product Grid</h5>
    <div class="container-fluid">
      <div class="btn btn-dark btn-ecomm d-xl-none position-fixed top-50 start-0 translate-middle-y"  data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarFilter"><span><i class="bi bi-funnel me-1"></i> Filters</span></div>
       <div class="row">
          <div class="col-12 col-xl-2 filter-column">
              <nav class="navbar navbar-expand-xl flex-wrap p-0">
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbarFilter" aria-labelledby="offcanvasNavbarFilterLabel">
                  <div class="offcanvas-header">
                    <h5 class="offcanvas-title mb-0 fw-bold" id="offcanvasNavbarFilterLabel">Filters</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body">
                    <div class="filter-sidebar">
                      <div class="card rounded-0">
                        <div class="card-header d-none d-xl-block bg-transparent">
                            <h5 class="mb-0 fw-bold">Filters</h5>
                        </div>
                        <div class="card-body">
                          <h6 class="p-1 fw-bold bg-light">Categories</h6>
                            <div class="categories">
                             <div class="categories-wrapper height-1 p-1">
                               <form>
                                  <div class="input-group">
                                    
                                    <select class="form-select rounded-0" id="category-filter" name="category-filter">
                                      <option selected>Whats'New</option>
                                      <option value="1">Popularity</option>
                                      <option value="2">Better Discount</option>
                                      <option value="3">Price : Hight to Low</option>
                                      <option value="4">Price : Low to Hight</option>
                                      <option value="5">Custom Rating</option>
                                    </select>
                                  </div>
                                </form>
                             </div>
                          </div>
                          <hr>
                          <div class="brands">
                            <h6 class="p-1 fw-bold bg-light">Brands</h6>
                             <div class="brands-wrapper height-1 p-1">
                              <form>
                                <div class="input-group">
                                  
                                  <select class="form-select rounded-0" id="brand-filter" name="brand-filter">
                                    <option selected>Whats'New</option>
                                    <option value="1">Popularity</option>
                                    <option value="2">Better Discount</option>
                                    <option value="3">Price : Hight to Low</option>
                                    <option value="4">Price : Low to Hight</option>
                                    <option value="5">Custom Rating</option>
                                  </select>
                                </div>
                              </form>
                             </div>
                          </div>
                          <hr>
                          <div class="Price">
                            <h6 class="p-1 fw-bold bg-light">Price</h6>
                             <div class="Price-wrapper p-1">
                              <div class="input-group">
                                <input type="text" class="form-control rounded-0" placeholder="$10">
                                <span class="input-group-text bg-section-1 border-0">-</span>
                                <input type="text" class="form-control rounded-0" placeholder="$10000">
                                <button type="button" class="btn btn-outline-dark rounded-0 ms-2"><i class="bi bi-chevron-right"></i></button>
                              </div>
                             </div>
                           </div>
                           <hr>
                          <!-- <div class="colors">
                            <h6 class="p-1 fw-bold bg-light">Colors</h6>
                             <div class="color-wrapper height-1 p-1">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor1">
                                <label class="form-check-label" for="chekColor1">
                                  <i class="bi bi-circle-fill me-1 text-danger"></i><span>Red</span><span class="product-number">(845)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor2">
                                <label class="form-check-label" for="chekColor2">
                                  <i class="bi bi-circle-fill me-1 text-primary"></i><span>Blue</span><span class="product-number">(257)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor3">
                                <label class="form-check-label" for="chekColor3">
                                  <i class="bi bi-circle-fill me-1 text-warning"></i><span>Yellow</span><span class="product-number">(968)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor4">
                                <label class="form-check-label" for="chekColor4">
                                  <i class="bi bi-circle-fill me-1 text-success"></i><span>Green</span><span class="product-number">(478)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor5">
                                <label class="form-check-label" for="chekColor5">
                                  <i class="bi bi-circle-fill me-1 text-info"></i><span>Skyblue</span><span class="product-number">(256)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor6">
                                <label class="form-check-label" for="chekColor6">
                                  <i class="bi bi-circle-fill me-1 text-dark"></i><span>Black</span><span class="product-number">(124)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor7">
                                <label class="form-check-label" for="chekColor7">
                                  <i class="bi bi-circle-fill me-1 text-purple"></i><span>Purple</span><span class="product-number">(897)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor8">
                                <label class="form-check-label" for="chekColor8">
                                  <i class="bi bi-circle-fill me-1 text-orange"></i><span>Orange</span><span class="product-number">(68)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor9">
                                <label class="form-check-label" for="chekColor9">
                                  <i class="bi bi-circle-fill me-1 text-cyane"></i><span>Cyane</span><span class="product-number">(784)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor10">
                                <label class="form-check-label" for="chekColor10">
                                  <i class="bi bi-circle-fill me-1 text-brown"></i><span>Brown</span><span class="product-number">(532)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor11">
                                <label class="form-check-label" for="chekColor11">
                                  <i class="bi bi-circle-fill me-1 text-ten"></i><span>Ten</span><span class="product-number">(532)</span>
                                </label>
                               </div>
                               <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chekColor12">
                                <label class="form-check-label" for="chekColor12">
                                  <i class="bi bi-circle-fill me-1 text-pink"></i><span>Pink</span><span class="product-number">(452)</span>
                                </label>
                               </div>
                             </div>
                           </div> -->
                           
                           
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </nav>
          </div>
          <div class="col-12 col-xl-10">
            <div class="shop-right-sidebar">
              <div class="card rounded-0">
                <div class="card-body p-2">
                  <div class="d-flex align-items-center justify-content-between bg-light p-2">
                     <div class="product-count">657 Items Found</div>
                     <form>
                      <div class="input-group">
                        <span class="input-group-text bg-transparent rounded-0 border-0">Sort By</span>
                        <select class="form-select rounded-0">
                          <option selected>Whats'New</option>
                          <option value="1">Popularity</option>
                          <option value="2">Better Discount</option>
                          <option value="3">Price : Hight to Low</option>
                          <option value="4">Price : Low to Hight</option>
                          <option value="5">Custom Rating</option>
                        </select>
                      </div>
                    </form> 
                  </div>
                </div>
              </div>

              <div class="product-grid mt-4">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
                  @foreach($products as $product)
                  @if($product->purchase_price<3000)
                  <div class="col">
                    <div class="card border shadow-none">
                      <div class="position-relative overflow-hidden">
                        <div class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                          <a href="javascript:;"><i class="bi bi-heart"></i></a>
                          <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                          <a href="javascript:;"><i class="bi bi-zoom-in"></i></a>
                        </div>
                        <a href="product_detail/{{$product->product_id}}">
                          <img src="{{asset($product->product_images)}}" class="card-img-top" alt="...">
                        </a>
                      </div>
                      <div class="card-body border-top">
                        <h5 class="mb-0 fw-bold product-short-title">{{$product->product_name}}</h5>
                        <p class="mb-0 product-short-name">{{$product->product_description}}</p>
                        <div class="product-price d-flex align-items-center gap-2 mt-2">
                          <div class="h6 fw-bold">{{$product->purchase_price}}</div>
                          <div class="h6 fw-light text-muted text-decoration-line-through">{{$product->unit_price}}</div>
                          <div class="h6 fw-bold text-danger">(70% off)</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  @endforeach
              


              </div><!--end row-->
            </div>

            </div>
          </div>
       </div><!--end row-->
    </div>
  </section>
   <!--start product details-->


  
  
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
            <p class="mb-0"><strong>1 X {{$cart_product->purchase_price}}0</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="/remove_item_cart/{{$cart_product->product_id}}" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        @endforeach  

      </div>
    </div>
    <div class="offcanvas-footer p-3 border-top">
      <div class="d-grid">
        <a href="/billing_details_form" type="button" class="btn btn-lg btn-dark btn-ecomm px-5 py-3">Checkout</a>
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
   <script src="{{asset('assets/user_assets/plugins/slick/slick.min.js')}}"></script>
   <script src="{{asset('assets/user_assets/js/main.js')}}"></script>
   <script src="{{asset('assets/user_assets/js/loader.js')}}"></script>


</body>

</html>