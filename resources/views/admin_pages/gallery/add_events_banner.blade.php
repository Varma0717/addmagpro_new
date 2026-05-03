@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Add Events Banner Image</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Add Events Banner Image</h4>
                  </div>
                    <form action="{{route('new_eventsbanner_image_added')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                      <!-- <div class="admin-form-group">
                        <label>Banner Name</label>
                        <input type="text" class="form-control admin-input" name="banner_name" id="banner_name" required>
                      </div> -->
                      <div class="admin-form-group">
                        <label>Events Banner Name</label>
                        <select class="form-control admin-input" id="gallery_name" name="gallery_name">
                          <option value="Eventsbanner1">Events BannerImage1</option>
                          <option value="Eventsbanner2">Events BannerImage2</option>
                          <option value="Eventsbanner3">Events BannerImage3</option>
                          <option value="Eventsbanner4">Events BannerImage4</option>
                          <option value="Eventsbanner5">Events BannerImage5</option>
                          <option value="Eventsbanner6">Events BannerImage6</option>
                          <option value="Eventsbanner7">Events BannerImage7</option>
                          <option value="Eventsbanner8">Events BannerImage8</option>
                          <option value="Eventsbanner9">Events BannerImage9</option>
                          <option value="Eventsbanner10">Events BannerImage10</option>
                        </select>
                      </div>
                      <div class="admin-form-group">
                        <label>Banner Image</label>
                        <input type="file" id="gallery_image" name="gallery_image" accept="image/*" onchange="displayImage(event)" required>
                        <div id="imageDisplay"><img src="assets/images/img2.jpg" alt="DP"   style="width: 200px; height: 200px;"></div>
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