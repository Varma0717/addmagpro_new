@extends('layouts.master')
@section('mainsection')

<div class="admin-page">
  <section class="admin-section">
    <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Back 2 Back Settlement</h2>
          <p class="text-muted mb-0 small">Settle back-to-back commission balances</p>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-xl-4 col-lg-6 col-md-8">
          <div class="stat-card">
            <div class="stat-icon orange"><i class="ri-exchange-funds-line"></i></div>
            <div class="stat-info flex-grow-1">
              <div class="stat-label">B2B Amount Settlement</div>
              <div class="stat-value mb-2">Settle Now</div>
              <a href="{{route('backtwoback_amount_settle')}}" class="btn btn-theme btn-sm">
                <i class="ri-check-line me-1"></i>Run Settlement
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection