@extends('layouts.master')
@section('mainsection')
<div class="admin-page">
    <section class="admin-section">
        <div class="admin-section-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="mb-0 fw-bold">Inactive Franchises</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card admin-card">
                        <div class="card-header admin-card-header">
                            <h4>Inactive Franchises</h4>
                        </div>
                        <div class="card-body admin-card-body p-0">
                            <div class="table-responsive">
                                <table class="table admin-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Franchise Name</th>
                                            <th>Owner</th>
                                            <th>Location</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Start Date</th>
                                            <th>Status</th>
                                            <th>Revenue</th>
                                            <th>Expenses</th>
                                            <th>Profit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($inactive_franchise as $index => $franchise)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $franchise->franchise_name }}</td>
                                            <td>{{ $franchise->franchise_owner }}</td>
                                            <td>{{ $franchise->franchise_location }}</td>
                                            <td>{{ $franchise->franchise_phone }}</td>
                                            <td>{{ $franchise->franchise_email }}</td>
                                            <td>{{ $franchise->franchise_type }}</td>
                                            <td>{{ $franchise->franchise_start_date }}</td>
                                            <td>
                                                <div class="status-badge badge-inactive">Inactive</div>
                                            </td>
                                            <td>{{ $franchise->franchise_revenue }}</td>
                                            <td>{{ $franchise->franchise_expenses }}</td>
                                            <td>{{ $franchise->franchise_profit }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="12" class="text-center text-muted py-4">No records found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection