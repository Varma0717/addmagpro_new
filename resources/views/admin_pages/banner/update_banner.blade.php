@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Update</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Update</h4>
                  </div>
                    <form action="{{route('update_banner')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                      <!-- <div class="admin-form-group">
                        <label>Banner Name</label>
                        <input type="text" class="form-control admin-input" name="banner_name" id="banner_name" required>
                      </div> -->
                      <div class="admin-form-group">
                        <label>Banner Name</label>
                        <input type="hidden" name="banner_id" id="banner_id" value="{{$banner_details[0]->banner_id}}">
                        <select class="form-control admin-input" id="banner_name" name="banner_name">
                          <option value="{{$banner_details[0]->banner_name}}" >{{$banner_details[0]->banner_name}}</option>
                          <!-- <option value="mainslider2">Main Slider2</option>
                          <option value="mainslider3">Main Slider3</option>
                          <option value="mainslider4">Main Slider4</option>
                          <option value="mainslider5">Main Slider5</option>
                          <option value="mainslider6">Main Slider6</option>
                          <option value="banner1">Banner 1</option>
                          <option value="banner2">Banner 2</option>
                          <option value="banner3">Banner 3</option>
                          <option value="banner4">Banner 4</option> -->
                        </select>
                      </div>
                      <div class="admin-form-group">
                        <label>Banner URL</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                         
                          </div>
                          <input type="text" class="form-control phone-number" id="banner_url" name="banner_url" value="{{$banner_details[0]->banner_url}}" required>
                        </div>
                      </div>
                      <div class="admin-form-group">
                        <label>Banner Image</label>
                        <input type="file" id="banner_image" name="banner_image" accept="image/*" onchange="displayImage(event)">
                        <div id="imageDisplay"><img src="{{asset($banner_details[0]->banner_image)}}" alt="DP"   style="width: 200px; height: 200px;"></div>
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