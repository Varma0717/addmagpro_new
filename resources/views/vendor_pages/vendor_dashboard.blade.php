
@extends('vendor_layouts.master')
@section('mainsection')
          <!-- vendor nav bar -->
          
                  <div class="pcoded-content">
                      <!-- Page-header start -->
                      <div class="page-header">
                          <div class="page-block">
                              <div class="row align-items-center">
                                  <div class="col-md-8">
                                      <div class="page-header-title">
                                          <h5 class="m-b-10">Dashboard</h5>
                                          <p class="m-b-0">Welcome to Add Mag Pro</p>
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
                                        <div class="row">
                                            <!-- task, page, download counter  start -->
                                            <div class="col-xl-4 col-md-6">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <h4 class="text-c-purple">$30200</h4>
                                                                <h6 class="text-muted m-b-0">Total Sale</h6>
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <i class="fa fa-bar-chart f-28"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-c-purple">
                                                        <div class="row align-items-center">
                                                            <div class="col-9">
                                                                <p class="text-white m-b-0">% change</p>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <i class="fa fa-line-chart text-white f-16"></i>
                                                            </div>
                                                        </div>
            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <h4 class="text-c-green">{{$products_count}}</h4>
                                                                <h6 class="text-muted m-b-0">Total Products</h6>
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <i class="fa fa-file-text-o f-28"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-c-green">
                                                        <div class="row align-items-center">
                                                            <div class="col-9">
                                                                <p class="text-white m-b-0">% change</p>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <i class="fa fa-line-chart text-white f-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="row align-items-center">
                                                            <div class="col-8">
                                                                <h4 class="text-c-red">145</h4>
                                                                <h6 class="text-muted m-b-0">Total Customers</h6>
                                                            </div>
                                                            <div class="col-4 text-right">
                                                                <i class="fa fa-calendar-check-o f-28"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-c-red">
                                                        <div class="row align-items-center">
                                                            <div class="col-9">
                                                                <p class="text-white m-b-0">% change</p>
                                                            </div>
                                                            <div class="col-3 text-right">
                                                                <i class="fa fa-line-chart text-white f-16"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!--  project and team member end -->
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