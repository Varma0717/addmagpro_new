@extends('layouts.master')
@section('mainsection')
<div class="admin-page">
  <section class="admin-section">
    <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Update Vendor Status</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-7 col-lg-6 col-xl-5 mx-auto">
          <div class="card admin-card">
            <div class="card-header admin-card-header">
              <h4>Update Vendor Status</h4>
            </div>
            <div class="card-body admin-card-body">
              <form action="{{ route('updated_new_one') }}" method="POST" class="admin-form">
                @csrf
                <input type="hidden" value="{{ $vendor_id }}" id="vendor_id" name="vendor_id">
                <div class="admin-form-group">
                  <label for="status">Select Option</label>
                  <select class="form-control admin-input" id="status" name="status">
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-theme">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection