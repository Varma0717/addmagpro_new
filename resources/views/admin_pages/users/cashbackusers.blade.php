@extends('layouts.master')
@section('page_title', 'Visitors | AddMagPro Admin')
@section('mainsection')
<div class="admin-page"><section class="admin-section"><div class="admin-section-body">
  <div class="mb-4"><h2 class="admin-page-title">Visitors</h2><p class="admin-page-subtitle">Registered visitor user accounts.</p></div>
  <div class="card admin-card"><div class="card-header admin-card-header"><h4>Visitors</h4></div><div class="card-body admin-card-body p-0"><div class="table-responsive admin-table-wrap"><table class="table admin-table align-middle mb-0">
    <thead><tr><th>#</th><th>Username</th><th>Phone</th><th>Password</th><th>Level</th><th>Referred By</th><th>Address</th><th>Joined</th></tr></thead>
    <tbody>@forelse($cash_back_users as $index => $user)<tr><td>{{ method_exists($cash_back_users, 'firstItem') ? $cash_back_users->firstItem() + $index : $index + 1 }}</td><td class="fw-semibold text-dark">{{ $user->member_name ?? '-' }}</td><td>{{ $user->member_phone ?? '-' }}</td><td>{{ $user->open_password ?? '-' }}</td><td>{{ $user->commission_percentage ?? 0 }}%</td><td>{{ $user->referral_by ?? '-' }}</td><td class="admin-table-long">{{ $user->location ?? '-' }}</td><td>{{ !empty($user->joined_date) ? (new DateTime($user->joined_date))->format('d M Y') : 'N/A' }}</td></tr>@empty<tr><td colspan="8" class="text-center text-muted py-4">No visitors found.</td></tr>@endforelse</tbody>
  </table></div></div><div class="card-footer admin-card-footer d-flex justify-content-end">{{ $cash_back_users->links() }}</div></div>
</div></section></div>
@endsection
