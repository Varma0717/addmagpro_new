@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Add Store Image</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Add Store Image</h4>
                  </div>
                    <form action="{{route('new_store_image_added')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                      <!-- <div class="admin-form-group">
                        <label>Banner Name</label>
                        <input type="text" class="form-control admin-input" name="banner_name" id="banner_name" required>
                      </div> -->
                      <div class="admin-form-group">
                        <label>Gallery Name</label>
                        <select class="form-control admin-input" id="gallery_name" name="gallery_name">
                          <option value="store1">Store Image1</option>
                          <option value="store2">Store Image2</option>
                          <option value="store3">Store Image3</option>
                          <option value="store4">Store Image4</option>
                          <option value="store5">Store Image5</option>
                          <option value="store6">Store Image6</option>
                          <option value="store7">Store Image7</option>
                          <option value="store8">Store Image8</option>
                          <option value="store9">Store Image9</option>
                          <option value="store10">Store Image10</option>
                          <option value="storemini1">Store mini image1</option>
                          <option value="storemini2">Store mini image2</option>
                          <option value="storemini3">Store mini image3</option>
                          <option value="storemini4">Store mini image4</option>
                        </select>
                      </div>
                      <div class="admin-form-group">
                        <label>Gallery Image</label>
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