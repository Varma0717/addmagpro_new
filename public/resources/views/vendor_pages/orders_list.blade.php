@extends('vendor_layouts.master')
@section('mainsection')
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Orders List</h5>
                                            <p class="m-b-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="{{route('vendor_category_list')}}">Category List</a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page-header end -->
                       <div class="container">
                        <div class="row">
                            <div class="col-md-12 mt-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h5> Orders List</h5>
                                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th> Order ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Product Name</th>
                                                    <th>Amount</th>
                                                    <th>Order Date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>01</td>
                                                    <td>
                                                        
                                                        1233
                                                    </td>
                                                    <td>Suresh</td>
                                                    <td>Lenovo Laptop</td>
                                                    <td>54,000</td>
                                                    <td>
                                                        <h6>12/12/2024</h6>
                                                    </td>
                                                </tr>
                                                
                                                
                                                </tbody>
                                            </table>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                       </div>
                </div>
            </div>
                       
                        


                          
                            
<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers
        to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/vendor_assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/vendor_assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/vendor_assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/vendor_assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/vendor_assets/images/browser/ie.png" alt="">
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
<script type="text/javascript" src="{{asset('assets/vendor_assets/js/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/vendor_assets/js/popper.js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/vendor_assets/js/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{asset('assets/vendor_assets/js/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<!-- waves js -->
<script src="{{asset('assets/vendor_assets/pages/waves/js/waves.min.js')}}"></script>

<!-- modernizr js -->
<script type="text/javascript" src="{{asset('assets/vendor_assets/js/SmoothScroll.js')}}"></script>
<script src="{{asset('assets/vendor_assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Custom js -->
<script src="{{asset('assets/vendor_assets/js/pcoded.min.js')}}"></script>
<script src="{{asset('assets/vendor_assets/js/vertical-layout.min.js')}}"></script>
<script src="{{asset('assets/vendor_assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/vendor_assets/js/script.js')}}"></script>
</body>

</html>
@endsection()