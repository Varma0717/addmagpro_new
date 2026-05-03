@extends('service_layouts.master')
@section('main_content')

<!--start page content-->
<div class="page-content">


   <!--start breadcrumb-->
   <div class="py-4 border-bottom">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0"> 
          <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:;">Shops</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Discounts</li>
        </ol>
      </nav>
    </div>
   </div>
   <!--end breadcrumb-->


   <!--start product details-->
   <section class="section-padding w-100">
    <div class="container">
      
        <div class="row">
          <div class="col-12 col-lg-12 col-xl-12 col-xxl-12  mx-auto w-100">
             <div class="card rounded-0 ">
               <div class="card-body p-4">
                 <h4 class="mb-0 fw-bold text-center">Discount Shop Listing  </h4>
                 <hr>
                 
                 <div class="separator mb-4">
                 
                  
                </div>
                 <form action="{{route('shop_registeration')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="form-group form-default">
                            <label for="category_image" class="form-label"> Banner Image</label>
                            <input type="file" id="category_image" accept="image/*" onchange="displayImage(event)"  name="category_image" required>
                            <div id="imageDisplay"><img src="{{asset('assets/images/img2.jpg')}}" alt="" width="250px" height="150px"></div>
                        </div>
                        <div class="col-6">
                            <label for="shop_name" class="form-label"> Shop Name</label>
                            <input type="tel"  class="form-control rounded-0" id="shop_name" name="shop_name" required>
                        </div>
                      <div class="col-6">
                          <label for="mobile" class="form-label">Mobile</label>
                          <input type="text" class="form-control rounded-0" id="mobile" name="mobile" value="{{$user_details[0]['member_phone']}}" readonly>
                      </div>
                      <div class="col-6">
                            <label for="owner_name" class="form-label"> Shop Owner Name</label>
                            <input type="text" class="form-control rounded-0" id="owner_name" name="owner_name" value="{{$user_details[0]['member_name']}}" readonly>
                      </div>

                      <div class="col-6">
                        <label for="gst_number" class="form-label">GST No</label>
                        <input type="tel" class="form-control rounded-0" id="gst_number" name="gst_number" required>
                      </div>
                      <div class="col-12">
                        <label for="address" class="form-label">Shop Description</label>
                        <input type="text"  class="form-control rounded-0" id="shop_description" name="shop_description" required>
                      </div>
                      <div class="col-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text"  class="form-control rounded-0" id="address" name="address" required>
                      </div>
                      <div class="col-6">
                        <label for="location" class="form-label">Location</label>
                        <input type="text"  class="form-control rounded-0" id="location" name="location" required>
                      </div>
                      <div class="col-md-4 col-12">
                        <label for="state" class="form-label">State</label>
                        
                        <select name="state" id="state" class="form-control rounded-0" required>
                          <option value="">Select Your State</option>
                          <option value="Andhra pradesh">Andhra pradesh</option>
                          <option value="Telangana">Telangana</option>
                        </select>
                      </div>
                      <div class="col-md-4 col-12">
                        <label for="district" class="form-label">District</label>
                        
                        <select name="district" id="district" class="form-control rounded-0" required>
                          <option value="">Select Your District</option>
                          <option value="Adilabad">Adilabad</option>
                          <option value="Annamayya">Annamayya</option>
                          <option value="Anakapalli">Anakapalli</option>
                          <option value="Anantapur">Anantapur</option>
                          <option value="Alluri Sitharama Raju">Alluri Sitharama Raju</option>
                          <option value="Bhadradri Kothagudem">Bhadradri Kothagudem</option>
                          <option value="Bapatla">Bapatla</option>
                          <option value="Chittoor">Chittoor</option>
                          <option value="East Godavari (Kakinada)">East Godavari (Kakinada)</option>
                          <option value="Eluru">Eluru</option>
                          <option value="Guntur">Guntur</option>
                          <option value="Hyderabad">Hyderabad</option>
                          <option value="Jagtial">Jagtial</option>
                          <option value="Jangaon">Jangaon</option>
                          <option value="Jayashankar Bhupalpally">Jayashankar Bhupalpally</option>
                          <option value="Jogulamba Gadwal">Jogulamba Gadwal</option>
                          <option value="Kadapa (YSR Kadapa)">Kadapa (YSR Kadapa)</option>
                          <option value="Kamareddy">Kamareddy</option>
                          <option value="Karimnagar">Karimnagar</option>
                          <option value="Khammam">Khammam</option>
                          <option value="Konaseema">Konaseema</option>
                          <option value="Kumuram Bheem Asifabad">Kumuram Bheem Asifabad</option>
                          <option value="Krishna (Machilipatnam)">Krishna (Machilipatnam)</option>
                          <option value="Kurnool">Kurnool</option>
                          <option value="Mahabubabad">Mahabubabad</option>
                          <option value="Mahabubnagar">Mahabubnagar</option>
                          <option value="Mancherial">Mancherial</option>
                          <option value="Medak">Medak</option>
                          <option value="Medchal–Malkajgiri">Medchal–Malkajgiri</option>
                          <option value="Mulugu">Mulugu</option>
                          <option value="Nandyal">Nandyal</option>
                          <option value="Nagarkurnool">Nagarkurnool</option>
                          <option value="Nalgonda">Nalgonda</option>
                          <option value="NTR (Vijayawada)">NTR (Vijayawada)</option>
                          <option value="Narayanpet">Narayanpet</option>
                          <option value="Sri Potti Sriramulu Nellore (Nellore)">Sri Potti Sriramulu Nellore (Nellore)</option>
                          <option value="Nirmal">Nirmal</option>
                          <option value="Nizamabad">Nizamabad</option>
                          <option value="Palnadu">Palnadu</option>
                          <option value="Parvathipuram Manyam">Parvathipuram Manyam</option>
                          <option value="Peddapalli">Peddapalli</option>
                          <option value="Prakasam (Ongole)">Prakasam (Ongole)</option>
                          <option value="Rajanna Sircilla">Rajanna Sircilla</option>
                          <option value="Rangareddy">Rangareddy</option>
                          <option value="Sangareddy">Sangareddy</option>
                          <option value="Sri Sathya Sai">Sri Sathya Sai</option>
                          <option value="Siddipet">Siddipet</option>
                          <option value="Srikakulam">Srikakulam</option>
                          <option value="Suryapet">Suryapet</option>
                          <option value="Tirupati">Tirupati</option>
                          <option value="Vikarabad">Vikarabad</option>
                          <option value="Visakhapatnam">Visakhapatnam</option>
                          <option value="Vizianagaram">Vizianagaram</option>
                          <option value="Wanaparthy">Wanaparthy</option>
                          <option value="West Godavari (Eluru)">West Godavari (Eluru)</option>
                          <option value="Warangal (Rural)">Warangal (Rural)</option>
                          <option value="Warangal (Urban)">Warangal (Urban)</option>
                          <option value="Yadadri Bhuvanagiri">Yadadri Bhuvanagiri</option>
                          <option value="Kakinada">Kakinada</option>
                        </select>
                      </div>
                      <div class="col-12 col-md-4">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="tel" class="form-control rounded-0" id="pincode" name="pincode" required>
                      
                      </div>
                      
                     <div class="row g-3">
                        <div class="col-4">
                            <label for="bankname" class="form-label">Bank Name</label>
                            <input type="text" class="form-control rounded-0" id="bankname" name="bankname"required>
                          </div>
                          <div class="col-4">
                            <label for="accountnumber" class="form-label">Account Number</label>
                           
                            <input type="text" class="form-control rounded-0" id="accountnumber" name="accountnumber" required>
                          </div>
                          <div class="col-4">
                            <label for="ifsccode" class="form-label">IFSC Code</label>
                            <input type="text" class="form-control rounded-0" id="ifsccode" name="ifsccode" required>
                          </div>
                     </div>
                     <div class="col-12">
                      <label for="margin" class="form-label">Discount Margin %</label>
                      <input type="number" class="form-control rounded-0" id="margin" name="margin" required>
                    </div>




                    
                      <div class="col-12">
                       <hr class="my-0">
                      </div>
                      <div class="col-12">
                        <button type="submit" class="btn btn-dark rounded-0 btn-ecomm w-100 ">Submit</button>
                      </div>
                      <!---end row-->
                 </form>
               </div>
             </div>
          </div>
        </div><!--end row-->
       
    </div>
  </section>
   <!--start product details-->


 </div>
  <!--end page content-->


  <!--start footer-->

  <!--end footer-->

  <footer class="footer-strip text-center py-3 bg-section-2 border-top positon-absolute bottom-0">
    <p class="mb-0 text-muted">© 2024. www.addmagpro.com | All rights reserved.</p>
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
   <script src="{{asset('assets/user_assets/js/file-upload.js')}}"></script>


</body>

</html>
@endsection()