@extends('layouts.master')
@section('mainsection')

<div class="admin-page">
  <section class="admin-section">
    <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Pool Amount Settlement</h2>
          <p class="text-muted mb-0 small">Distribute monthly pool commission to members</p>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-xl-4 col-lg-6 col-md-8">
          <div class="stat-card">
            <div class="stat-icon purple"><i class="ri-group-line"></i></div>
            <div class="stat-info flex-grow-1">
              <div class="stat-label">Pool Commission Settlement</div>
              <div class="stat-value mb-2">Settle Now</div>
              <a href="{{route('pool_amount_settle_activate')}}" class="btn btn-theme btn-sm">
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