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
        <!--<li class="nav-item">-->
        <!--  <a class="nav-link" href="search.html"><i class="bi bi-search"></i></a>-->
        <!--</li>-->
       
        <li class="nav-item">
          <a class="nav-link" href="{{route('user_dashboard')}}"><i class="bi bi-person-circle"></i></a>
        </li>

      </ul>
    </nav>
  </header>
<!--start page content-->
<div class="page-content">


<!--start breadcrumb-->
<div class="py-4 border-bottom">
 <div class="container">
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


<!--start product details-->
<section class="section-padding">
 <div class="container">
   <div class="d-flex align-items-center px-3 py-2 border mb-4">
     <div class="text-start">
       <h4 class="mb-0 h4 fw-bold">Account - Dashboard</h4>
    </div>
   </div>
  <div class="btn btn-dark btn-ecomm d-xl-none position-fixed top-50 start-0 translate-middle-y"  data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarFilter"><span><i class="bi bi-person me-2"></i>Account</span></div>
    <div class="row">
       <div class="col-12 col-xl-3 filter-column">
           <nav class="navbar navbar-expand-xl flex-wrap p-0">
             <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbarFilter" aria-labelledby="offcanvasNavbarFilterLabel">
               <div class="offcanvas-header">
                 <h5 class="offcanvas-title mb-0 fw-bold text-uppercase" id="offcanvasNavbarFilterLabel">Account</h5>
                 <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
               </div>
               <div class="offcanvas-body account-menu">
                 <div class="list-group w-100 rounded-0">
                   <a href="{{route('user_dashboard')}}" class="list-group-item "><i class="bi bi-house-door me-2"></i>Dashboard</a>
                   <!-- <a href="account-dashboard.html" class="list-group-item"><i class="bi bi-people me-2"></i>My Income</a> -->
                   <a href="{{route('user_wallet')}}" class="list-group-item"><i class="bi bi-people me-2"></i>Wallets</a>
                   <a href="{{route('team_details')}}" class="list-group-item"><i class="bi bi-people me-2"></i>Team Details</a>
                   <a href="{{route('account_profile')}}" class="list-group-item"><i class="bi bi-person me-2"></i>Profile</a>
                   <a href="{{route('account_orders')}}" class="list-group-item"><i class="bi bi-bag me-2"></i>My Orders</a>
                   <!-- <a href="reports.html" class="list-group-item"><i class="bi bi-receipt me-2"></i>Reports</a> -->
                   <!-- <a href="{{route('id_activation')}}" class="list-group-item"><i class="bi bi-star me-2"></i>ID Activations</a> -->
                   <!-- <a href="wishlist.html" class="list-group-item"><i class="bi bi-headset me-2"></i>Support</a> -->
                   <a href="{{route('service_user_logout')}}" class="list-group-item"><i class="bi bi-power me-2"></i>Logout</a>
                 </div>
               </div>
             </div>
         </nav>
       </div>