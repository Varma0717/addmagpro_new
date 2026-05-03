@extends('service_user_dashboard_layouts.master')
@section('mainsection')
          
<div class="col-12 col-xl-7">
            <div class="card rounded-0 w-100">
              <div class="card-body p-lg-5">
                  <h5 class="mb-0 fw-bold">Edit Details</h5>
                  <hr>
                   <form action="{{route('edit_user_profile_submit')}}" method="POST">
                    @csrf
                     <div class="row row-cols-1 g-3">
                      <div class="col-12 d-flex justify-content-center" id="imageDisplay">
                        <img src="{{asset('assets/user_assets/images/avatars/01.webp')}}" alt="" class="img-fluid" style="width: 250px; height: 250px; max-width: 250px;">
                      </div>
                      <div class="col-12">
                        <label>File upload</label>
                        <input type="file" name="img[]" class="file-upload-default" accept="image/*" hidden onchange="displayImage(event)" >
                        <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Profile Photo">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                          </span>
                        </div>
                        
                      </div>
                      
                        <div class="col">
                          <div class="form-floating">
                            <input type="hidden" id="user_id" name="user_id" value="{{$user_info[0]->service_id}}">
                            <input type="text" class="form-control rounded-0" id="name" name="name" placeholder="Name" value="{{$user_info[0]->member_name}}">
                            <label for="floatingInputName">Name</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                            <input type="text" class="form-control rounded-0" id="mobile" name="mobile" placeholder="Name" value="{{$user_info[0]->member_phone}}" readOnly>
                            <label for="floatingInputNumber">Mobile Number</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                            <input type="text" class="form-control rounded-0" id="location" name="location" placeholder="Location" value="{{$user_info[0]->location}}">
                            <label for="floatingInputLocation">Location</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                            @if($user_info[0]->address=='')
                                <input type="text" class="form-control rounded-0" id="address" name="address" placeholder="Bank Name" value="">  
                            @else
                                <input type="text" class="form-control rounded-0" id="address" name="address" placeholder="Bank Name" value="{{$user_info[0]->address}}" readOnly>
                            @endif
                            <label for="floatingInputLocation">Address</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                            @if($user_info[0]->city=='')
                                <input type="text" class="form-control rounded-0" id="city" name="city" placeholder="Bank Name" value="" required>  
                            @else
                                <input type="text" class="form-control rounded-0" id="city" name="city" placeholder="Bank Name" value="{{$user_info[0]->city}}" readOnly>
                            @endif
                            <label for="floatingInputLocation">City</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                            @if($user_info[0]->pincode=='')
                                <input type="text" class="form-control rounded-0" id="pincode" name="pincode" placeholder="Bank Name" value="" required>  
                            @else
                                <input type="text" class="form-control rounded-0" id="pincode" name="pincode" placeholder="Bank Name" value="{{$user_info[0]->pincode}}" readOnly>
                            @endif
                            <label for="floatingInputLocation">Pin Code</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                            @if($user_info[0]->state=='')
                                <input type="text" class="form-control rounded-0" id="state" name="state" placeholder="Bank Name" value="" required>  
                            @else
                                <input type="text" class="form-control rounded-0" id="state" name="state" placeholder="Bank Name" value="{{$user_info[0]->state}}" readOnly>
                            @endif
                            <label for="floatingInputLocation">State</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                            @if($user_bank_details->isEmpty())
                                <input type="text" class="form-control rounded-0" id="pan_number" name="pan_number" placeholder="Bank Name" value="" required>  
                            @else
                                <input type="text" class="form-control rounded-0" id="pan_number" name="pan_number" placeholder="Bank Name" value="{{$user_bank_details[0]->pancard_number}}" readOnly>
                            @endif
                            <label for="floatingInputLocation">Pan Number</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                            @if($user_bank_details->isEmpty())
                                <input type="text" class="form-control rounded-0" id="bank_name" name="bank_name" placeholder="Bank Name" value="" required>  
                            @else
                                <input type="text" class="form-control rounded-0" id="bank_name" name="bank_name" placeholder="Bank Name" value="{{$user_bank_details[0]->bank_name}}" readOnly>
                            @endif
                            <label for="floatingInputLocation">Bank Name</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                          @if($user_bank_details->isEmpty())
                                <input type="hidden" name="bank_new_enter" id="bank_new_enter" value="1">
                                <input type="text" class="form-control rounded-0" id="account_num" name="account_num" placeholder="Account Number" value="" required>  
                            @else
                              <input type="hidden" name="bank_new_enter" id="bank_new_enter" value="0">
                                <input type="text" class="form-control rounded-0" id="account_num" name="account_num" placeholder="Account Number" value="{{$user_bank_details[0]->account_number}}" readOnly>
                            @endif
                            <label for="floatingInputLocation">Account Number</label>
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-floating">
                          @if($user_bank_details->isEmpty())
                                <input type="text" class="form-control rounded-0" id="ifsc" name="ifsc" placeholder="IFSC" value="" required>  
                          @else
                            <input type="text" class="form-control rounded-0" id="ifsc" name="ifsc" placeholder="IFSC" value="{{$user_bank_details[0]->ifsc}}" readOnly>
                          @endif
                            <label for="floatingInputLocation">IFSC</label>
                          </div>
                        </div>
                        <div class="col">
                          <button type="submit" class="btn btn-dark py-3 btn-ecomm w-100">Save Details</button>
                        </div>
                        
                     </div>
                   </form>
              </div>
            </div>
          </div>
       </div><!--end row-->
    </div>
  </section>
   <!--start product details-->


   <!-- Change Password Modal -->
    <div class="modal" id="ChangePasswordModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-0">
          <div class="modal-body">
            <h5 class="fw-bold mb-3">Change Password</h5>
            <hr>
              <form>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control rounded-0" id="floatingInputOldPass" placeholder="Old Password">
                  <label for="floatingInputOldPass">Old Password</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control rounded-0" id="floatingInputNewPass" placeholder="New Password">
                  <label for="floatingInputNewPass">New Password</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control rounded-0" id="floatingInputConPass" placeholder="Confirm Password">
                  <label for="floatingInputConPass">Confirm Password</label>
                </div>
                <div class="d-grid gap-3 w-100">
                  <button type="button" class="btn btn-dark py-3 btn-ecomm">Change</button>
                  <button type="button" class="btn btn-outline-dark py-3 btn-ecomm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
    <!-- end Change Password Modal -->


 </div>

@endsection()