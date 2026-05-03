@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Update Home Heading</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Update Home Heading </h4>
                  </div>
                    <form action="{{route('update_home_heading_submit')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                      <div class="admin-form-group">
                        <label>Heading Name</label>
                        <input type="hidden" name="gallery_id" id="gallery_id" value="{{$gallery_details[0]->id}}">
                        <select class="form-control admin-input" id="gallery_name" name="gallery_name">
                          <option value="{{$gallery_details[0]->home_page_name}}" >{{$gallery_details[0]->home_page_name}}</option>
                          
                        </select>
                      </div>
                      <div class="admin-form-group">
                        <label>Heading</label>
                       <input type="text" class="form-control admin-input" value="{{$gallery_details[0]->heading}}" id="heading_name" name="heading_name">
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