@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Classified List</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Classified List</h4>
                    <!-- <button>Add Service</button> -->
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                          <thead>
                            <tr>
                            <th>#</th>
                            <th>Classified Name</th>
                            <th>Classified Image</th>
                            <th>Update Classified</th>
                            <th>Delete Classified</th>
                        </tr>
                          </thead>
                          <tbody>
                        @forelse($services as $index=>$service)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$service->classified_name}}</td>
                          <td><img src="{{$service->classified_image}}" width="70px" height="70px" alt="category image" class="img-radius img-80 align-top m-r-15"></td>
                          <td><a href="{{route('classified_update_admin_get',['service_id'=>$service->id])}}" class="status-badge badge-theme">Update</a>
                          </td>
                          <td><a href="{{route('classified_delete_admin_get',['service_id'=>$service->id])}}" class="status-badge badge-rejected">Delete Status</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">
                  {{ $services->links() }}
                </div>
                </div>
              </div>
              
            </div>
          </div>
        </section>
      </div>
@endsection