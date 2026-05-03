<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <!-- SEO Meta Tags -->
        <meta name="description" content="Your description">
        <meta name="author" content="Your name">

        <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
        <meta property="og:site_name" content="" /> <!-- website name -->
        <meta property="og:site" content="" /> <!-- website link -->
        <meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
        <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
        <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
        <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
        <meta name="twitter:card" content="summary_large_image"> <!-- to have large image post format in Twitter -->

        <!-- Webpage Title -->
        <title>Sign Up - Ioniq</title>
        
        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/fontawesome-all.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/swiper.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet">
        
        <!-- Favicon  -->
        <link rel="icon" href="{{asset('assets/images/favicon.png')}}">
        <style>
            
        </style>
    </head>
    <body>
        
       <!-- Navigation -->
       <nav id="navbarExample" class="navbar navbar-expand-lg fixed-top navbar-light" aria-label="Main navigation">
        <div class="container">

            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="index.html"><img src="{{asset('assets/images/logo.png')}}" alt="alternative"></a> 

            <!-- Text Logo - Use this if you don't have a graphic logo -->
            <!-- <a class="navbar-brand logo-text" href="index.html">Ioniq</a> -->

            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ms-auto navbar-nav-scroll">
                    <li>
                        <span class="nav-item">
                            <a class="btn-outline-sm" href="login">Log in</a>
                        </span> 
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-item dropdown-toggle btn-outline-sm" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Sign Up</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            <li><a class="dropdown-item" href="vendor_register">Vendor</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="#">Service User</a></li>
                            <li><div class="dropdown-divider"></div></li>
                            <li><a class="dropdown-item" href="#">Cashback User</a></li>
                        </ul>
                    </li>
                </ul>
                
            </div> <!-- end of navbar-collapse -->
        </div> <!-- end of container -->
    </nav> <!-- end of navbar -->
    <!-- end of navigation -->


        <!-- Header -->
        <header class="ex-header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                        <h1 class="text-center">VENDOR REGISTRATION</h1>
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            </div> <!-- end of container -->
        </header> <!-- end of ex-header -->
        <!-- end of header -->
        
        
        <!-- Basic -->
        <div class="ex-form-1 pt-5 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3">
                        <div class="text-box mt-5 mb-5">
                            <p class="mb-4">Fill out the form below to sign up . Already signed up? Then just <a class="blue" href="{{route('login')}}">Log In</a></p>

                            <!-- Sign Up Form -->
                            <form action="{{route('vendor_register')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" value="{{$referral_by}}" id="referral_by" name="referral_by">
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="name@example.com">
                                        <label for="floatingInput">Vendor Name</label>
                                        <span style="color:red">@error('vendor_name'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="number" class="form-control" id="vendor_number" name="vendor_number" placeholder="Phone Number">
                                        <label for="floatingInput">Phone number</label>
                                        <span style="color:red">@error('vendor_number'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="email" class="form-control"  placeholder="Emailid" id="vendor_email" name="vendor_email">
                                        <label for="floatingPassword">Email Id</label>
                                        <span style="color:red">@error('vendor_email'){{$message}}@enderror</span>
                                    </div>
                                    
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="Bussiness Name" id="bussiness_name" name="bussiness_name">
                                        <label for="floatingPassword">Bussiness Name</label>
                                        <span style="color:red">@error('bussiness_name'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="Bussiness Type" id="bussiness_type" name="bussiness_type">
                                        <label for="floatingPassword">Bussiness Type</label>
                                        <span style="color:red">@error('bussiness_type'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="Address" id="vendor_address" name="vendor_address">
                                        <label for="floatingPassword">Address</label>
                                        <span style="color:red">@error('vendor_address'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="Location" id="vendor_location" name="vendor_location">
                                        <label for="floatingPassword">Location</label>
                                        <span style="color:red">@error('vendor_location'){{$message}}@enderror</span>
                                    </div>
                                    <!-- <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="Address" id="aadhar_number" name="aadhar_number">
                                        <label for="floatingPassword">Aadhar Number</label>
                                        <span style="color:red">@error('aadhar_number'){{$message}}@enderror</span>
                                    </div> -->
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="Pan Number" id="pan_number" name="pan_number">
                                        <label for="floatingPassword">Pan Number</label>
                                        <span style="color:red">@error('pan_number'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="GST Number" id="gst_number" name="gst_number">
                                        <label for="floatingPassword">GST Number</label>
                                        <span style="color:red">@error('gst_number'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="Commission Percentage" id="commission_percentage" name="commission_percentage">
                                        <label for="commission_percentage">Commission Percentage</label>
                                        <span style="color:red">@error('commission_percentage'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="Bank Name" id="bank_name" name="bank_name">
                                        <label for="floatingPassword">Bank Name</label>
                                        <span style="color:red">@error('bank_name'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="Account No" id="account_num" name="account_num">
                                        <label for="floatingPassword">Account Number</label>
                                        <span style="color:red">@error('account_num'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="text" class="form-control"  placeholder="IFSC Code" id="ifsc" name="ifsc">
                                        <label for="floatingPassword">IFSC</label>
                                        <span style="color:red">@error('ifsc'){{$message}}@enderror</span>
                                    </div>
                                    <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="password" class="form-control" placeholder="Password" id="vendor_password" name="vendor_password">
                                        <label for="floatingPassword">Password</label>
                                        <span style="color:red">@error('vendor_password'){{$message}}@enderror</span>
                                    </div>
                                    <!-- <div class="mb-4 form-floating col-12 col-md-6">
                                        <input type="password" class="form-control" id="Confirm-password" placeholder="Confirm-password" id="confirm_password" name="confirm_password">
                                        <label for="floatingPassword">Confirm Password</label>
                                    </div> -->
                                    
                                    
                                </div>
                                <!-- <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" >
                                    <label class="form-check-label" for="exampleCheck1">I agree with the site's stated <a href="privacy.html">Privacy Policy</a> and <a href="terms.html">Terms & Conditions</a></label>
                                </div> -->
                               
                              <input type="submit" class="form-control-submit-button"  value="Sign Up">
                            </form>
                            <!-- end of sign up form -->

                        </div> <!-- end of text-box -->
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            </div> <!-- end of container -->
        </div> <!-- end of ex-basic-1 -->
        <!-- end of basic -->


        <!-- Footer -->
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-col first">
                            <h6>About Website</h6>
                            <p class="p-small">Proin ut felis purus vestibulum in orci molestie, efficitur lacus ac pellentesque elit. Fusce mollis laoreet lobortis nulla ac efficitur lacus ac </p>
                        </div> <!-- end of footer-col -->
                        <div class="footer-col second">
                            <h6>Links</h6>
                            <ul class="list-unstyled li-space-lg p-small">
                                <li>Important: <a href="terms.html">Terms & Conditions</a>, <a href="privacy.html">Privacy Policy</a></li>
                                <li>Useful: <a href="#">Colorpicker</a>, <a href="#">Icon Library</a>, <a href="#">Illustrations</a></li>
                                <li>Menu: <a href="#header">Home</a>, <a href="#features">Features</a>, <a href="#details">Details</a>, <a href="#pricing">Pricing</a></li>
                            </ul>
                        </div> <!-- end of footer-col -->
                        <div class="footer-col third">
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x"></i>
                                </a>
                            </span>
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-twitter fa-stack-1x"></i>
                                </a>
                            </span>
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-pinterest-p fa-stack-1x"></i>
                                </a>
                            </span>
                            <span class="fa-stack">
                                <a href="#your-link">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-instagram fa-stack-1x"></i>
                                </a>
                            </span>
                            <p class="p-small">Quam posuerei pellent esque vam <a href="mailto:contact@site.com"><strong>contact@site.com</strong></a></p>
                        </div> <!-- end of footer-col -->
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            </div> <!-- end of container -->
        </div> <!-- end of footer -->  
        <!-- end of footer -->


        <!-- Copyright -->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <p class="p-small">Copyright © <a href="#your-link">Your name</a></p>
                    </div> <!-- end of col -->
                    <div class="col-lg-6">
                        <p class="p-small">Distributed By<a href="https://themewagon.com/"> Themewagon</a></p>
                    </div> <!-- end of col -->
                </div> <!-- enf of row -->
            </div> <!-- end of container -->
        </div> <!-- end of copyright --> 
        <!-- end of copyright -->
        

        <!-- Back To Top Button -->
        <button onclick="topFunction()" id="myBtn">
            <img src="{{asset('assets/images/up-arrow.png')}}" alt="alternative">
        </button>
        <!-- end of back to top button -->
            
        <!-- Scripts -->
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script> <!-- Bootstrap framework -->
        <script src="{{asset('assets/js/swiper.min.js')}}"></script> <!-- Swiper for image and text sliders -->
        <script src="{{asset('assets/js/purecounter.min.js')}}"></script> <!-- Purecounter counter for statistics numbers -->
        <script src="{{asset('assets/js/replaceme.min.js')}}"></script> <!-- ReplaceMe for rotating text -->
        <script src="{{asset('assets/js/scripts.js')}}"></script> <!-- Custom scripts -->
    </body>
</html>