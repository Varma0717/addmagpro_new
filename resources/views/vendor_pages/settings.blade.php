@extends('vendor_layouts.master')
@section('mainsection')
                  <div class="pcoded-content">
                      <!-- Page-header start -->
                      <div class="page-header">
                          <div class="page-block">
                              <div class="row align-items-center">
                                  <div class="col-md-8">
                                      <div class="page-header-title">
                                          <h5 class="m-b-10">Settings</h5>
                                          <p class="m-b-0">Welcome to Add Mag Pro</p>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <ul class="breadcrumb-title">
                                          <li class="breadcrumb-item">
                                              <a href="index.html"> <i class="fa fa-home"></i> </a>
                                          </li>
                                          <li class="breadcrumb-item"><a href="#!">Settings</a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
<!--basic details changing end-->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Settings</h5>
                                        </div>

                                        <div>
                                            <form action="vendor_settings_update" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="container">
                                                    <div class="d-flex justify-content-center mt-5 col-md-12" id="imageDisplay" style="border-radius: 50%;">
                                                        <div id="imageDisplay" style="border-radius:100%;">
                                                            <!-- <img src="./assets/vendor_assets/images/user.png" alt="DP" id="profile-image" style="border-radius:100%; max-width: 250px; width: 250px;"> -->
                                                            <img src="{{$vendor_details[0]['profile_image']}}" alt="DP" id="profile-image" style="border-radius: 40%; max-width: 150px; width: 150px;">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12  mt-4">
                                                        <div class="card-header">
                                                            <h5>change Profile photo</h5>
                                                        </div>
                                                        <!-- <label for="imageInput" id="imageInput" name="imageInput">Change Photo</label> -->
                                                        <input type="file" id="imageInput" name="imageInput" onchange="displayImage(event)" accept="image/png, imag/jpg, image/jpeg" class="form-control"> 
                                                    </div>
                                                    
                                                    
                                                </div>
                                                <div class="row p-5">
                                                    <div class="mb-4 form-floating col-12 col-md-6">
                                                        <label for="vendor_name">Vendor Name</label>
                                                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="name@example.com" value="{{$vendor_details[0]['vendor_name']}}" required>
                                                        
                                                    </div>
                                                    <div class="mb-4 form-floating col-12 col-md-6">
                                                        <label for="phone_number">Phone number</label>
                                                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" value="{{$vendor_details[0]['vendor_phone']}}" required>
                                                        
                                                    </div>
                                                    <div class="mb-4 form-floating col-12 col-md-6">
                                                        <label for="vendor_email">Emailid</label>
                                                        <input type="email" class="form-control" id="vendor_email"  placeholder="{{$vendor_details[0]['vendor_email']}}" value="{{$vendor_details[0]['vendor_email']}}" readonly>
                                                        
                                                    </div>
                                                    
                                                    <div class="mb-4 form-floating col-12 col-md-6">
                                                        <label for="business_name">Bussiness Name</label>
                                                        <input type="text" class="form-control"  placeholder="Bussiness Name" id="business_name" name="business_name" value="{{$vendor_details[0]['business_name']}}" required>
                                                        
                                                    </div>
                                                    <div class="mb-4 form-floating col-12 col-md-6">
                                                        <label for="business_type">Bussiness Type</label>
                                                        <input type="text" class="form-control"  placeholder="Bussiness Type" id="business_type" name="business_type" value="{{$vendor_details[0]['business_type']}}" required>
                                                        
                                                    </div>
                                                    <div class="mb-4 form-floating col-12 col-md-6">
                                                        <label for="vendor_address">Address</label>
                                                        <input type="text" class="form-control"  placeholder="Address" id="vendor_address" name="vendor_address" value="{{$vendor_details[0]['business_address']}}" required>
                                                        
                                                    </div>
                                                    
                                                    
                                                    <div class=" col-md-12 justify-content-center align-items-start">
                                                        <input type="submit" class="form-control-submit-button btn  btn-primary"  value="Save changes">
                                                    </div>
                                                </div>
                                                
                                               
                                              
                                            </form>
                                        </div>
                                    </div>
<!--basic details changing end-->

                                    <!--for password start-->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Change Password</h5>
                                        </div>
                                        <form action="change_password" method="POST">
                                            @csrf
                                           <div class="row p-5">
                                            <!-- <div class="mb-4 form-floating col-12 col-md-6">
                                                <label for="floatingPassword"> Old Password</label>
                                                <input type="password" class="form-control" id="old_password" name="old_password" placeholder=" Enter Old Password">
                                                
                                            </div> -->
                                            <div class="mb-4 form-floating col-12 col-md-6">
                                                <input type="hidden" id="vendor_id" name="vendor_id" value="{{$vendor_details[0]['vendor_id']}}">
                                                <label for="floatingPassword">New Password</label>
                                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter New Password">
                                               
                                            </div>
                                            <div class="col-md-12 justify-content-center align-items-center">
                                                <input type="submit" class="form-control-submit-button btn btn-primary"  value="change Password">
                                            </div>
                                           </div>
                                        </form>
                                    </div>
                                      <!--for password start-->
                                    <!-- Page-body end -->
                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/jquery-ui/jquery-ui.min.js ')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/popper.js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/bootstrap/js/bootstrap.min.js')}} "></script>
    <script type="text/javascript" src="{{asset('assets/vendor_assets/pages/widget/excanvas.js ')}}"></script>
    <!-- waves js -->
    <script src="{{asset('assets/vendor_assets/pages/waves/js/waves.min.js')}}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/jquery-slimscroll/jquery.slimscroll.js ')}}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/modernizr/modernizr.js ')}}"></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/SmoothScroll.js')}}"></script>
    <script src="{{asset('assets/vendor_assets/js/jquery.mCustomScrollbar.concat.min.js')}} "></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/chart.js/Chart.js')}}"></script>
    <!-- amchart js -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js')}}"></script>
    <script src="{{asset('assets/vendor_assets/pages/widget/amchart/gauge.js')}}"></script>
    <script src="{{asset('assets/vendor_assets/pages/widget/amchart/serial.js')}}"></script>
    <script src="{{asset('assets/vendor_assets/pages/widget/amchart/light.js')}}"></script>
    <script src="{{asset('assets/vendor_assets/pages/widget/amchart/pie.min.js')}}"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js')}}"></script>
    <!-- menu js -->
    <script src="{{asset('assets/vendor_assets/js/pcoded.min.js')}}"></script>
    <script src="{{asset('assets/vendor_assets/js/vertical-layout.min.js')}} "></script>
    <!-- custom js -->
    <script type="text/javascript" src="{{asset('assets/vendor_assets/pages/dashboard/custom-dashboard.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/script.js')}} "></script>
    <script>
        function displayImage(event) {
            const fileInput = event.target;
            const imageDisplay = document.getElementById('imageDisplay');
            const img  =document.getElementById('profile-img');
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
        
                reader.onload = function(e) {
                    const imageUrl = e.target.result;
                    
                    //  Create an image element
                    // const imgElement = document.createElement('img');
                    //imgElement.src = imageUrl;
                    //imgElement.style.width = '250px';
                    //imgElement.style.height = '350px';
                    //imgElement.style='border-radius:100%';
                    //imgElement.style = 'max-width: 250px';
                    
                    // Display the image
                    imageDisplay.innerHTML = ''; // Clear previous image
                    
                    imageDisplay.innerHTML=<img src='${imageUrl}' alt="DP"  style="border-radius:100%; max-width: 250px; width: 250px; height: 250px">;
                };
        
                // Read the image file as a data URL
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
        </script>
</body>

</html>
@endsection()