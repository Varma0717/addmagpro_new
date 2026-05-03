@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Products Ordered Status</h2>
        </div>
      </div>
            <div class="row">
                <div class="col-12">
                  <div class="card admin-card">
                    <div class="card-header admin-card-header">
                      <h4>Products Ordered Status</h4>
                    </div>
                    <div class="card-body admin-card-body p-0">
                      <div class="table-responsive">
                        <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>phone Number</th>
                              <th>Address</th>
                              <th>City</th>
                              <th>Ordered Products</th>
                              <th>Ordered Date</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                          @forelse($ordered_products as $ordered_product)
                                <tr>
                                    <td>{{$ordered_product->first_name}}</td>
                                    <td>{{$ordered_product->mobile_no}}</td>
                                    <td>{{$ordered_product->address}}</td>
                                    <td>{{$ordered_product->city}}</td>
                                    <td>
                                        <ul>
                                            @forelse(json_decode($ordered_product->oredered_products) as $product)
                                                <li>{{$product->product_name}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{\Carbon\Carbon::parse($ordered_product->ordered_date)->format('d/m/Y')}}</td>
                                    <td>
                                        <div class="status-badge badge-approved">{{$ordered_product->status}}</div>
                                    </td>
                                </tr>
                            @endforeach
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </section>
      </div>
@endsection