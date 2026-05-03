<!doctype html>
<html lang="en" class="light-theme">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--favicon-->
  <link rel="icon" href="assets/user_assets/images/favicon-32x32.webp" type="image/webp" />

  <!-- CSS files -->
  <link href="assets/user_assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <!-- Plugins -->
  <link rel="stylesheet" type="text/css" href="assets/user_assets/plugins/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="assets/user_assets/plugins/slick/slick-theme.css" />

  <link href="assets/user_assets/css/style.css" rel="stylesheet">
  <link href="assets/user_assets/css/dark-theme.css" rel="stylesheet">

  <title>AddMagPro | Home Page</title>
</head>

<body>



     <!--page loader-->
     <!--<div class="loader-wrapper">-->
     <!-- <div class="d-flex justify-content-center align-items-center position-absolute top-50 start-50 translate-middle">-->
     <!--   <div class="spinner-border text-dark" role="status">-->
     <!--     <span class="visually-hidden">Loading...</span>-->
     <!--   </div>-->
     <!-- </div>-->
    </div>
   <!--end loader-->

  <!--start top header-->
  <header class="top-header">
    <nav class="navbar navbar-expand-xl w-100 navbar-dark container gap-3">
      <a class="navbar-brand d-none d-xl-inline" href="{{route('welcome_page')}}"><img src="{{asset('assets/user_assets/images/logo.png')}}" class="logo-img" alt=""></a>
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
              <a class="nav-link active" href="{{route('welcome_page')}}">Home</a>
            </li>
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                Memberships
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('services_list')}}">Services</a></li>
                <li><a class="dropdown-item" href="{{route('user_stores_list')}}">Stores</a></li>
                <li><a class="dropdown-item" href="{{route('products_list')}}">Products</a></li>
                
              </ul>
            </li>
            <!--<li class="nav-item">-->
            <!--  <a class="nav-link" href="{{route('welcome_page')}}">About</a>-->
            <!--</li>-->
            <!--<li class="nav-item">-->
            <!--  <a class="nav-link" href="{{route('welcome_page')}}">Contact</a>-->
            <!--</li>-->
            <!--<li class="nav-item dropdown">-->
            <!--  <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">-->
            <!--    About-->
            <!--  </a>-->
            <!--</li>-->
            <!--<li class="nav-item dropdown">-->
            <!--  <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">-->
            <!--    Contact-->
            <!--  </a>-->
            <!--</li>-->
            <li class="nav-item">
              <a class="nav-link" href="{{route('contact_us')}}">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('user_dashboard')}}">Refer and Earn</a>
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
        <li class="nav-item d-none d-md-block">
          <h3 class="user-greeting">Hi, {{$user_name}}</h3>
        </li>
      </ul>
    </nav>
  </header>
  <!--end top header-->


  <!--start page content-->
  <div class="page-content">

  <section class="visitors-section bg-twitter p-2 border">
  <div class="col-12 ">
    <div class="container d-md-block d-none">
      <div class="row text-center">
           <div class="col-4">
            <h6>Total visitors :<span class="btn btn-success">{{$visitor_users_count}}</span></h6>
           </div>
           <div class="col-4">
            <h6>Total Joinings : <span class="btn btn-warning">{{$active_users_count}}</span></h6> 
          </div>
      </div>
    </div>
  </div>
</section>

    <!--start carousel-->
    <section class="slider-section mb-3">
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
            aria-current="true"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($main_slider_banner[0]->banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($main_slider_banner[1]->banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
        
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($main_slider_banner[2]->banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($main_slider_banner[3]->banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($main_slider_banner[4]->banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
          data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
          data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>
    <!--end carousel-->

    
<!-- slider + member Category-->
<section class="mt-2">
<div class="col-12 mb-3">

  <div class="container">
    <div class="row">
    <div class="col-md-6 col-12 bg-facebook" style="border-radius: 10px; overflow: hidden;">
      <div class="row">
      <div class="col-12 mt-2">
        <h6 class="text-center fw-bold">MEMBERSHIPS</h6>
      </div>
      <div class="service-card col-md-5 mx-auto my-2 col-5" style="background-color: rgb(250, 252, 253); box-shadow: 0 2px 6px 0 rgba(250, 250, 250, 0.55), 0 2px 6px 0 rgba(247, 247, 248, 0.44);">
        <div class="row">
          <a href="{{route('services_list')}}" class="product-image d-flex justify-content-center mt-3">
            <img src="./assets/user_assets/images/avatars/service_image.png" alt=""  class="img-fluid">
          </a>
          <a href="{{route('services_list')}}" class="card-body">
            <h5 class="product-name text-center fw-bold">
              Services
            </h5>
          </a>
        </div>
       </div>
       <div class="service-card col-md-5 mx-auto my-2 col-5" style="background-color: rgb(250, 252, 253); box-shadow: 0 2px 6px 0 rgba(250, 250, 250, 0.55), 0 2px 6px 0 rgba(247, 247, 248, 0.44);">
        <div class="row">
          <a href="{{route('user_stores_list')}}" class="product-image d-flex justify-content-center mt-3">
            <img src="./assets/user_assets/images/avatars/store_image.png" alt=""  class="img-fluid">
          </a>
          <a href="{{route('user_stores_list')}}" class="card-body">
            <h5 class="product-name text-center fw-bold">
              Stores
            </h5>
          </a>
        </div>
       </div>
       <br><br>
       <div class="service-card col-md-5 mx-auto  my-2 col-5" style="background-color: rgb(250, 252, 253); box-shadow: 0 2px 6px 0 rgba(250, 250, 250, 0.55), 0 2px 6px 0 rgba(247, 247, 248, 0.44);">
        <div class="row">
          <a href="{{route('products_list')}}" class="product-image d-flex justify-content-center mt-3">
            <img src="./assets/user_assets/images/products_home1.jpeg" alt=""  class="img-fluid">
          </a>
          <a href="{{route('products_list')}}" class="card-body">
            <h5 class="product-name text-center fw-bold">
              Products
            </h5>
          </a>
        </div>
       </div>
       <div class="service-card col-md-5 mx-auto my-2 col-5" style="background-color: rgb(250, 252, 253); box-shadow: 0 2px 6px 0 rgba(250, 250, 250, 0.55), 0 2px 6px 0 rgba(247, 247, 248, 0.44);">
        <div class="row">
          <a href="{{route('classifieds_list')}}" class="product-image d-flex justify-content-center mt-3">
            <img src="./assets/user_assets/images/catelog.jpeg" alt=""  class="img-fluid">
          </a>
          <a href="{{route('classifieds_list')}}" class="card-body">
            <h5 class="product-name text-center fw-bold">
            Classifieds
            </h5>
          </a>
        </div>
       </div>
      </div>
    </div>


<div class="col-md-6 col-12 mt-3 mt-md-0">
<section class="slider-section col-md-12">
      <div id="smallCarouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="0" class="active"
            aria-current="true"></button>
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="2"></button>
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="3"></button>
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="4"></button>
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="5"></button>
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="6"></button>
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="7"></button>
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="8"></button>
          <button type="button" data-bs-target="#smallCarouselExampleCaptions" data-bs-slide-to="9"></button>
        </div>
        <div class="carousel-inner" style="border-radius:10px;">
          <div class="carousel-item active">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[0]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[1]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[2]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[3]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[4]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[5]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[6]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[7]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[8]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="row d-flex align-items-center">
              <div class="col">
                <img src="{{asset($ads_gallery[9]->ads_banner_image)}}" class="img-fluid" alt="..." name="main-slider-img">
              </div>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#smallCarouselExampleCaptions"
          data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#smallCarouselExampleCaptions"
          data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>
      <!--end carousel-->
    </div> 
   </div>
  </div>
</div>

</section>
<!-- slider + member Category ends-->



<section class="mb-4">

  <div class="container">
    <div class="text-center pb-3">
      <div class="row mt-4">
       
        
          <h3 class="mb-0 h3 fw-bold mt-4">Popular Services</h3>
        <p class="mb-0 text-capitalize">select your best service provider from market</p>
       
        
      </div>
    </div>
  <div class="container">
    <div class="row">
      @foreach($service as $service)
      <div class="service-card col-md-2 mx-auto col-2">
       <div class="row">
         <a href="{{route('service_fullview',['service_id'=>$service->service_id])}}" class="product-image d-flex justify-content-center mt-3">
           <img src="{{$service->service_image}}" alt=""  class="img-fluid">
         </a>
         <a href="{{route('service_fullview',['service_id'=>$service->service_id])}}" class="card-body">
           <h5 class="product-name text-center fw-bold">
             {{$service->service_name}}
           </h5>
         </a>
       </div>
     </div>
     @endforeach
     <div class="service-card col-md-2 mx-auto col-2">
       <div class="row">
        <a href="{{route('services_list')}}"><div class="product-image d-flex justify-content-center mt-3">
          <i class="bi bi-arrow-right text-dark text-center"></i>
         </div>
         <a href="{{route('services_list')}}" class="card-body">
           <h5 class="product-name text-center fw-bold">
             view all
           </h5>
         </a>
         </div>
        </a>
     </div>
     
   </div>
  </div>
</div>
</section>


<section class="mb-4">

  <div class="container">
    <div class="text-center pb-3">
      <div class="row mt-4">
       
        
          <h3 class="mb-0 h3 fw-bold mt-4">Popular Stores</h3>
        <p class="mb-0 text-capitalize">select your best store provider from market</p>
       
        
      </div>
    </div>
  <div class="container">
    <div class="row">
      @foreach($store as $store)
      <div class="service-card col-md-2 mx-auto col-2">
       <div class="row">
         <a href="{{route('store_fullview',['store_id'=>$store->StoreID])}}" class="product-image d-flex justify-content-center mt-3">
           <img src="{{asset($store->store_image)}}" alt=""  class="img-fluid">
         </a>
         <a href="{{route('store_fullview',['store_id'=>$store->StoreID])}}" class="card-body">
           <h5 class="product-name text-center fw-bold">
            {{$store->StoreName}}
           </h5>
         </a>
       </div>
     </div>
     @endforeach
     <div class="service-card col-md-2 mx-auto col-2">
       <div class="row">
        <a href="{{route('user_stores_list')}}"><div class="product-image d-flex justify-content-center mt-3">
          <i class="bi bi-arrow-right text-dark text-center"></i>
         </div>
         <a href="{{route('user_stores_list')}}" class="card-body">
           <h5 class="product-name text-center fw-bold">
             view all
           </h5>
         </a>
         </div>
        </a>
     </div>
     
   </div>
  </div>
</div>
</section>



<!-- service banner starts-->
<section class="adv-banner-2">
  <div class="container mt-5">
<div class="text-center pb-3">
      <div class="row ">
        
        
          <h3 class="mb-0 h3 fw-bold mt-4">{{$headings[0]->heading}}</h3>
        <p class="mb-0 text-capitalize">get 100% cashback on this products</p>
        
        
      </div>
    </div>
  <div class="col-lg-12 col-md-12 col-12 card-img-top d-flex justify-content-center align-items-center" >
   <div class="img-fluid overflow-hidden adv-banner-img col-12">
            <!-- <img src="./assets/user_assets/images/bannerimage.jpg" alt="" class="img-fluid w-100 h-100" name="banner-1"> -->
            <img src="{{asset($banner1[0]->banner_image)}}" alt="" class="img-fluid w-100 h-100" name="banner-1">
   </div>
  </div>
</div>
</section>

<!-- service banner ends-->



    <!--start Featured Products slider-->
    <section class="section-padding ">
      <div class="container" style="border-radius: 10px;">
        <div class="product-thumbs">
        @foreach($vendors_cashback_products as $product)
        @if($product->purchase_price>3000)
          <div class="card">
            <div class="position-relative overflow-hidden">
              <div
                class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                <a href="{{route('add_to_wishlist',['product_id'=>$product->product_id])}}"><i class="bi bi-heart"></i></a>
                
                <!-- <a href="{{route('add_to_cart',['product_id'=>$product->product_id,'quantity'=>'1'])}}"><i class="bi bi-basket3"></i></a> -->
                <!-- <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                    class="bi bi-zoom-in"></i></a> -->
              </div>
              <a href="{{route('product_detail',['vendor_id'=>$product->vendor_id,'category_id'=>$product->category_id])}}">
                <img src="{{$product->product_images}}" class="card-img-top" alt="...">
              </a>
            </div>
            <div class="card-body">
              <div class="product-info text-center">
                <h6 class="mb-1 fw-bold product-name">{{$product->product_name}}</h6>
                <div class="ratings mb-1 h6">
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                  <i class="bi bi-star-fill text-warning"></i>
                </div>
                <p class="mb-0 h6 fw-bold product-price">{{$product->purchase_price}}</p>
              </div>
            </div>
          </div>
        @endif
          @endforeach
          
        </div>
      <a  href="{{route('products_list')}}" class="d-flex justify-content-center align-items-center ">
          <h6 class="btn btn-dark">view all</h6>
        </a> 
        <!--<a  href="{{route('add_your_shop')}}" class="d-flex justify-content-center align-items-center ">-->
        <!--  <h6 class="btn btn-dark">Add Your Shop</h6>-->
        <!--</a>-->
      </div>
    </section>
    <!--end Featured Products slider-->

    <!-- vendor advertisement start -->
<section class="section-padding ">
  <div class="container " style="border-radius: 10px;">
    <div class="text-center pb-3">
      <div class="row ">
       
        
          <h3 class="mb-0 h3 fw-bold mt-4">{{$headings[1]->heading}}</h3>
        
       
        
      </div>
    </div>
    <div class="product-thumbs">
      @foreach($vendor_banners as $vendor_banner)
      <div class="card">
        <div class="position-relative overflow-hidden">
          
          <a href="{{route('products_list_vendor',['vendor_id'=>$vendor_banner->vendor_id])}}">
            <img src="{{asset($vendor_banner->ImageURL)}}" class="card-img-top" alt="...">
          </a>
        </div>
        <!--<div class="card-body">-->
        <!--  <div class="product-info text-center">-->
        <!--    <h6 class="mb-1 fw-bold product-name"></h6>-->
           
        <!--  </div>-->
        <!--</div>-->
      </div>
      @endforeach
      
    </div>
    <a href="{{route('vendors_full_view')}}" class="d-flex justify-content-center align-items-center ">
      <h6 class="btn btn-dark">view all</h6>
      </a>
  </div>
</section>
<!-- vendor advertisement start -->




<!-- Discounts banner starts-->
<section class="adv-banner-2">
  <div class="container mt-5">
    <div class="col-12 p-0">
      <p></p>
      <div class="text-center pb-3">
      <div class="row mt-4">
       
        
          <h3 class="mb-0 h3 fw-bold mt-4">{{$headings[2]->heading}}</h3>
                    <a  href="{{route('add_your_shop')}}" class="d-flex justify-content-center align-items-center ">
          <h6 class="btn btn-dark">Add Your Shop</h6>
        </a>
        <p class="mb-0 text-capitalize">select your best descount provider from market</p>
       
        
      </div>
    </div>
    </div>
  <div class="col-lg-12 col-md-12 col-12 card-img-top d-flex justify-content-center align-items-center" >
   <div class="img-fluid overflow-hidden adv-banner-img col-12">
            <img src="{{asset($banner2[0]->banner_image)}}" alt="" class="img-fluid w-100 h-100" name="banner-2">
   </div>
  </div>
</div>
</section>
  
  
<!-- Discounts banner ends-->
<!--descounts slider-->
<section class="section-padding ">
  <div class="container" style="border-radius: 10px;">

    <div class="product-thumbs">
    @foreach($vendors_discount_products as $product)
        @if($product->purchase_price<3000)
      <div class="card">
        <div class="position-relative overflow-hidden">
          <div
          class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
          <a href="{{route('add_to_wishlist',['product_id'=>$product->product_id])}}"><i class="bi bi-heart"></i></a>
          <!-- <a href="{{route('add_to_cart',['product_id'=>$product->product_id,'quantity'=>'1'])}}"><i class="bi bi-basket3"></i></a> -->
          <!-- <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
              class="bi bi-zoom-in"></i></a> -->
        </div>
          <a href="{{route('product_detail',['vendor_id'=>$product->vendor_id,'category_id'=>$product->category_id])}}">
            <img src="{{$product->product_images}}" class="card-img-top" alt="...">
          </a>
        </div>
        <div class="card-body">
          <div class="product-info text-center">
            <h6 class="mb-1 fw-bold product-name">{{$product->product_name}}</h6>
            <p class="mb-0 h6 fw-bold product-price">{{$product->purchase_price}}</p>
          </div>
        </div>
      </div>  
      @endif
      @endforeach

      
    </div>
    <a href="{{route('popular_discounts_products')}}" class="d-flex justify-content-center align-items-center ">
      <h6 class="btn btn-dark">view all</h6>
    </a>
  </div>
</section>
<!--descounts slider ends-->

    <!--start tabular product-->
    <section class="product-tab-section section-padding bg-light">
      <div class="container">
        <div class="text-center pb-3">
          <h3 class="mb-0 h3 fw-bold">{{$headings[3]->heading}}</h3>
          <p class="mb-0 text-capitalize">The purpose of lorem ipsum</p>
        </div>
        <div class="row">
          <div class="col-auto mx-auto">
            <div class="product-tab-menu table-responsive">
              <ul class="nav nav-pills flex-nowrap" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#new-arrival" type="button">New
                    Arrival</button>
                </li>
                <!-- <li class="nav-item" role="presentation">
                  <button class="nav-link" data-bs-toggle="pill" data-bs-target="#best-sellar" type="button">Best
                    Sellar</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" data-bs-toggle="pill" data-bs-target="#trending-product"
                    type="button">Trending</button>
                </li> -->
                <li class="nav-item" role="presentation">
                  <button class="nav-link" data-bs-toggle="pill" data-bs-target="#special-offer" type="button">Special
                    Offer</button>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <hr>
        <div class="tab-content tabular-product">
          <div class="tab-pane fade show active" id="new-arrival">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4">
              @foreach($latest_products as $latest_product)
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="{{route('add_to_wishlist',['product_id'=>$product->product_id])}}"><i class="bi bi-heart"></i></a>
                      <!-- <a href="{{route('add_to_cart',['product_id'=>$product->product_id,'quantity'=>'1'])}}"><i class="bi bi-basket3"></i></a> -->
                      <!-- <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a> -->
                    </div>

                    <a href="{{route('latest_products_view')}}">
                      <img src="{{$latest_product->product_images}}" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">{{$latest_product->product_name}}</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">{{$latest_product->purchase_price}}</p>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <div class="tab-pane fade" id="best-sellar">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4">
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="product-details.html">
                      <img src="assets/user_assets/images/best-sellar/01.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="product-details.html">
                      <img src="assets/user_assets/images/best-sellar/02.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="product-details.html">
                      <img src="assets/user_assets/images/best-sellar/03.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="ribban bg-primary">New Fashion</div>
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="product-details.html">
                      <img src="assets/user_assets/images/best-sellar/04.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="product-details.html">
                      <img src="assets/user_assets/images/best-sellar/05.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="trending-product">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4">
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="product-details.html">
                      <img src="assets/user_assets/images/trending-product/01.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="product-details.html">
                      <img src="assets/user_assets/images/trending-product/02.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="ribban bg-warning text-dark">New Season</div>
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="javascript:;">
                      <img src="assets/user_assets/images/trending-product/03.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="product-details.html">
                      <img src="assets/user_assets/images/trending-product/04.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="product-details.html">
                      <img src="assets/user_assets/images/trending-product/05.webp" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">Product Name</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">$49</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="special-offer">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4">
            @foreach($products as $product)
        @if($product->purchase_price>3000)
              <div class="col">
                <div class="card">
                  <div class="position-relative overflow-hidden">
                    <div
                      class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                      <a href="javascript:;"><i class="bi bi-heart"></i></a>
                      <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"><i
                          class="bi bi-zoom-in"></i></a>
                    </div>
                    <a href="{{route('product_detail',['vendor_id'=>$product->vendor_id,'category_id'=>$product->category_id])}}">
                      <img src="{{$product->product_images}}" class="card-img-top" alt="...">
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="product-info text-center">
                      <h6 class="mb-1 fw-bold product-name">{{$product->product_name}}</h6>
                      <div class="ratings mb-1 h6">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                      </div>
                      <p class="mb-0 h6 fw-bold product-price">{{$product->purchase_price}}</p>
                    </div>
                  </div>
                </div>
              </div>
              @endif
              @endforeach
              
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--end tabular product-->




    <!--start cartegory slider-->
    <section class="cartegory-slider section-padding bg-section-2">
      <div class="container" style="border-radius: 10px;">
        <div class="text-center pb-3">
          <h3 class="mb-0 pt-3 h3 fw-bold">{{$headings[4]->heading}}</h3>
          <p class="mb-0 text-capitalize">Select your favorite categories and purchase</p>
        </div>
        <div class="cartegory-box">
          @foreach($categories as $category)
          <a  href="{{route('top_category_products_list',['category_id'=>$category->id])}}">
            <div class="card">
              <div class="card-body">
                <div class="overflow-hidden">
                  <img src="{{$category->ImageURL}}" class="card-img-top rounded-0" alt="...">
                </div>
                <div class="text-center">
                  <h5 class="mb-1 cartegory-name mt-3 fw-bold">{{$category->CategoryName}}</h5>
                  <!-- <h6 class="mb-0 product-number fw-bold">856 Products</h6> -->
                </div>
              </div>
            </div>
          </a>
          @endforeach

        </div>
      </div>
    </section>
    <!--end cartegory slider-->


    <!--subscribe banner-->
    <!-- <section class="product-thumb-slider subscribe-banner p-5">
      <div class="row">
        <div class="col-12 col-lg-6 mx-auto">
          <div class="text-center">
            <h3 class="mb-0 fw-bold text-white">Get Latest Update by <br> Subscribe Our Newslater</h3>
            <div class="mt-3">
              <input type="text" class="form-control form-control-lg bubscribe-control rounded-0 px-5 py-3"
                placeholder="Enter your email">
            </div>
            <div class="mt-3 d-grid">
              <button type="button" class="btn btn-lg btn-ecomm bubscribe-button px-5 py-3">Subscribe</button>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!--subscribe banner-->


    
    
  <!-- adv-1 banner ends-->
<section class="adv-1">


<div class="container">
  
  <div class="col-lg-12 col-md-none col-12  adv-bannner-1  ">
    <div class="banner-title text-center">
      <h5>
      Lorem ipsum dolor sit amet.
      </h5>
      <p>something</p>
       </div>
   <div class="row row-cols-2">
   
    <div class="card">
      <div class="card-body">
        <div class="overflow-hidden">
          <img src="assets/user_assets/images/categories/06.webp" class="card-img-top rounded-0" alt="..." name="adv-1-banner-1">
        </div>
        <div class="text-center">
          <h5 class="mb-1 cartegory-name mt-3 fw-bold" name="adv-1-banner-name-1">Shoes</h5>
          
        </div>
      </div>
    </div>
   
     
    <div class="card">
      <div class="card-body">
        <div class="overflow-hidden">
          <img src="assets/user_assets/images/categories/06.webp" class="card-img-top rounded-0" alt="..." name="adv-1-banner-2">
        </div>
        <div class="text-center">
          <h5 class="mb-1 cartegory-name mt-3 fw-bold" name="adv-1-banner-name-2">Shoes</h5>
          
        </div>
      </div>
    </div>
   </div>
  </div>
</div>
</section>
<!-- adv-1 banner ends-->
<!--adv-1 cards start-->
<!-- <section class="adv-cards-1 p-3">
  <div class="container">
    <div class="col-12 p-0">
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto, explicabo.</p>
      <h4>*Gadget Gallery</h4>
    </div>
   <div class="row row-cols-3 row-cols-md-6 ">
    
 
    @foreach($gallery_details as $gallery_detail)
     <div class="card adv-card mx-auto col">
       <div class="card-body">
         <div class="overflow-hidden d-flex justify-content-center">
           <img src="{{asset($gallery_detail->gallery_image)}}" class="card-img-top rounded-0" alt="..." name="adv-1-img-2">
         </div>
         <div class="text-center">
           <h5 class=" cartegory-name mt-1 fw-bold">Shoes</h5>
           
         </div>
       </div>
     </div>
     @endforeach
 
 
     
   </div>
  </div>
 
 </section> -->
<!--adv-1 cards end-->
<!-- adv-banner-2 banner starts-->
<section class="section-padding">
  <section class="adv-banner-2">
    <div class="container mt-5">
      <div class="text-center pb-3">
      <div class="row mt-4">
          <h3 class="mb-0 h3 fw-bold mt-4">{{$headings[5]->heading}}</h3>
        <p class="mb-0 text-capitalize">select your best gadget gallery from market</p>  
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-12 card-img-top d-flex justify-content-center align-items-center" >
     <div class="img-fluid overflow-hidden adv-banner-img col-12">
              <img src="{{asset($banner3[0]->banner_image)}}" alt="" class="img-fluid w-100 h-100" name="banner-3">
     </div>
    </div>
  </div>
  </section>
  
  
  <!-- adv-banner-2 banner ends-->
  
  <!-- adv-cards-2 starts-->
  
  <section class="cartegory-slider adv-cards-2-big">
    <div class="container" style="border-radius: 10px;">
      
      <div class="adv-slider-moving">
        
        @foreach($gadget_gallery as $gadget_gallery)
        <a href="shop-grid-type-4.html">
          <div class="card">
            <div class="card-body">
              <div class="overflow-hidden">
                <img src="{{asset($gadget_gallery['gadget_gallery_image'])}}" class="card-img-top rounded-0" alt="..." name="adv-2-slider-img">
              </div>
              
            </div>
          </div>
        </a>
        @endforeach
       
       
  
      </div>
    </div>
  </section>
  
  <section class="mb-4 ">
  
    <div class="container">
    
    <div class="container ">
      <div class="row">
      @foreach($gadget_gallery_mini as $gadget_gallery_mini)
       <div class="adv-card-2-small col-md-3  col-6">
        <img src="{{asset($gadget_gallery_mini['gadget_gallery_image'])}}" alt=""  class="img-fluid w-100" name="adv-2-img-4">
        </div>
      @endforeach
       </div>
    </div>
  </div>
  </section>
</section>
<!-- adv-card-2  ends-->



<!--adv-banner-4 starts-->
<section class="section-padding">
  <div class="text-center pb-3">
      <div class="row mt-4">
          <h3 class="mb-0 h3 fw-bold mt-4">{{$headings[6]->heading}}</h3>
        <p class="mb-0 text-capitalize">select your best speciality store from market</p>  
      </div>
    </div>
<section class="adv-cards-4">
  <div class="container" style="border-radius: 10px;">
    
    <div class="adv-slides">
      @foreach($store_gallery as $store_gallery)
      <a href="">
        <div class="card">
          <div class="card-body">
            <div class="overflow-hidden">
              <img src="{{asset($store_gallery['store_image'])}}" class="card-img-top rounded-0" alt="..." name="adv-3-img">
            </div>
           
          </div>
        </div>
      </a>
      @endforeach

    </div>
  </div>
</section>
</section>
<!--adv-banner-4 ends-->
<!--adv-banner-3 starts-->
<section class="section-padding bg-light border-top border-bottom">
  <section class="adv-banner-2">
    <div class="container mt-5">
      <div class="text-center pb-3">
      <div class="row mt-4">
          <h3 class="mb-0 h3 fw-bold mt-4">{{$headings[7]->heading}}</h3>
          <p class="mb-0 text-capitalize">select your best speciality store from market</p>  
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-12 card-img-top d-flex justify-content-center align-items-center" >
     <div class="img-fluid overflow-hidden adv-banner-img col-12">
              <img src="{{asset($banner4[0]->banner_image)}}" alt="" class="img-fluid w-100 h-100" name="banner-4">
     </div>
    </div>
  </div>
  </section>
  <section class="mb-4 mt-2 ">
  
    <div class="container">
      
    <div class="container ">
      <div class="row">
        
      
        @foreach($store_gallery_mini as $store_gallery_mini)
       <div class="adv-card-2-small col-md-3  col-6">
        <img src="{{asset($store_gallery_mini['store_image'])}}" alt=""  class="img-fluid" name="adv-4-img-4">
        </div>
        @endforeach
       </div>
    </div>
  </div>
  </section>
</section>
<!--adv-banner-3 ends-->

<!--adv-5 starts-->
<section class="section-padding">
  
  <section class="adv-cards-5">
    
    <div class="container" style="border-radius: 10px;">

      <div class="text-center pb-3">
      <div class="row mt-4">
          <h3 class="mb-0 h3 fw-bold mt-4">{{$headings[8]->heading}}</h3>
        <p class="mb-0 text-capitalize">select your best events store from market</p>  
      </div>
    </div>
      <div class="adv-slides-2">
        
      @foreach($event_banners as $event_banner)
        <a href="">
          
          <div class="card">
            <div class="card-body">
              <div class="overflow-hidden">
                <img src="{{asset($event_banner->event_banner_image)}}" class="card-img-top rounded-0" alt="..." name="event-img" width="250px" height="350px">
              </div>
              <div class="card-title text-center">
              </div>
            </div>
          </div>

        </a>
        @endforeach
  
      </div>
    </div>
  </section>
</section>

<!--adv-5 ends-->
    <!--subscribe banner-->
    <!-- <section class="product-thumb-slider subscribe-banner p-5">
      <div class="row">
        <div class="col-12 col-lg-6 mx-auto">
          <div class="text-center">
            <h3 class="mb-0 fw-bold text-white">Get Latest Update by <br> Subscribe Our Newslater</h3>
            <div class="mt-3">
              <input type="text" class="form-control form-control-lg bubscribe-control rounded-0 px-5 py-3"
                placeholder="Enter your email">
            </div>
            <div class="mt-3 d-grid">
              <button type="button" class="btn btn-lg btn-ecomm bubscribe-button px-5 py-3">Subscribe</button>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!--subscribe banner-->


    <!--start blog-->
    
  <!--end page content-->


  <!--start footer-->
  <section class="footer-section bg-section-2 section-padding">
    <div class="container">
       <div class="row row-cols-1 row-cols-lg-4 g-4 text-justify">
        <div class="col">
          <div class="footer-widget-6">
            <img src="assets/user_assets/images/logo.png" class="logo-img mb-3" alt="">
            <h5 class="mb-3 fw-bold">About Us</h5>
             <p class="mb-2 text-justify"> We are delighted to introduce you to Add Mag Pro, a leading E-commerce and Local Search Engine platform designed to help businesses like yours reach a broader audience and grow your customer base. Our website features a wide array of product categories including clothes, electronics, groceries, electric vehicles..etc and service categories , offering a one-stop shop for consumers and a lucrative marketplace for vendors.</p>

             <a class="link-dark" href="javascript:;">Read More</a>
          </div>
        </div>
        <div class="col">
          <div class="footer-widget-7">
            <h5 class="mb-3 fw-bold">Categories</h5>
             <ul class="widget-link list-unstyled">
               <li><a href="javascript:;">Electronics</a></li>
               <li><a href="javascript:;">Fashion</a></li>
               <li><a href="javascript:;">Furniture</a></li>
               <li><a href="javascript:;">Shoes</a></li>
               <li><a href="javascript:;">Services</a></li>
              
             </ul>
          </div>
        </div>
        <div class="col">
          <div class="footer-widget-8">
            <h5 class="mb-3 fw-bold">Company</h5>
             <ul class="widget-link list-unstyled">
               <li><a href="{{route('contact_us')}}">About Us</a></li>
               <li><a href="{{route('contact_us')}}">Contact Us</a></li>
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
             <div class="mb-3 mt-3">
              <h5 class="mb-0 fw-bold">Support</h5>
              <p class="mb-0 text-muted">contact@addmagpro.com</p>
             </div>
             <div class="">
              <h5 class="mb-0 fw-bold">Toll Free</h5>
              <p class="mb-0 text-muted">8522852201</p>
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
                <img src="assets/user_assets/images/play-store.webp" width="160" alt="">
              </a>
            </div>
            <div>
              <a href="javascript:;">
                <img src="assets/user_assets/images/apple-store.webp" width="160" alt="">
              </a>
            </div>
          </div>
         </div>
       </div><!--end row-->

    </div>
  </section>
  <!--end footer-->

  <footer class="footer-strip text-center py-3 bg-section-2 border-top positon-absolute bottom-0">
    <p class="mb-0 text-muted">© 2024. Add Mag Pro | All rights reserved.</p>
  </footer>


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


  <!--start quick view-->

  <!-- Modal -->
  <div class="modal fade" id="QuickViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content rounded-0">

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12 col-xl-6">

              <div class="wrap-modal-slider">

                <div class="slider-for">
                  <div>
                    <img src="assets/user_assets/images/product-images/01.jpg" alt="" class="img-fluid">
                  </div>
                  <div>
                    <img src="assets/user_assets/images/product-images/02.jpg" alt="" class="img-fluid">
                  </div>
                  <div>
                    <img src="assets/user_assets/images/product-images/03.jpg" alt="" class="img-fluid">
                  </div>
                  <div>
                    <img src="assets/user_assets/images/product-images/04.jpg" alt="" class="img-fluid">
                  </div>
                </div>

                <div class="slider-nav mt-3">
                  <div>
                    <img src="assets/user_assets/images/product-images/01.jpg" alt="" class="img-fluid">
                  </div>
                  <div>
                    <img src="assets/user_assets/images/product-images/02.jpg" alt="" class="img-fluid">
                  </div>
                  <div>
                    <img src="assets/user_assets/images/product-images/03.jpg" alt="" class="img-fluid">
                  </div>
                  <div>
                    <img src="assets/user_assets/images/product-images/04.jpg" alt="" class="img-fluid">
                  </div>
                </div>

              </div>

            </div>
            <div class="col-12 col-xl-6">
              <div class="product-info">
                <h4 class="product-title fw-bold mb-1">Check Pink Kurta</h4>
                <p class="mb-0">Women Pink & Off-White Printed Kurta with Palazzos</p>
                <div class="product-rating">
                  <div class="hstack gap-2 border p-1 mt-3 width-content">
                    <div><span class="rating-number">4.8</span><i class="bi bi-star-fill ms-1 text-success"></i></div>
                    <div class="vr"></div>
                    <div>162 Ratings</div>
                  </div>
                </div>
                <hr>
                <div class="product-price d-flex align-items-center gap-3">
                  <div class="h4 fw-bold">$458</div>
                  <div class="h5 fw-light text-muted text-decoration-line-through">$2089</div>
                  <div class="h4 fw-bold text-danger">(70% off)</div>
                </div>
                <p class="fw-bold mb-0 mt-1 text-success">inclusive of all taxes</p>

                <div class="more-colors mt-3">
                  <h6 class="fw-bold mb-3">More Colors</h6>
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="color-box bg-red"></div>
                    <div class="color-box bg-primary"></div>
                    <div class="color-box bg-yellow"></div>
                    <div class="color-box bg-purple"></div>
                    <div class="color-box bg-green"></div>
                  </div>
                </div>

                <div class="size-chart mt-3">
                  <h6 class="fw-bold mb-3">Select Size</h6>
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="">
                      <button type="button" class="rounded-0">XS</button>
                    </div>
                    <div class="">
                      <button type="button" class="rounded-0">S</button>
                    </div>
                    <div class="">
                      <button type="button" class="rounded-0">M</button>
                    </div>
                    <div class="">
                      <button type="button" class="rounded-0">L</button>
                    </div>
                    <div class="">
                      <button type="button" class="rounded-0">XL</button>
                    </div>
                    <div class="">
                      <button type="button" class="rounded-0">XXL</button>
                    </div>
                  </div>
                </div>
                <div class="cart-buttons mt-3">
                  <div class="buttons d-flex flex-column gap-3 mt-4">
                    <a href="javascript:;" class="btn btn-lg btn-dark btn-ecomm px-5 py-3 flex-grow-1"><i
                        class="bi bi-basket2 me-2"></i>Add to Bag</a>
                    <a href="javascript:;" class="btn btn-lg btn-outline-dark btn-ecomm px-5 py-3"><i
                        class="bi bi-suit-heart me-2"></i>Wishlist</a>
                  </div>
                </div>
                <hr class="my-3">
                <div class="product-share">
                  <h6 class="fw-bold mb-3">Share This Product</h6>
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="">
                      <button type="button" class="btn-social bg-twitter"><i class="bi bi-twitter"></i></button>
                    </div>
                    <div class="">
                      <button type="button" class="btn-social bg-facebook"><i class="bi bi-facebook"></i></button>
                    </div>
                    <div class="">
                      <button type="button" class="btn-social bg-linkden"><i class="bi bi-linkedin"></i></button>
                    </div>
                    <div class="">
                      <button type="button" class="btn-social bg-youtube"><i class="bi bi-youtube"></i></button>
                    </div>
                    <div class="">
                      <button type="button" class="btn-social bg-pinterest"><i class="bi bi-pinterest"></i></button>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!--end row-->
        </div>

      </div>
    </div>
  </div>
  <!--end quick view-->


  <!--Start Back To Top Button-->
  <a href="javaScript:;" class="back-to-top"><i class="bi bi-arrow-up"></i></a>
  <!--End Back To Top Button-->


  <!-- JavaScript files -->
  <script src="assets/user_assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/user_assets/js/jquery.min.js"></script>
  <script src="assets/user_assets/plugins/slick/slick.min.js"></script>
  <script src="assets/user_assets/js/main.js"></script>
  <script src="assets/user_assets/js/index.js"></script>
  <script src="assets/user_assets/js/loader.js"></script>

</body>

</html>