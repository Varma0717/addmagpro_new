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
  <style>
    .call-now-btn{
     animation: blink 1.5s linear infinite;
    }
    @keyframes blink {
      0%{
        transform: scaleX(1);
        transform: scaleY(1);
      }
      50%{
        transform: scaleX(1.3);
        
      }
      100%{
        transform: scaleX(1);
        transform: scaleY(1);
      }
      
    }
    @media (max-width: 768px) {
      h5{
        font-size: 15px;
      }
      a{
        font-size: 10px;
      }
      
    }
  </style>
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
              <a class="nav-link active" href="{{route('welcome_page')}}">Home</a>
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
        <!-- <li class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
          <a class="nav-link position-relative" href="javascript:;">
            <div class="cart-badge">0</div>
            <i class="bi bi-basket2"></i>
          </a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="{{route('user_dashboard')}}"><img src="{{asset('assets/user_assets/images/avatars/01.webp')}}" alt="" style="max-width: 50px; border-radius: 100%; align-self: center;" class="profile-img"></a>
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
          <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:;">Pages</a></li>
          <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
      </nav>
    </div>
   </div>
   <!--end breadcrumb-->


   <!--start product details-->
   <section class="section-padding">
    <div class="container">

      <div class="separator mb-3">
        <div class="line"></div>
        <h3 class="mb-0 h3 fw-bold" name="">{{$service_users[0]->member_name}}</h3>
        <div class="line"></div>
        
      </div>
      <div class="col-12 m-2">
        <div class="border p-4 text-center">
          <div class="text-strat mb-4">
            <h5 ><i class="bi bi-geo-alt m-2" ></i><span>{{$service_users[0]->address}}</span></h5>
          </div>
          <div class="row row-cols-3">
            <div class="col-6 text-center"> <a href="tel:{{$service_users[0]->member_phone}}"><button class="btn btn-dark"><i class=" bi bi-phone"></i>call now</button></a></div>
            <div class="col-6"> <a href="https://wa.me/{{$service_users[0]->member_phone}}?text=" target="_blank"><button class="btn btn-dark"><i class=" bi bi-whatsapp"></i>Chat Now</button></a></div>
           <!--<div>-->
           <!-- <a href="" class="btn btn-primary">Share</a>-->
           <!--</div>-->
          </div>
      </div>
      </div>
<div class="row">
  
  <div class="col-12 col-md-5">
    <div class="border p-4 text-center">
      <img src="{{asset($service_users[0]->business_image)}}" alt="" class="img-fluid">
  </div>
  </div>
  <div class="col-12 col-md-7">
    <div class="border p-4 text-center ">
      <div class="row  py-3 g-4">
        <div class="col-6">
          <h5 class="fw-bold text-start"><i class="bi bi-person-circle m-2"></i>Name :</h5>
          
        </div>
        <div class="col-6 ">
          <h5 class="fw-bold" name="profile-name">{{$service_users[0]->member_name}}</h5>
          
        </div>
        <div class="col-6">
          <h5 class="fw-bold text-start"><i class="bi bi-geo-alt m-2" ></i>Address :</h5>
        </div>
        <div class="col-6">
          
       <h5>{{$service_users[0]->address}}</h5>
        </div>
        <div class="col-6">
          <h5 class="fw-bold text-start"><i class="bi bi-building m-2" style="font-size: 25px;"></i>bussiness Summary :</h5>
        </div>
        <div class="col-6">
          
       <h5>{{$service_users[0]->description}}</h5>
        </div>
        <div class="col-6">
          <h5 class="fw-bold text-start"><i class="bi bi-alarm m-2"></i>Available Timings :</h5>
        </div>
        <div class="col-6">
          <h5 class="">Mon-Sat : 9:00 am to 9:00 Pm</h5>
          <h5 class="">Sunday   &nbsp; : 9:00 am to 9:00 Pm</h5>
        </div>
        <div class="col-12">
 <a href="tel:{{$service_users[0]->member_phone}}" class=" btn btn-dark">contact me</a>
        </div>
      </div>
      
  </div>
  </div>
</div>

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
    <h5 class="mb-0 fw-bold" id="offcanvasRightLabel">8 items in the cart</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
      <div class="cart-list">

        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/01.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/02.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/03.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/04.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/05.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/06.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/07.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/08.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/09.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
        <hr>
        <div class="d-flex align-items-center gap-3">
          <div class="bottom-product-img">
            <a href="product-details.html">
              <img src="{{asset('assets/user_assets/images/new-arrival/10.webp')}}" width="60" alt="">
            </a>
          </div>
          <div class="">
            <h6 class="mb-0 fw-light mb-1">Product Name</h6>
            <p class="mb-0"><strong>1 X $59.00</strong>
            </p>
          </div>
          <div class="ms-auto fs-5">
            <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="offcanvas-footer p-3 border-top">
      <div class="d-grid">
        <button type="button" class="btn btn-lg btn-dark btn-ecomm px-5 py-3">Checkout</button>
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