@extends('vendor_layouts.master')
@section('mainsection')
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Category</h5>
                                            <p class="m-b-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!"> Category Update</a>
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
                                        <h5>Category Update</h5>
                                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                    </div>
                                    <div class="card-block row">
                                        <form class="form-material col-md-6" action="{{route('vendor_category_update')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group form-default">
                                                <input type="hidden" name="category_id" id="category_id" value="{{$category_info->id}}">
                                                <input type="hidden" name="category_image" id="category_image" value="{{$category_img}}">
                                                <input type="text" name="category_name" class="form-control" required id="category_name" value="{{$category_info->CategoryName}}">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Category Name <span style="color: red;">*</span></label>
                                            </div>
                                            <div class="form-group form-default">
                                                <input type="file" id="category_image" accept="image/*" onchange="displayImage(event)" name="category_image">
                                                <div id="imageDisplay"><img src="{{asset($category_img)}}" alt="" width="150px" height="150px"></div>
                                            </div>
                                            
                                            <div class="form-group form-default col-md-12 d-flex justify-content-end align-items-end" >
                                                <input type="reset" class="btn btn-primary mx-2" >
                                                <input type="submit"  class="btn btn-primary">
                                                
                                                
                                            </div>
                                        </form>
                                        <div class="col-md-6">
                                        <div class="container" id="imageDisplay">
                                            
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                                
                            
                        </div>

                       </div>
                </div>
            </div>
                       
                        
            <script>
                function displayImage(event) {
                    const fileInput = event.target;
                    const imageDisplay = document.getElementById('imageDisplay');
                
                    if (fileInput.files && fileInput.files[0]) {
                        const reader = new FileReader();
                
                        reader.onload = function(e) {
                            const imageUrl = e.target.result;
                
                            // Create an image element
                            const imgElement = document.createElement('img');
                            imgElement.src = imageUrl;
                            imgElement.style.width = '140px';
                            imgElement.style.height = '150px';
                
                            // Display the image
                            imageDisplay.innerHTML = ''; // Clear previous image
                            imageDisplay.appendChild(imgElement);
                        };
                
                        // Read the image file as a data URL
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
                </script>    

        
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