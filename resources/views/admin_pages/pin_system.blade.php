@extends('layouts.master') @section('mainsection')

<div class="admin-page">
    <section class="admin-section">
        <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Pin System and Coupon Generation</h2>
        </div>
      </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card admin-card">
                        <div class="card-header admin-card-header">
                            <h4>Pin System and Coupon Generation</h4>
                        </div>
                        <div class="card-body admin-card-body">
                            <form action="{{route('pin_system_activation')}}" method="POST">
                                @csrf

                                <div class="admin-form-group">
                                    <label>Phone Number (US Format)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="number" class="form-control phone-number" id="user_mobile" name="user_mobile" required>
                                    </div>
                                </div>
                                <div class="admin-form-group">
                                    <label>Enter the Pins</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            
                                        </div>
                                        <input type="number" class="form-control phone-number" id="pins_count" name="pins_count" required>
                                    </div>
                                </div>
                                <div class="admin-form-group">
                                    <button class="btn btn-primary daterange-btn icon-left btn-icon"><i class="fas fa-calendar"></i>Activate Coupons
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer admin-card-footer d-flex justify-content-end">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
      </div>
@endsection