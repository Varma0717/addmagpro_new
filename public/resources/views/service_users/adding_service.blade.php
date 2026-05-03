@extends('service_layouts.master')
@section('main_content')


<!--start page content-->
<div class="page-content">


   <!--start breadcrumb-->
   <div class="py-4 border-bottom">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0"> 
          <li class="breadcrumb-item"><a href="/welcome_page">Home</a></li>
          <li class="breadcrumb-item"><a href="javascript:;">Services</a></li>
          <li class="breadcrumb-item active" aria-current="page">Busssiness </li>
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
                 <h4 class="mb-0 fw-bold text-center">Bussiness Listing </h4>
                 <hr>
                 
                 <div class="separator mb-4">
                 
                  
                </div>
                 <!-- <form action="{{route('business_service_listing')}}" method="POST" enctype="multipart/form-data"> -->
                 <form action="{{ route('razorpay') }}" method="POST" enctype="multipart/form-data" id="payment-form">
    @csrf
    <div class="row g-3">
        <div class="col-12 col-md-6">
            <label>File upload</label>
            <input type="hidden" id="service_user_id" name="service_user_id" value="{{ $user_details[0]->service_id }}">
            <input type="hidden" id="cumulative_gross" name="cumulative_gross" value="{{ $user_details[0]->cumulative_gross }}">
            <input type="hidden" id="commission_percentage" name="commission_percentage" value="{{ $user_details[0]->commission_percentage }}">
            <input type="hidden" id="referral_id" name="referral_id" value="{{ $user_details[0]->referral_id }}">
            <input type="hidden" id="referral_by" name="referral_by" value="{{ $user_details[0]->referral_by }}">
            <input type="file" name="service_image" id="service_image" class="file-upload-default" accept="image/*" hidden onchange="displayImage(event)" required>
            <div class="input-group col-xs-12">
                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Profile Photo">
                <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button" onclick="document.getElementById('service_image').click();">Upload</button>
                </span>
            </div>
        </div>
        <div class="col-12 col-md-6 end" id="imageDisplay">
            <img src="{{ asset('assets/images/img2.jpg') }}" alt="" class="img-fluid" style="width: 250px; height: 250px; max-width: 250px;">
        </div>
        <div class="col-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control rounded-0" id="name" name="name" value="{{ $user_details[0]->member_name }}" readonly>
        </div>
        <div class="col-6">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="text" class="form-control rounded-0" id="mobile" name="mobile" value="{{ $user_details[0]->member_phone }}" readonly>
            <input type="hidden" id="password" name="password" value="{{ $user_details[0]->password }}">
            <input type="hidden" id="business_type" name="business_type" value="{{ $business_type }}">
        </div>
        <div class="col-6">
            <label for="pannumber" class="form-label">PAN No</label>
            <input type="text" class="form-control rounded-0" id="pannumber" name="pannumber" required>
        </div>
        <div class="col-6">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control rounded-0" id="address" name="address" value="{{ $user_details[0]->location }}" readonly>
        </div>
        <!--<div class="col-md-4 col-12">-->
        <!--    <label for="state" class="form-label">State</label>-->
        <!--    <select name="state" id="state" class="form-control rounded-0" required>-->
        <!--        <option value="">Select Your State</option>-->
        <!--        <option value="Andhra Pradesh">Andhra Pradesh</option>-->
        <!--        <option value="Telangana">Telangana</option>-->
        <!--    </select>-->
        <!--</div>-->
        <div class="col-md-4 col-12">
          <label for="state" class="form-label">State</label>
          <select id="state" name="state" class="form-control rounded-0" onchange="updateDistricts()" required>
              <option value="">Select State</option>
              @foreach($states as $state)
                  <option value="{{ $state->state_id }}">{{ $state->state_name }}</option>
              @endforeach
          </select>
        </div>
        <div class="col-md-4 col-12">
            <label for="district" class="form-label">District</label>
            <select name="district" id="district" class="form-control rounded-0" required>
                <option value="">Select Your District</option>
                <!--<option value="Adilabad">Adilabad</option>-->
                <!--<option value="Annamayya">Annamayya</option>-->
                <!--<option value="Anakapalli">Anakapalli</option>-->
                <!--<option value="Anantapur">Anantapur</option>-->
                <!--<option value="Alluri Sitharama Raju">Alluri Sitharama Raju</option>-->
                <!--<option value="Bhadradri Kothagudem">Bhadradri Kothagudem</option>-->
                <!--<option value="Bapatla">Bapatla</option>-->
                <!--<option value="Chittoor">Chittoor</option>-->
                <!--<option value="East Godavari (Kakinada)">East Godavari (Kakinada)</option>-->
                <!--<option value="Eluru">Eluru</option>-->
                <!--<option value="Guntur">Guntur</option>-->
                <!--<option value="Hyderabad">Hyderabad</option>-->
                <!--<option value="Jagtial">Jagtial</option>-->
                <!--<option value="Jangaon">Jangaon</option>-->
                <!--<option value="Jayashankar Bhupalpally">Jayashankar Bhupalpally</option>-->
                <!--<option value="Jogulamba Gadwal">Jogulamba Gadwal</option>-->
                <!--<option value="Kadapa (YSR Kadapa)">Kadapa (YSR Kadapa)</option>-->
                <!--<option value="Kamareddy">Kamareddy</option>-->
                <!--<option value="Karimnagar">Karimnagar</option>-->
                <!--<option value="Khammam">Khammam</option>-->
                <!--<option value="Konaseema">Konaseema</option>-->
                <!--<option value="Kumuram Bheem Asifabad">Kumuram Bheem Asifabad</option>-->
                <!--<option value="Krishna (Machilipatnam)">Krishna (Machilipatnam)</option>-->
                <!--<option value="Kurnool">Kurnool</option>-->
                <!--<option value="Mahabubabad">Mahabubabad</option>-->
                <!--<option value="Mahabubnagar">Mahabubnagar</option>-->
                <!--<option value="Mancherial">Mancherial</option>-->
                <!--<option value="Medak">Medak</option>-->
                <!--<option value="Medchal–Malkajgiri">Medchal–Malkajgiri</option>-->
                <!--<option value="Mulugu">Mulugu</option>-->
                <!--<option value="Nandyal">Nandyal</option>-->
                <!--<option value="Nagarkurnool">Nagarkurnool</option>-->
                <!--<option value="Nalgonda">Nalgonda</option>-->
                <!--<option value="NTR (Vijayawada)">NTR (Vijayawada)</option>-->
                <!--<option value="Narayanpet">Narayanpet</option>-->
                <!--<option value="Sri Potti Sriramulu Nellore (Nellore)">Sri Potti Sriramulu Nellore (Nellore)</option>-->
                <!--<option value="Nirmal">Nirmal</option>-->
                <!--<option value="Nizamabad">Nizamabad</option>-->
                <!--<option value="Palnadu">Palnadu</option>-->
                <!--<option value="Parvathipuram Manyam">Parvathipuram Manyam</option>-->
                <!--<option value="Peddapalli">Peddapalli</option>-->
                <!--<option value="Prakasam (Ongole)">Prakasam (Ongole)</option>-->
                <!--<option value="Rajanna Sircilla">Rajanna Sircilla</option>-->
                <!--<option value="Rangareddy">Rangareddy</option>-->
                <!--<option value="Sangareddy">Sangareddy</option>-->
                <!--<option value="Sri Sathya Sai">Sri Sathya Sai</option>-->
                <!--<option value="Siddipet">Siddipet</option>-->
                <!--<option value="Srikakulam">Srikakulam</option>-->
                <!--<option value="Suryapet">Suryapet</option>-->
                <!--<option value="Tirupati">Tirupati</option>-->
                <!--<option value="Vikarabad">Vikarabad</option>-->
                <!--<option value="Visakhapatnam">Visakhapatnam</option>-->
                <!--<option value="Vizianagaram">Vizianagaram</option>-->
                <!--<option value="Wanaparthy">Wanaparthy</option>-->
                <!--<option value="West Godavari (Eluru)">West Godavari (Eluru)</option>-->
                <!--<option value="Warangal (Rural)">Warangal (Rural)</option>-->
                <!--<option value="Warangal (Urban)">Warangal (Urban)</option>-->
                <!--<option value="Yadadri Bhuvanagiri">Yadadri Bhuvanagiri</option>-->
                <!--<option value="Kakinada">Kakinada</option>-->

                <!-- Add all district options here -->
            </select>
        </div>
                <div class="col-12 col-md-4">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control rounded-0" id="location" name="location" required>
        </div>
        <div class="col-12 col-md-4">
            <label for="pincode" class="form-label">Pincode</label>
            <input type="text" class="form-control rounded-0" id="pincode" name="pincode" required>
        </div>
        <div class="col-12 col-md-8">
            <label for="profession" class="form-label">Select Your Profession</label>
            <select name="profession" id="profession" class="form-control rounded-0" required>
                <option value="1">Select Your Profession</option>
                @foreach($services_details as $services_detail)
                <option value="{{ $services_detail['service_id'] }}">{{ $services_detail['service_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <label for="bankname" class="form-label">Bank Name</label>
                <input type="text" class="form-control rounded-0" id="bankname" name="bankname" required>
            </div>
            <div class="col-12 col-md-4">
                <label for="accountnumber" class="form-label">Account Number</label>
                <input type="text" class="form-control rounded-0" id="accountnumber" name="accountnumber" required>
            </div>
            <div class="col-12 col-md-4">
                <label for="ifsccode" class="form-label">IFSC Code</label>
                <input type="text" class="form-control rounded-0" id="ifsccode" name="ifsccode" required>
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Add Description</label>
                <input type="text" class="form-control rounded-0" id="description" name="description" required>
            </div>
        </div>
        
        <div class="col-12">
            <hr class="my-0">
        </div>
        <div class="col-12">
            <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id">
            <button type="button" class="btn btn-dark rounded-0 btn-ecomm w-100" id="razorpay-button">Pay( 1050 ) </button>
        </div>
    </div>
</form>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
        const districtsData = @json($districts);

        function updateDistricts() {
            const stateId = document.getElementById('state').value;
            const districtSelect = document.getElementById('district');

            // Clear current options
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (stateId) {
                // Filter districts based on selected state
                const filteredDistricts = districtsData.filter(district => district.state_id == stateId);

                // Populate districts dropdown
                filteredDistricts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.district_id;
                    option.textContent = district.district_name;
                    districtSelect.appendChild(option);
                });
            }
        }
    </script>
<script>
    document.getElementById('razorpay-button').onclick = function(e) {
        e.preventDefault();
        if (document.getElementById('pannumber').value && document.getElementById('pincode').value && document.getElementById('service_image').value && document.getElementById('bankname').value && document.getElementById('accountnumber').value && document.getElementById('ifsccode').value && document.getElementById('description').value) {
            var options = {
                "key": "{{ config('services.razorpay.key') }}",
                "amount": 100, // Amount is in paise
                "currency": "INR",
                "name": "Koochana Publications Pvt. Ltd.",
                "description": "Payment for Service",
                "image": "https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/razorpay-icon.png",
                "handler": function(response) {
                    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                    document.getElementById('payment-form').submit();
                },
                "prefill": {
                    "name": "Koochana Publications Pvt. Ltd.",
                    "email": "addmagpro@gmail.com",
                    "contact": "7702381784"
                },
                "notes": {
                    "customer_name": "Koochana Publications Pvt. Ltd.",
                    "customer_email": "addmagpro@gmail.com",
                    "product_name": "Service",
                    "quantity": "1"
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        } else {
            alert("Please fill all required fields.");
        }
    }
</script>

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
  <section class="footer-section bg-section-2 section-padding">
    <div class="container">
       <div class="row row-cols-1 row-cols-lg-4 g-4">
        <div class="col">
          <div class="footer-widget-6">
            <img src="{{asset('assets/user_assets/images/logo.webp')}}" class="logo-img mb-3" alt="">
            <h5 class="mb-3 fw-bold">About Us</h5>
             <p class="mb-2">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>

             <a class="link-dark" href="javascript:;">Read More</a>
          </div>
        </div>
        <div class="col">
          <div class="footer-widget-7">
            <h5 class="mb-3 fw-bold">Explore</h5>
             <ul class="widget-link list-unstyled">
               <li><a href="javascript:;">Fashion</a></li>
               <li><a href="javascript:;">Women</a></li>
               <li><a href="javascript:;">Furniture</a></li>
               <li><a href="javascript:;">Shoes</a></li>
               <li><a href="javascript:;">Topwear</a></li>
               <li><a href="javascript:;">Brands</a></li>
               <li><a href="javascript:;">Kids</a></li>
             </ul>
          </div>
        </div>
        <div class="col">
          <div class="footer-widget-8">
            <h5 class="mb-3 fw-bold">Company</h5>
             <ul class="widget-link list-unstyled">
               <li><a href="javascript:;">About Us</a></li>
               <li><a href="javascript:;">Contact Us</a></li>
               <li><a href="javascript:;">FAQ</a></li>
               <li><a href="javascript:;">Privacy</a></li>
               <li><a href="javascript:;">Terms</a></li>
               <li><a href="javascript:;">Complaints</a></li>
             </ul>
          </div>
        </div>
        <div class="col">
          <div class="footer-widget-9">
            <h5 class="mb-3 fw-bold">Follow Us</h5>
             <div class="social-link d-flex align-items-center gap-2">
               <a href="javascript:;"><i class="bi bi-facebook"></i></a>
               <a href="javascript:;"><i class="bi bi-twitter"></i></a>
               <a href="javascript:;"><i class="bi bi-linkedin"></i></a>
               <a href="javascript:;"><i class="bi bi-youtube"></i></a>
               <a href="javascript:;"><i class="bi bi-instagram"></i></a>
             </div>
             <div class="mb-4 mt-4">
              <h5 class="mb-0 fw-bold">Support</h5>
              <p class="mb-0 text-muted">support@example.com</p>
             </div>
             <div class="">
              <h5 class="mb-0 fw-bold">Toll Free</h5>
              <p class="mb-0 text-muted">1800- 8xx 2xx</p>
             </div>
          </div>
        </div>
       </div><!--end row-->
       <div class="my-5"></div>
       <div class="row">
         <div class="col-12">
           <div class="text-center">
            <h5 class="fw-bold mb-3">Download Mobile App</h5>
           </div>
          <div class="app-icon d-flex flex-column flex-sm-row align-items-center justify-content-center gap-2">
            <div>
              <a href="javascript:;">
                <img src="{{asset('assets/user_assets/images/play-store.webp')}}" width="160" alt="">
              </a>
            </div>
            <div>
              <a href="javascript:;">
                <img src="{{asset('assets/user_assets/images/apple-store.webp')}}" width="160" alt="">
              </a>
            </div>
          </div>
         </div>
       </div><!--end row-->

    </div>
  </section>
  <!--end footer-->

  <footer class="footer-strip text-center py-3 bg-section-2 border-top positon-absolute bottom-0">
    <p class="mb-0 text-muted">© 2022. www.example.com | All rights reserved.</p>
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