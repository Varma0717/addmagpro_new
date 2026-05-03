@extends('layouts.master')
@section('page_title', 'Service Users | AddMagPro Admin')
@section('mainsection')
<div class="admin-page"><section class="admin-section"><div class="admin-section-body">
  <div class="mb-4"><h2 class="admin-page-title">Service Users</h2><p class="admin-page-subtitle">Pending service listings and approval actions.</p></div>
  <div class="card admin-card"><div class="card-header admin-card-header"><h4>Service Users</h4></div><div class="card-body admin-card-body p-0"><div class="table-responsive admin-table-wrap"><table class="table admin-table align-middle mb-0">
    <thead><tr><th>#</th><th>User</th><th>Mobile</th><th>PAN</th><th>Address</th><th>Service Type</th><th>Business Image</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>@forelse($service_users as $index => $user)<tr><td>{{ method_exists($service_users, 'firstItem') ? $service_users->firstItem() + $index : $index + 1 }}</td><td class="fw-semibold text-dark">{{ $user->member_name ?? '-' }}</td><td>{{ $user->member_phone ?? '-' }}</td><td>{{ $user->pan_number ?? '-' }}</td><td class="admin-table-long">{{ $user->address ?? '-' }}</td><td>{{ $user->profession ?? '-' }}</td><td>@if(!empty($user->business_image))<img src="{{ asset($user->business_image) }}" class="admin-thumb" alt="Business image">@else - @endif</td><td><span class="status-badge {{ (string)($user->status ?? '') === '1' ? 'badge-approved' : 'badge-rejected' }}">{{ (string)($user->status ?? '') === '1' ? 'Approved' : 'Not Approved' }}</span></td><td><a href="{{ route('business_listing_status_update', ['id' => $user->service_user_id]) }}" class="btn btn-theme btn-sm">Update</a></td></tr>@empty<tr><td colspan="9" class="text-center text-muted py-4">No service users found.</td></tr>@endforelse</tbody>
  </table></div></div><div class="card-footer admin-card-footer d-flex justify-content-end">{{ $service_users->links() }}</div></div>
</div></section></div>
@endsection
