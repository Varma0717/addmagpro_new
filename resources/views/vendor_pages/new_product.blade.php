@extends('vendor_layouts.master')
@section('mainsection')
                  <div class="pcoded-content">
                      <!-- Page-header start -->
                      <div class="page-header">
                          <div class="page-block">
                              <div class="row align-items-center">
                                  <div class="col-md-8">
                                      <div class="page-header-title">
                                          <h5 class="m-b-10">ADD NEW PRODUCT</h5>
                                          <p class="m-b-0">Welcome to Add Mag Pro</p>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <ul class="breadcrumb-title">
                                          <li class="breadcrumb-item">
                                              <a href="index.html"> <i class="fa fa-home"></i> </a>
                                          </li>
                                          <li class="breadcrumb-item"><a href="./settings.html">New Inhouse Product  </a>
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
                                   <div class="conatiner">
                                    
                                        <h3>Add New Product</h3>
                                    </div>
                                     <form action="{{route('new_product_submit')}}" method="POST" class="form-material" enctype="multipart/form-data">
                                        @csrf
                                        <div class="container">
                                            <div class="col-12 card pt-5">
                                        
                                                <div class="form-group form-default py-4">
                                                    
                                                    <input type="text" name="product_name" class="form-control" required id="product_name">
                                                    <span class="form-bar"></span>
                                                    <label class="float-label">Product Name <span style="color: red;">*</span></label>
                                                </div>
                                                <div class="form-group form-default py-4">
                                                    
                                                    <textarea name="product_description" id="product_description" class="form-control" cols="30" rows="10"></textarea>
                                                    <span class="form-bar"></span>
                                                    <label class="float-label">Product Derscription <span style="color: red;">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-12 card py-5">
                                            <div class="card-header">
                                                <h5>General setup</h5>
                                            </div>
                                                 <div class="row">

                                                    
                                                        <div class="col-md-3 py-4">
                                                        <label class="form-label">Category <span style="color: red;">*</span></label>
                                                        <select name="category" id="category" value="select category" class="form-control">
                                                        <!-- <option value="0">Select Option</option> -->
                                                        @foreach($category_details as $category_detail)
                                                          <option value="{{$category_detail['id']}}">{{$category_detail['CategoryName']}}</option>
                                                          @endforeach
                                                        </select>
                                                        <span class="form-bar"></span>
                                                       </div>
                                                       

                                                       <div class="col-md-3 py-4">
                                                        <label class="form-label">Brand<span style="color: red;">*</span></label>
                                                        <select name="brand" id="brand" value="select brand" class="form-control">
                                                        <!-- <option value="0">Select Option</option> -->
                                                            @foreach($brand_details as $brand_detail)
                                                          <option value="{{$brand_detail['id']}}">{{$brand_detail['brand_name']}}</option>
                                                          @endforeach
                                                        </select>
                                                        <span class="form-bar"></span>
                                                       </div>
                                                       
                                                       <div class="col-md-3 py-4">
                                                        <label class="form-label">Item Code<span style="color: red;">*</span></label>
                                                        <input type="text" class="form-control" placeholder=" Item code" id="item_code" name="item_code" required>
                                                        <span class="form-bar"></span>
                                                       </div>
                                                      
                                                 </div>
                                            </div>
                                            <div class="col-12 card p-4">
                                            
                                               <div class="card-header mb-5">
                                                <h5>Pricing & Others</h5>
                                               </div>
                                               <div class="row">

                                                <div class="form-group form-default col-md-3 py-4">
                                                    
                                                    <input type="text" name="purchase_price" class="form-control" required id="purchase_price">
                                                    <span class="form-bar"></span>
                                                    <label class="float-label">Purchase Price(₹) <span style="color: red;">*</span></label>
                                                </div>
                                                <div class="form-group form-default col-md-3 py-4">
                                                    
                                                    <input type="text" name="unit_price" class="form-control" required id="unit_price">
                                                    <span class="form-bar"></span>
                                                    <label class="float-label">Unit Price(₹) <span style="color: red;">*</span></label>
                                                </div>
                                               </div>
                                            </div> 
                                       
                                        <div class="col-12 card p-5">
                                            <div class="card-header">
                                                <h5>Product Thumbnail</h5>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <input type="file" name="product_thumbnail" id="product_thumbnail" class="form-control-file" accept="assets/vendor_assets/images/*" onchange="displayImage(event)">
                                                </div>
                                                <div class="col-md-6" id="imageDisplay">
                                                   <img src="{{asset('assets/images/img2.jpg')}}" alt="product-thumbnail" style="width: 250px; height: 250px;">
                                                </div>
                                              <!--SCRIPT for img displaying-->
                                              <script>
                                                function displayImage(event) {
                                                    const fileInput = event.target;
                                                    const imageDisplay = document.getElementById('imageDisplay');
                                                    const img  =document.getElementById('profile-img');
                                                    if (fileInput.files && fileInput.files[0]) {
                                                        const reader = new FileReader();
                                                
                                                        reader.onload = function(e) {
                                                            const imageUrl = e.target.result;
                                                           
                                                           
                                                            imageDisplay.innerHTML = ''; // Clear previous image
                                                           
                                                            imageDisplay.innerHTML=<img src='${imageUrl}' alt="DP"   style="width: 250px; height: 250px;">;
                                                        };
                                                
                                                        // Read the image file as a data URL
                                                        reader.readAsDataURL(fileInput.files[0]);
                                                    }
                                                }
                                                </script>
                                                    
                                               </div>
                                            </div>
                                       </div>
                                    </div>
                                       <div class="form-group form-default col-md-12 d-flex justify-content-center align-items-end" >
                                        <input type="reset" class="btn btn-primary mx-2 " >
                                        <input type="submit"  class="btn btn-primary mx-3">
                                        
                                        
                                    </div>
                                     </form>
                                     

                                   </div>
                                    </div>
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
    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
    <div class="ie-warning">
        <h1>Warning!!</h1>
        <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
        <div class="iew-container">
            <ul class="iew-download">
                <li>
                    <a href="http://www.google.com/chrome/">
                        <img src="{{asset('assets/vendor_assets/images/browser/chrome.png')}}" alt="Chrome">
                        <div>Chrome</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.mozilla.org/en-US/firefox/new/">
                        <img src="{{asset('assets/vendor_assets/images/browser/firefox.png')}}" alt="Firefox">
                        <div>Firefox</div>
                    </a>
                </li>
                <li>
                    <a href="http://www.opera.com">
                        <img src="{{asset('assets/vendor_assets/images/browser/opera.png')}}" alt="Opera">
                        <div>Opera</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.apple.com/safari/">
                        <img src="{{asset('assets/vendor_assets/images/browser/safari.png')}}" alt="Safari">
                        <div>Safari</div>
                    </a>
                </li>
                <li>
                    <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                        <img src="{{asset('assets/vendor_assets/images/browser/ie.png')}}" alt="">
                        <div>IE (9 & above)</div>
                    </a>
                </li>
            </ul>
        </div>
        <p>Sorry for the inconvenience!</p>
    </div>
    <![endif]-->
    <!-- Warning Section Ends -->
    
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/jquery-ui/jquery-ui.min.js ')}}"></script>
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/bootstrap/js/bootstrap.min.js ')}}"></script>
    <!-- waves js -->
    <script src="{{asset('assets/vendor_assets/pages/waves/js/waves.min.js')}}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/jquery-slimscroll/jquery.slimscroll.js')}} "></script>
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
    <script type="text/javascript" src="{{asset('assets/vendor_assets/js/script.js ')}}"></script>
</body>

</html>
@endsection()