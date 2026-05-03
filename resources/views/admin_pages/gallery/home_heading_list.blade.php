@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Ads Banner List</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Ads Banner List</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                          <thead>
                            <tr>
                            <th>#</th>
                            <th>Ads Image Name</th>
                            <th>Ads Banner Image</th>
                            <th>Update Gallery</th>
                            <!-- <th>Delete Banner</th> -->
                        </tr>
                          </thead>
                          <tbody>
                        @forelse($ads_banner as $index=>$gallery_detail)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$gallery_detail->home_page_name}}</td>
                          <td>{{$gallery_detail->heading}}</td>
                          <!-- <td><img src="{{$gallery_detail->ads_banner_image}}" width="70px" height="70px" alt="ads image" class="img-radius img-80 align-top m-r-15"></td> -->
                          <td><a href="{{route('update_heading_name',['heading_id'=>$gallery_detail->id])}}" class="status-badge badge-theme">Update</a>
                          </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">
                  {{ $ads_banner->links() }}
                </div>
                </div>
              </div>
              
            </div>
          </div>
        </section>
      </div>
@endsection