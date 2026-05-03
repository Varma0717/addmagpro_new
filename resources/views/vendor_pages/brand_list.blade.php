@extends('vendor_layouts.master')
@section('mainsection')
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Brand List</h5>
                                            <p class="m-b-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="vendor_brand_list">Brand List</a>
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
                                        <h5>Brand List</h5>
                                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th> Brand Logo</th>
                                                    <th>Brand Name</th>
                                                   
                                                    <th class="">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($brand_details as $index=>$brand_details)
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>
                                                        
                                                        <div class="d-inline-block align-middle">
                                                            <img src="{{$brand_details->ImageURL}}" alt="user image" class="img-radius img-80 align-top m-r-15">
                                                           
                                                        </div>
                                                    </td>
                                                    <td>{{$brand_details->brand_name}}</td>
                                                    
                                                    <td>
                                                        <div class="">
                                                            <a href="{{route('vendor_brand_update',['brand_id'=>$brand_details->id])}}" class="pcoded-micon m-2" style="cursor: pointer; "><i class="ti-pencil" style="color: rgb(255, 145, 0); font-size: 20px;"></i></a>
                                                            <a href="{{route('vendor_brand_delete',['brand_id'=>$brand_details->id])}}" class="pcoded-micon m-2" style="cursor: pointer;"><i class="ti-trash" style="color: red; font-size: 20px;"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                
                                                
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