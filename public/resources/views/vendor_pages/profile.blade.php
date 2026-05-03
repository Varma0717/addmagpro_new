@extends('vendor_layouts.master')
@section('mainsection')
                  <div class="pcoded-content">
                      <!-- Page-header start -->
                      <div class="page-header">
                          <div class="page-block">
                              <div class="row align-items-center">
                                  <div class="col-md-8">
                                      <div class="page-header-title">
                                          <h5 class="m-b-10">Vendor Profile</h5>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <ul class="breadcrumb-title">
                                          <li class="breadcrumb-item">
                                              <a href="index.html"> <i class="fa fa-home"></i> </a>
                                          </li>
                                          <li class="breadcrumb-item"><a href="{{route('vendor_dashboard')}}">Dashboard</a>
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
                                    <div class="page-body">
                                        <div class="container mb-5">
                                            <div class="d-flex justify-content-center mt-5 col-md-12">
                                                <img src="{{$vendor_details['profile_image']}}" alt="DP" style="border-radius: 40%; max-width: 150px; width: 150px;">
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="card">
                                          <div class="card-header">
                                            <h5>Profile Information</h5>
                                          </div>
                                          <div class="container">
                                       <div class="row p-4">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <h5 class="mb-4 col-6">Vendor name</h5> 
                                                <h5 class="col-6">: {{$vendor_details['vendor_name']}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <h5 class="mb-4 col-6">phone number</h5> 
                                                <h5 class="mb-4 col-6">:   {{$vendor_details['vendor_phone']}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <h5 class="mb-4 col-6">Email</h5> 
                                                <h5 class="mb-4 col-6">:   {{$vendor_details['vendor_email']}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <h5 class="mb-4 col-6">Bussiness Name</h5> 
                                                <h5 class="mb-4 col-6">:   {{$vendor_details['business_name']}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <h5 class="mb-4 col-6">Bussiness Type</h5> 
                                                <h5 class="mb-4 col-6">:   {{$vendor_details['business_type']}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <h5 class="mb-4 col-6">Address</h5> 
                                                <h5 class="mb-4 col-6">: {{$vendor_details['business_address']}}</h5>
                                            </div>
                                        </div>
                                        
                                       </div>
                                       <div class="d-flex justify-content-center mb-5">
                                        <a href="{{route('vendor_settings')}}" class="btn btn-primary">Edit Profile</a>
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
</body>

</html>
@endsection()