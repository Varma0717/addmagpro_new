<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--favicon-->
	<link rel="icon" href="assets/user_assets/images/favicon-32x32.webp" type="image/webp" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>

  <!-- CSS files -->
  <link href="assets/user_assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <!-- Plugins -->
  <link rel="stylesheet" type="text/css" href="assets/user_assets/plugins/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="assets/user_assets/plugins/slick/slick-theme.css" />

  <link href="assets/user_assets/css/style.css" rel="stylesheet">
  <link href="assets/user_assets/css/dark-theme.css" rel="stylesheet">

  <title>AddMagPro </title>
  <style>
    .mx-auto{
      margin-left: 5px;
      margin-right: 5px;
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
              <a class="nav-link" href="{{route('contact_us')}}">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('contact_us')}}">Contact</a>
            </li>
          
         
          </ul>
        </div>
      </div>
      <ul class="navbar-nav secondary-menu flex-row">
        <li class="nav-item">
          <a class="nav-link dark-mode-icon" href="javascript:;">
            <div class="mode-icon">
              <i class="bi bi-moon"></i>
            </div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="search.html"><i class="bi bi-search"></i></a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link" href="account-dashboard.html"><i class="bi bi-person-circle"></i></a>
        </li>
        <!--<li class="nav-item">-->
        <!--  @if($service_used_count==0)-->
        <!--    <a href="{{route('adding_service')}}"><div class="btn btn-dark">list your bussiness</div></a>-->
        <!--  @else-->
        <!--    <a href="{{route('services_list')}}"><div class="btn btn-danger">Service Already Used</div></a>-->
        <!--  @endif-->
        <!--</li>-->
      </ul>
    </nav>
  </header>
  <!--end top header-->


<!--start page content-->
<div class="page-content">


  


   
  <section class="mb-4">

    <div class="container">
      <div class="text-center pb-3">
        <div class="row mt-4">
         
          
            <h3 class="mb-0 h3 fw-bold mt-4">Services</h3>
         
         
          
        </div>
      </div>
    <div class="container">
      <div class="row row-cols-lg-3 row-cols-2">
      @foreach($services as $service)
        <div class="service-card col-md-2 mx-auto bg-light">
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
    </div>
  </div>
  </section>


  
 </div>
  <!--end page content-->

  <!-- Button for listing Services-->
  <div class="col-12">
    <hr>
    <!--<div class="container d-flex justify-content-center">-->
        
    <!--    <a href="{{route('adding_service')}}"><button class="btn btn-lg btn-dark">list Your bussiness</button></a>-->
       
    <!--</div>-->
    <hr>
  </div>
  <!-- Button for listing Services-->

  <!--start footer-->
  
  <!--end footer-->

  <footer class="footer-strip text-center py-3 bg-section-2 border-top positon-absolute bottom-0">
    <p class="mb-0 text-muted">© 2024. www.addmagpro.com | All rights reserved.</p>
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
              <img src="assets/user_assets/images/new-arrival/01.webp" width="60" alt="">
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
              <img src="assets/user_assets/images/new-arrival/02.webp" width="60" alt="">
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
              <img src="assets/user_assets/images/new-arrival/03.webp" width="60" alt="">
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
              <img src="assets/user_assets/images/new-arrival/04.webp" width="60" alt="">
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
              <img src="assets/user_assets/images/new-arrival/05.webp" width="60" alt="">
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
              <img src="assets/user_assets/images/new-arrival/06.webp" width="60" alt="">
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
              <img src="assets/user_assets/images/new-arrival/07.webp" width="60" alt="">
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
              <img src="assets/user_assets/images/new-arrival/08.webp" width="60" alt="">
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
              <img src="assets/user_assets/images/new-arrival/09.webp" width="60" alt="">
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
              <img src="assets/user_assets/images/new-arrival/10.webp" width="60" alt="">
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
   <script src="assets/user_assets/js/bootstrap.bundle.min.js"></script>
   <script src="assets/user_assets/js/jquery.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
   <script src="assets/user_assets/plugins/slick/slick.min.js"></script>
   <script src="assets/user_assets/js/main.js"></script>
   <script src="assets/user_assets/js/index.js"></script>
   <script src="assets/user_assets/js/loader.js"></script>


</body>

</html>