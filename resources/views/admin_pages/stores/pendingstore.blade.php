@extends('layouts.master')
@section('page_title', 'Pending Stores | AddMagPro Admin')
@section('mainsection')
<div class="admin-page">
  <section class="admin-section">
    <div class="admin-section-body">
      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
          <h2 class="admin-page-title">Pending Stores</h2>
          <p class="admin-page-subtitle">Vendor store approval requests waiting for review.</p>
        </div>
      </div>

      <div class="card admin-card">
        <div class="card-header admin-card-header">
          <h4><i class="ri-time-line me-2"></i>Store Approvals</h4>
        </div>
        <div class="card-body admin-card-body p-0">
          <div class="table-responsive admin-table-wrap">
            <table class="table admin-table align-middle mb-0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Store Name</th>
                  <th>Store Type</th>
                  <th>Address</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Manager</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($approved_stores as $index => $store)
                  <tr>
                    <td>{{ method_exists($approved_stores, 'firstItem') ? $approved_stores->firstItem() + $index : $index + 1 }}</td>
                    <td class="fw-semibold text-dark">{{ $store->business_name ?? '-' }}</td>
                    <td>{{ $store->business_type ?? '-' }}</td>
                    <td class="text-wrap admin-table-long">{{ $store->business_address ?? '-' }}</td>
                    <td>{{ $store->vendor_phone ?? '-' }}</td>
                    <td>{{ $store->vendor_email ?? '-' }}</td>
                    <td>{{ $store->vendor_name ?? '-' }}</td>
                    <td class="text-wrap admin-table-long">{{ $store->business_description ?? $store->vendor_name ?? '-' }}</td>
                    <td><span class="status-badge badge-pending">Pending</span></td>
                    <td>
                      <a href="{{ route('update_status', ['vendor_id' => $store->vendor_id]) }}" class="btn btn-theme btn-sm">
                        Update
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="10" class="text-center text-muted py-4">No pending stores found.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer admin-card-footer d-flex justify-content-end">
          {{ $approved_stores->links() }}
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
