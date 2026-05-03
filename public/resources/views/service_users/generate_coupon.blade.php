@extends('service_user_dashboard_layouts.master')

@section('mainsection')
<div class="col-12 col-xl-9 mb-3">
    <div class="row g-4 pt-4">


        <!-- Remaining Coupons -->
        <div class="col-12 col-lg-6">
            <div class="card rounded-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="fs-2 mb-3 text-primary">
                        <i class="bi bi-ticket me-2"></i>
                    </div>
                    <h6 class="mb-3">Remaining Coupons Points</h6>
                    <div class="d-flex justify-content-center align-items-center">
                        <h3 class="remaining-points">{{$pin_user['total_pins']}}</h3>
                    </div>
                </div>
            </div>
        </div>


        <!-- Generate Coupon Section -->
        <div class="col-12 col-lg-6">
            <div class="card rounded-0 shadow-sm">
                <form action="{{route('generate_new_coupon')}}" method="POST">
                    @csrf
                    <div class="card-body text-center">
                        <div class="fs-2 mb-3 text-primary">
                            <i class="bi bi-ticket me-2"></i>
                        </div>
                        <h6 class="mb-3">Generate New Coupon</h6>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Coupon Code" id="coupon_code" name="coupon_code" aria-label="Coupon Code">
                            <button class="btn btn-primary" type="submit" id="generateCouponBtn">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Coupon List Section -->
        <div class="col-12 col-lg-12">
            <div class="card rounded-0 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Coupon List</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Coupon Id</th>
                                    <th scope="col">Coupon Code</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>F343gt</td>
                                    <td class="text-danger">Expired</td>
                                </tr>
                                <!-- Additional rows can be added here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- end row -->
</div><!-- end col-12 -->

@endsection
