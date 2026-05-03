@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Update Service</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Update Service</h4>
                  </div>
                  <form class="form-material col-md-6" action="{{route('service_update_admin')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group form-default">
                            <input type="hidden" name="service_id" id="service_id" value="{{$service_info->service_id}}">
                            <input type="hidden" name="service_image" id="service_image" value="{{$service_img}}">
                            <input type="text" name="service_name" class="form-control admin-input" required id="service_name" value="{{$service_info->service_name}}">
                            <span class="form-bar"></span>
                            <label class="float-label">Service Name <span style="color: red;">*</span></label>
                        </div>
                        <div class="form-group form-default">
                            <input type="file" id="service_image" accept="image/*" onchange="displayImage(event)" name="service_image">
                            <div id="imageDisplay"><img src="{{asset($service_img)}}" alt="" width="150px" height="150px"></div>
                        </div>

                        <div class="form-group form-default col-md-12 d-flex justify-content-end align-items-end">
                            <input type="reset" class="btn btn-primary mx-2">
                            <input type="submit" class="btn btn-primary">


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