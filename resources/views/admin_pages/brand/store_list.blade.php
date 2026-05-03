@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Store List</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Store List</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                          <thead>
                            <tr>
                            <th>#</th>
                            <th>Store Name</th>
                            <th>Store Image</th>
                            <th>Update Service</th>
                            <th>Delete Service</th>
                        </tr>
                          </thead>
                          <tbody>
                        @forelse($stores as $index=>$store)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$store->StoreName}}</td>
                          <td><img src="{{$store->store_image}}" width="70px" height="70px" alt="category image" class="img-radius img-80 align-top m-r-15"></td>
                          <td><a a href="{{route('store_update_admin_get',['store_id'=>$store->StoreID])}}" class="status-badge badge-theme">Update</a>
                          </td>
                          <td><a href="{{route('store_delete_admin_get',['store_id'=>$store->StoreID])}}" class="status-badge badge-rejected">Delete Status</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">
                  {{ $stores->links() }}
                </div>
                </div>
              </div>
              
            </div>
          </div>
        </section>
      </div>
@endsection