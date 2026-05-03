@extends('vendor_layouts.master')
@section('mainsection')
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Products List</h5>
                                            <p class="m-b-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!">Category List</a>
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
                                        <h5>Products List</h5>
                                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Product Image</th>
                                                    <th> Product Name</th>
                                                    <th>Item Code</th>
                                                    
                                                    <th class="">Unit Price</th>
                                                    <th class="">Purchase Price</th>
                                                    <!-- <th>Selling Price</th> -->
                                                    <th>Actions</th>
                                    
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($product_list as $index=>$product_list)
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <!-- <td><img src="{{$product_list->product_images}}" alt="Img Not Found" width="50px" height="50px"></td> -->
                                                    <td><img src="{{$product_list->product_images}}" alt="Rounded Image" style="border-radius: 50%; width: 50px; height: 50px;"></td>
                                                    <td>{{$product_list->product_name}} </td>
                                                    <td>{{$product_list->item_code}}</td>
                                                    <td>{{$product_list->unit_price}}</td>
                                                    <td>{{$product_list->purchase_price}}</td>
                                                    <td>
                                                        <a href="{{route('product_update',['product_id'=>$product_list->product_id])}}" class="pcoded-micon m-2" style="cursor: pointer; "><i class="ti-pencil" style="color: rgb(255, 145, 0); font-size: 20px;"></i></a>
                                                        <a href="{{route('product_delete',['product_id'=>$product_list->product_id])}}" class="pcoded-micon m-2" style="cursor: pointer;"><i class="ti-trash" style="color: red; font-size: 20px;"></i></a>    
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