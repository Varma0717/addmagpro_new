@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Update Withdrawal Request Status</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Update Withdrawal Request Status </h4>
                  </div>
                  <form class="form-material col-md-6" action="{{route('update_user_withdrawal_status')}}" method="POST">
                        @csrf
                        <div class="form-group form-default">
                            <input type="hidden" name="request_id" id="request_id" value="{{$update_user_withdrawal_status[0]->RequestID}}">
                        </div>

                        <div class="admin-form-group">
                            <label>User Name</label>
                            <input type="text" class="form-control admin-input" id="user_name" name="user_name" value="{{$update_user_withdrawal_status[0]->user_name}}" readonly>
                        </div>

                        <div class="admin-form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control admin-input" id="profession" name="profession" value="{{$update_user_withdrawal_status[0]->Amount}}" readonly>
                        </div>

                        <div class="admin-form-group">
                      <label>Status Update</label>
                      <select class="form-control admin-input" id="status" name="status">
                        <option value="1">Approved</option>
                        <option value="0">Rejected</option>
                      </select>
                    </div>
                     

                        <div class="form-group form-default col-md-12 d-flex justify-content-end align-items-end">
                            
                            <input type="submit" class="btn btn-primary" value="Update Status">


                        </div>
                    </form>
                  </div>
                  
                </div>
                
               
              </div>
            </div>
            <div class="row">
              <div class="container">
                

              <div id="imageDisplay"></div>

      
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection