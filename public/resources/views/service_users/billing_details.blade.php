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
        <!-- <li class="nav-item">
          <a class="nav-link" href="{{route('wishlist')}}"><i class="bi bi-suit-heart"></i></a>
        </li>
        <li class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
          <a class="nav-link position-relative" href="javascript:;">
            <div class="cart-badge">0</div>
            <i class="bi bi-basket2"></i>
          </a>
        </li> -->
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
          <li class="breadcrumb-item"><a href="/welcome_page">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:;">checkout</a></li>
          <li class="breadcrumb-item active" aria-current="page">Billing Details</li>
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
          <h4 class="mb-0 h4 fw-bold">Billing Details</h4>
       </div>
      </div>
	   <div class="row g-4">
      <form action="{{route('billing_details_form_submit')}}" method="POST">
        @csrf
	     <div class="col-12 col-lg-12 col-xl-12">

        <h6 class="fw-bold mb-3 py-2 px-3 bg-light">Personal Details</h6>
        
		  <div class="card rounded-0 mb-3">
			  <div class="card-body">
			    <div class="row g-3">
             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="first_name" name="first_name" placeholder="First Name" value="{{$user_details->member_name}}" required>
                <label for="first_name">First Name</label>
              </div>
             </div>
             @if(empty($bank_details['bank_name']))
             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="location" name="location" placeholder="Last Name" required>
                <label for="location">Location</label>
              </div>
             </div>
             @else
             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="location" name="location" placeholder="Last Name" value="{{$user_details['location']}}" required>
                <label for="location">Location</label>
              </div>
             </div>
            @endif
             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="email" name="email" placeholder="Email" required>
                <label for="email">Email</label>
              </div>
             </div>

             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="mobile_no" name="mobile_no" placeholder="Mobile No" value="{{$user_details->member_phone}}" required>
                <label for="mobile_no">Mobile No</label>
              </div>
             </div>
          </div><!--end row-->
			  </div>
			 </div> 
        <h6 class="fw-bold mb-3 py-2 px-3 bg-light">Bank Details</h6>
        
		  <div class="card rounded-0 mb-3">
			  <div class="card-body">
			    <div class="row g-3">
             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="account_holder_name" name="account_holder_name" placeholder="First Name" value="{{$user_details->member_name}}" required>
                <label for="account_holder_name">Account Holder Name</label>
              </div>
             </div>
             @if(empty($bank_details['bank_name']))
              <div class="col-12 col-lg-6">
                  <div class="form-floating">
                      <input type="text" class="form-control rounded-0" id="bank_name" name="bank_name" placeholder="Bank Name" required>
                      <label for="bank_name">Bank Name</label>
                  </div>
              </div>
              @else
              <div class="col-12 col-lg-6">
                  <div class="form-floating">
                      <input type="text" class="form-control rounded-0" id="bank_name" name="bank_name" placeholder="Bank Name" value="{{ $bank_details['bank_name'] }}" readonly>
                      <label for="bank_name">Bank Name</label>
                  </div>
              </div>
             @endif
             @if(empty($bank_details['account_number']))
             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="account_number" name="account_number" placeholder="account_number" required>
                <label for="account_number">Account Number</label>
              </div>
             </div>
             @else
             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="account_number" name="account_number" placeholder="account_number" value="{{ $bank_details['account_number'] }}" readonly>
                <label for="account_number">Account Number</label>
              </div>
             </div>
             @endif
             @if(empty($bank_details['ifsc']))
             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="ifsc" name="ifsc" placeholder="Mobile No" required>
                <label for="ifsc">IFSC</label>
              </div>
             </div>
             @else
             <div class="col-12 col-lg-6">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="ifsc" name="ifsc" placeholder="Mobile No" value="{{ $bank_details['ifsc'] }}" readonly>
                <label for="ifsc">IFSC</label>
              </div>
             </div>
             @endif
             @if(empty($bank_details['pancard_number']))
             <div class="col-12 col-lg-12">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="pan_number" name="pan_number" placeholder="Mobile No" required>
                <label for="pan_number">PAN NUMBER</label>
              </div>
             </div>
             @else
             <div class="col-12 col-lg-12">
              <div class="form-floating">
                <input type="text" class="form-control rounded-0" id="pan_number" name="pan_number" placeholder="Mobile No" value="{{ $bank_details['pancard_number'] }}" readonly>
                <label for="pan_number">PAN NUMBER</label>
              </div>
             </div>
             @endif
          </div><!--end row-->
			  </div>
			 </div> 

                <h6 class="fw-bold mb-3 py-2 px-3 bg-light">Shipping Details</h6>
		    <div class="card rounded-0">
			   <div class="card-body">
          <div class="row g-3">
          @if(empty($user_details['address']))
            <div class="col-12 col-lg-12">
             <div class="form-floating">
               <input type="text" class="form-control rounded-0" id="address" name="address" placeholder="Street Address" required >
               <label for="address">Street Address</label>
             </div>
            </div>
          @else
            <div class="col-12 col-lg-12">
             <div class="form-floating">
               <input type="text" class="form-control rounded-0" id="address" name="address" placeholder="Street Address" required value="{{$user_details['address']}}">
               <label for="address">Street Address</label>
             </div>
            </div>
          @endif
          @if(empty($user_details['city']))
            <div class="col-12 col-lg-4">
             <div class="form-floating">
               <input type="text" class="form-control rounded-0" id="city_name" name="city_name" placeholder="City"  required>
               <label for="city_name">City</label>
             </div>
            </div>
          @else
            <div class="col-12 col-lg-4">
             <div class="form-floating">
               <input type="text" class="form-control rounded-0" id="city_name" name="city_name" placeholder="City"  required value="{{$user_details['city']}}">
               <label for="city_name">City</label>
             </div>
            </div>
          @endif
          @if(empty($user_details['pincode']))
            <div class="col-12 col-lg-4">
             <div class="form-floating">
               <input type="text" class="form-control rounded-0" id="zip_code" name="zip_code" placeholder="Zip Code" required>
               <label for="zip_code">Pin Code</label>
             </div>
            </div>
          @else
            <div class="col-12 col-lg-4">
             <div class="form-floating">
               <input type="text" class="form-control rounded-0" id="zip_code" name="zip_code" placeholder="Zip Code" required value="{{$user_details['pincode']}}">
               <label for="zip_code">Pin Code</label>
             </div>
            </div>
          @endif
          @if(empty($user_details['state']))
            <div class="col-12 col-lg-4">
             <div class="form-floating">
               <input type="text" class="form-control rounded-0" id="country_name" name="country_name" placeholder="Country" required>
               <label for="country_name">State</label>
             </div>
            </div>
          @else
            <div class="col-12 col-lg-4">
             <div class="form-floating">
               <input type="text" class="form-control rounded-0" id="country_name" name="country_name" placeholder="Country" required value="{{$user_details['state']}}">
               <label for="country_name">State</label>
             </div>
            </div>
          @endif
            <div class="col-12 col-lg-12">
              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-dark btn-ecomm py-3 px-5">Submit</button>
             </div>
             </div>
         </div><!--end row-->
			  </div>
			</div> 
    </form>
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