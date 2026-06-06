@extends('layouts.master')
@section('page_title', 'Vendors | Admin Operations')
@section('mainsection')
<div class="admin-page">
    <section class="admin-section">
        <div class="admin-section-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="admin-page-title">Vendor Management</h2>
                </div><a class="btn btn-theme" href="{{ route('admin_ops') }}">Back to Hub</a>
            </div>

            <div class="card admin-card mb-4">
                <div class="card-header admin-card-header">
                    <h4>Add Vendor</h4>
                </div>
                <div class="card-body admin-card-body">
                    <form method="POST" action="{{ route('admin_ops_vendors_store') }}" class="row g-2">@csrf
                        <div class="col-md-3"><input class="form-control" name="vendor_name" required placeholder="Vendor name"></div>
                        <div class="col-md-2"><input class="form-control" name="vendor_phone" required placeholder="Phone"></div>
                        <div class="col-md-3"><input class="form-control" name="vendor_email" placeholder="Email"></div>
                        <div class="col-md-2"><input class="form-control" name="business_name" placeholder="Business name"></div>
                        <div class="col-md-2"><select class="form-select" name="status">
                                <option>Pending</option>
                                <option>Approved</option>
                                <option>Rejected</option>
                            </select></div>
                        <div class="col-md-3"><input class="form-control" name="business_type" placeholder="Business type"></div>
                        <div class="col-md-7"><input class="form-control" name="business_address" placeholder="Business address"></div>
                        <div class="col-md-2"><button class="btn btn-theme w-100" type="submit">Add Vendor</button></div>
                    </form>
                </div>
            </div>

            <div class="card admin-card">
                <div class="card-header admin-card-header">
                    <h4>Vendor List</h4>
                </div>
                <div class="card-body admin-card-body p-0">
                    <div class="table-responsive admin-table-wrap">
                        <table class="table admin-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Business</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Address</th>
                                    <th>Save</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vendors as $vendor)
                                <tr>
                                    <form method="POST" action="{{ route('admin_ops_vendors_update', ['id' => $vendor->vendor_id]) }}">@csrf
                                        <td>{{ $vendor->vendor_id }}</td>
                                        <td><input class="form-control" name="vendor_name" value="{{ $vendor->vendor_name }}" required></td>
                                        <td><input class="form-control" name="vendor_phone" value="{{ $vendor->vendor_phone }}" required></td>
                                        <td><input class="form-control" name="vendor_email" value="{{ $vendor->vendor_email }}"></td>
                                        <td><input class="form-control" name="business_name" value="{{ $vendor->business_name }}"></td>
                                        <td><input class="form-control" name="business_type" value="{{ $vendor->business_type }}"></td>
                                        <td><select class="form-select" name="status">
                                                <option {{ $vendor->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option {{ $vendor->status === 'Approved' ? 'selected' : '' }}>Approved</option>
                                                <option {{ $vendor->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select></td>
                                        <td><input class="form-control" name="business_address" value="{{ $vendor->business_address }}"></td>
                                        <td><button class="btn btn-theme btn-sm" type="submit">Save</button></td>
                                    </form>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No vendors found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">{{ $vendors->links() }}</div>
            </div>
        </div>
    </section>
</div>
@endsection