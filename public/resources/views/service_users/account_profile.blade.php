@extends('service_user_dashboard_layouts.master')
@section('mainsection')
          
          <div class="col-12 col-xl-9">
            <div class="col-12 col-md-12">
              <div class="container">
               <div class="profile-img-wrapper">
                     <img src="{{asset('assets/user_assets/images/avatars/01.webp')}}" alt="">
               </div>
              </div>
             </div>
            <div class="card rounded-0">
              <div class="card-body p-lg-2">
                  <h5 class="mb-0 fw-bold">Profile Details</h5>
                  <hr>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <td>Full Name</td>
                          <td>{{$user_info[0]->member_name}}</td>
                        </tr>
                        <tr>
                          <td>Mobile Number</td>
                          <td>{{$user_info[0]->member_phone}}</td>
                        </tr>
                        <tr>
                          <td>Location</td>
                          <td>{{$user_info[0]->location}}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            @if($user_info[0]->address=='')
                                <td>Fill up Details</td>
                            @else
                                <td>{{ $user_info[0]->address }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td>City</td>
                            @if($user_info[0]->city=='')
                                <td>Fill up Details</td>
                            @else
                                <td>{{ $user_info[0]->city }}</td>
                            @endif
                        </tr>
                        <tr>
                        <tr>
                            <td>Pin Code</td>
                            @if($user_info[0]->pincode=='')
                                <td>Fill up Details</td>
                            @else
                                <td>{{ $user_info[0]->pincode }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td>State</td>
                            @if($user_info[0]->state=='')
                                <td>Fill up Details</td>
                            @else
                                <td>{{ $user_info[0]->state }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td>Pan Number</td>
                            @if($user_bank_details->isEmpty())
                                <td>Fill up Details</td>
                            @else
                                <td>{{ $user_bank_details[0]->pancard_number }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td>Bank Name</td>
                            @if($user_bank_details->isEmpty())
                                <td>Fill up Details</td>
                            @else
                                <td>{{ $user_bank_details[0]->bank_name }}</td>
                            @endif
                        </tr>

                        <tr>
                          <td>Account Number</td>
                          @if($user_bank_details->isEmpty())
                                <td>Fill up Details</td>
                          @else
                                <td>{{$user_bank_details[0]->account_number}}</td>
                          @endif
                        </tr>
                      </tbody>
                      <tr>
                        <td>IFSC</td>
                        @if($user_bank_details->isEmpty())
                                <td>Fill up Details</td>
                        @else
                          <td>{{$user_bank_details[0]->ifsc}}</td>
                        @endif
                      </tr>
                    </table>
                  </div>
                  <div class="d-flex justify-content-center">
                      <a href="{{route('edit_user_profile')}}" type="button" class="btn btn-outline-dark btn-ecomm px-5"><i class="bi bi-pencil me-2"></i>Edit</a>
                  </div>
              </div>
            </div>
          </div>
       </div><!--end row-->
    </div>
  </section>
   <!--start product details-->


   <!-- filter Modal -->
    <div class="modal" id="FilterOrders" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-0">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Filter Orders</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <h6 class="mb-3 fw-bold">Status</h6>
              <div class="status-radio d-flex flex-column gap-2">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                  <label class="form-check-label" for="flexRadioDefault1">
                    All 
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                  <label class="form-check-label" for="flexRadioDefault2">
                    On the way
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                  <label class="form-check-label" for="flexRadioDefault3">
                    Delivered
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4">
                  <label class="form-check-label" for="flexRadioDefault4">
                    Cancelled
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault5">
                  <label class="form-check-label" for="flexRadioDefault5">
                    Returned
                  </label>
                </div>
              </div>
              <hr>
              <h6 class="mb-3 fw-bold">Time</h6>
              <div class="status-radio d-flex flex-column gap-2">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioTime" id="flexRadioDefault6" checked>
                  <label class="form-check-label" for="flexRadioDefault6">
                    Anytime 
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioTime" id="flexRadioDefault7">
                  <label class="form-check-label" for="flexRadioDefault7">
                    Last 30 days
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioTime" id="flexRadioDefault8">
                  <label class="form-check-label" for="flexRadioDefault8">
                    Last 6 months
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioTime" id="flexRadioDefault9">
                  <label class="form-check-label" for="flexRadioDefault9">
                    Last year
                  </label>
                </div>
              </div>

          </div>
          <div class="modal-footer">
            <div class="d-flex align-items-center gap-3 w-100">
              <button type="button" class="btn btn-outline-dark btn-ecomm w-50">Clear Filters</button>
              <button type="button" class="btn btn-dark btn-ecomm w-50">Apply</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end Filters Modal -->


 </div>
  <!--end page content-->

@endsection()