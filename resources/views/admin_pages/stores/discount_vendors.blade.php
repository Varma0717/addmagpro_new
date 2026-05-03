@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Discount Stores</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Discount Stores</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                          <thead>
                            <tr>
                            <th>#</th>
                            <th>Member Name</th>
                            <th>Store Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>GST Number</th>
                            <th>Store Description</th>
                            <th>Discount Margin</th>
                            <th>Registered Date</th>
                        </tr>
                          </thead>
                          <tbody>
                        @forelse($discount_vendors as $index=>$approved_stores)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$approved_stores->member_name}}</td>
                          <td>{{$approved_stores->shop_name}}</td>
                          <td>{{$approved_stores->member_phone}}</td>
                          <td>{{$approved_stores->address}}</td>
                          <td>{{$approved_stores->gst_number}}</td>
                          <td>{{$approved_stores->shop_description}}</td>
                          <td>{{$approved_stores->discount_margin}}</td>
                          <td>{{ (new DateTime($approved_stores->created_at))->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">
                  {{ $discount_vendors->links() }}
                </div>
                </div>
              </div>
              
            </div>
          </div>
        </section>
      </div>
@endsection