<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--favicon-->
	<link rel="icon" href="{{asset('assets/user_assets/images/favicon-32x32.webp')}}" type="image/webp" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>

  <!-- CSS files -->
  <link href="{{asset('assets/user_assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <!-- Plugins -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/user_assets/plugins/slick/slick.css')}}" />
  <link rel="stylesheet" type="text/css" href="{{asset('assets/user_assets/plugins/slick/slick-theme.css')}}" />

  <link href="{{asset('assets/user_assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/user_assets/css/dark-theme.css')}}" rel="stylesheet">

  <title>AddMagPro </title>
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

      </ul>
    </nav>
  </header>
  <!--end top header-->


<!--start page content-->
<div class="page-content">


  


   


  <!--start product details-->
  <section class="section-padding">
    <div class="container">
      <div class="separator pb-3">
        <div class="line"></div>
        <h3 class="mb-0 h3 fw-bold" id="type-advertise" name="type-advertise">Stores</h3>
        <div class="line"></div>
      </div>
      <div class="similar-products">
      <div class="row">
        @foreach($service_users as $service_user)
        <div class="col-md-6">
          <div class="container">
            <div class="card">
              <div class="row">
               <div class="col-md-5 p-3 border-top d-flex justify-content-center">
                <img src="{{asset($service_user->business_image)}}" alt="" class="img-fluid h-100" style="border-radius: 5px;" >
               </div>
               <a href="{{route('service_user_detail_view',['user_id'=>$service_user->user_id])}}" class="col-md-7  p-3 service-profile-details text-center">
                 <label for="name">Name</label>
                 <h4 id="name">{{$service_user->member_name}}</h4>
                 <label for="name">Address</label>
                   <p>{{$service_user->address}}</p>
                   <p>{{$service_user->state}}</p>
                   <!--<p>{{$service_user->district}}</p>-->
                   <p>{{$service_user->pincode}}</p>
               </a>
               <div class="col-12 p-1 mb-2">
                <div class="row row-cols-3">
                  <div class="col-6 text-center"> <a href="tel:{{$service_user->member_phone}}"><button class="btn btn-dark"><i class=" bi bi-phone"></i>call now</button></a></div>
                  <div class="col-6"> <a href="https://wa.me/{{$service_user->member_phone}}?text=" target="_blank"><button class="btn btn-dark"><i class=" bi bi-whatsapp"></i>Chat Now</button></a></div>
                </div>
               </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <div class="col-md-6">
 
</div>


      </div>
        <!--end row-->
      </div>
    </div>
  </section>
  <!--end product details-->

  
 </div>
  <!--end page content-->

  <!-- Button for listing Services-->
  <div class="col-12">
    <hr>
    <div class="container d-flex justify-content-center">
        
        <a href="{{route('adding_store')}}"><button class="btn btn-lg btn-dark"> <i class="bi bi-plus"></i> list Your bussiness</button></a>
       
    </div>
    <hr>
  </div>
  <!-- Button for listing Services-->

  <!--start footer-->
 
  <!--end footer-->

  <footer class="footer-strip text-center py-3 bg-section-2 border-top positon-absolute bottom-0">
    <p class="mb-0 text-muted">© 2024. www.addmagpro.com | All rights reserved.</p>
  </footer>





<!--Start Back To Top Button-->
  <a href="javaScript:;" class="back-to-top"><i class="bi bi-arrow-up"></i></a>
<!--End Back To Top Button-->
  

   <!-- JavaScript files -->
   <script src="{{asset('assets/user_assets/js/bootstrap.bundle.min.js')}}"></script>
   <script src="{{asset('assets/user_assets/js/jquery.min.js')}}"></script>
   <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
   <script src="{{asset('assets/user_assets/plugins/slick/slick.min.js')}}"></script>
   <script src="{{asset('assets/user_assets/js/main.js')}}"></script>
   <script src="{{asset('assets/user_assets/js/index.js')}}"></script>
   <script src="{{asset('assets/user_assets/js/loader.js')}}"></script>


</body>

</html>