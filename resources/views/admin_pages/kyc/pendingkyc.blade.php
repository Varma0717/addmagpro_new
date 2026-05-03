@extends('layouts.master')
@section('page_title', 'Pending KYC | AddMagPro Admin')
@section('mainsection')
<div class="admin-page"><section class="admin-section"><div class="admin-section-body">
  <div class="mb-4"><h2 class="admin-page-title">Pending KYC</h2><p class="admin-page-subtitle">KYC records with Pending status.</p></div>
  <div class="card admin-card"><div class="card-header admin-card-header"><h4>Pending KYC</h4></div><div class="card-body admin-card-body p-0"><div class="table-responsive admin-table-wrap"><table class="table admin-table align-middle mb-0">
    <thead><tr><th>#</th><th>Username</th><th>Status</th><th>Approved Date</th></tr></thead>
    <tbody>@forelse($pending_kyc as $index => $kyc)<tr><td>{{ method_exists($pending_kyc, 'firstItem') ? $pending_kyc->firstItem() + $index : $index + 1 }}</td><td class="fw-semibold text-dark">{{ $kyc->full_name ?? '-' }}</td><td><span class="status-badge badge-pending">Pending</span></td><td>{{ $kyc->approved_date ?? '-' }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">No pending KYC records found.</td></tr>@endforelse</tbody>
  </table></div></div><div class="card-footer admin-card-footer d-flex justify-content-end">{{ $pending_kyc->links() }}</div></div>
</div></section></div>
@endsection
