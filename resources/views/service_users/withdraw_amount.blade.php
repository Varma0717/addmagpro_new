@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Withdraw Amount | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <h4 class="fw-bold mb-4">Withdraw Amount</h4>
                <div class="p-4 rounded mb-4 text-center text-white" style="background:linear-gradient(135deg,var(--theme-color),#7a2800);">
                    <p class="mb-0">Available Balance</p>
                    <h2 class="fw-bold my-2">&#8377;{{ number_format($withdraw_amount ?? 0, 2) }}</h2>
                </div>
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
                    <h6 class="fw-bold mb-3">Bank Details for Withdrawal</h6>
                    <form action="{{ route('storeWithdrawRequest') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bank Name</label>
                                <input type="text" class="form-control" name="bankname" value="{{ $bank_details->bank_name ?? '' }}" placeholder="Bank Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Account Number</label>
                                <input type="text" class="form-control" name="accountnumber" value="{{ $bank_details->account_number ?? '' }}" placeholder="Account Number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc" value="{{ $bank_details->ifsc ?? '' }}" placeholder="IFSC Code" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn w-100 py-3 fw-bold" style="background:var(--theme-color);color:#fff;">
                                    <i class="ri-bank-line me-2"></i> Submit Withdrawal Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
