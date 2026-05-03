@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Category List</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Category List</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                          <thead>
                            <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Category Image</th>
                            <th>Update Category</th>
                            <th>Delete Category</th>
                        </tr>
                          </thead>
                          <tbody>
                        @forelse($category_details as $index=>$category_detail)
                        <tr>
                          <td>1</td>
                          <td>{{$category_detail->CategoryName}}</td>
                          <td><img src="{{$category_detail->ImageURL}}" width="70px" height="70px" alt="category image" class="img-radius img-80 align-top m-r-15"></td>
                          <td><a href="{{route('category_update_admin',['category_id'=>$category_detail->id])}}" class="status-badge badge-theme">Update</a>
                          </td>
                          <td><a class="status-badge badge-rejected">Delete Status</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </section>
      </div>
@endsection