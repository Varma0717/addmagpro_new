@extends('layouts.master')
@section('page_title', 'Active Users | AddMagPro Admin')
@section('mainsection')
<div class="admin-page"><section class="admin-section"><div class="admin-section-body">
  <div class="mb-4"><h2 class="admin-page-title">Active Users</h2><p class="admin-page-subtitle">Active network users and level upgrades.</p></div>
  <div class="card admin-card"><div class="card-header admin-card-header"><h4>Active Users</h4></div><div class="card-body admin-card-body p-0"><div class="table-responsive admin-table-wrap"><table class="table admin-table align-middle mb-0">
    <thead><tr><th>#</th><th>Username</th><th>Phone</th><th>Password</th><th>Level</th><th>B2B Value</th><th>Referred By</th><th>Address</th><th>Joined</th><th>Action</th></tr></thead>
    <tbody>@forelse($cash_back_users as $index => $user)<tr><td>{{ method_exists($cash_back_users, 'firstItem') ? $cash_back_users->firstItem() + $index : $index + 1 }}</td><td class="fw-semibold text-dark">{{ $user->member_name ?? '-' }}</td><td>{{ $user->member_phone ?? '-' }}</td><td>{{ $user->open_password ?? '-' }}</td><td>{{ $user->commission_percentage ?? 0 }}%</td><td>{{ $user->back_two_back_balance ?? 0 }}</td><td>{{ $user->referral_by ?? '-' }}</td><td class="admin-table-long">{{ $user->location ?? '-' }}</td><td>{{ !empty($user->joined_date) ? (new DateTime($user->joined_date))->format('d M Y') : 'N/A' }}</td><td><a href="{{ route('upgrade_user_percentage_level', ['user_id' => $user->service_id]) }}" class="btn btn-theme btn-sm">Upgrade</a></td></tr>@empty<tr><td colspan="10" class="text-center text-muted py-4">No active users found.</td></tr>@endforelse</tbody>
  </table></div></div><div class="card-footer admin-card-footer d-flex justify-content-end">{{ $cash_back_users->links() }}</div></div>
</div></section></div>
@endsection
