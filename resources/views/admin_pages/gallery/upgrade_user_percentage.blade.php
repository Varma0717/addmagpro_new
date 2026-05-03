@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Update User Level</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Update User Level</h4>
                  </div>
                    <form action="{{route('upgrade_user_percentage_submit')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                      <div class="admin-form-group">
                        <label for="service_user_id">User Name</label>
                        <input type="hidden" name="service_user_id" id="service_user_id" value="{{$user_details[0]->service_id}}">
                        <select class="form-control admin-input" id="user_name" name="user_name">
                          <option value="{{$user_details[0]->member_name}}" >{{$user_details[0]->member_name}}</option>
                          
                        </select>
                      </div>
                      <div class="admin-form-group">
                        <label>Percentage Level</label>
                        <input type="text" class="form-control inputtags" name="percentage_level" id="percentage_level" value="{{$user_details[0]->commission_percentage}}" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Cumulative Gross</label>
                        <input type="text" class="form-control inputtags" name="cumulative_gross" id="cumulative_gross" value="{{$user_details[0]->cumulative_gross}}" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Back 2 Back Value</label>
                        <input type="text" class="form-control inputtags" name="back_two_back_value" id="back_two_back_value" value="{{$user_details[0]->back_two_back_balance}}" required>
                    </div>
                    <div class="admin-form-group">
                        <label>User Commission</label>
                        <input type="text" class="form-control inputtags" name="user_commission" id="user_commission" value="{{$user_comission}}" required>
                    </div>
                    <div class="card-footer admin-card-footer d-flex justify-content-end">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    </div>
                    </form>
                  </div>
                  
                </div>
                
               
              </div>
            </div>
            <div class="row">
              <div class="container">
                

              <div id="imageDisplay"></div>

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
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection