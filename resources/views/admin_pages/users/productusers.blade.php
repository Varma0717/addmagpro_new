@extends('layouts.master')
@section('page_title', 'Product Users | AddMagPro Admin')
@section('mainsection')
<div class="admin-page"><section class="admin-section"><div class="admin-section-body">
  <div class="mb-4"><h2 class="admin-page-title">Product Users</h2><p class="admin-page-subtitle">Product purchase users and order status.</p></div>
  <div class="card admin-card"><div class="card-header admin-card-header"><h4>Product Users</h4></div><div class="card-body admin-card-body p-0"><div class="table-responsive admin-table-wrap"><table class="table admin-table align-middle mb-0">
    <thead><tr><th>#</th><th>User</th><th>Purchase Date</th><th>Product</th><th>Price</th><th>Qty</th><th>Total</th><th>Payment</th><th>Payment Status</th><th>Shipping</th><th>Order Status</th><th>Delivery</th></tr></thead>
    <tbody>@forelse($product_users as $index => $user)<tr><td>{{ method_exists($product_users, 'firstItem') ? $product_users->firstItem() + $index : $index + 1 }}</td><td>{{ $user->UserID ?? '-' }}</td><td>{{ $user->PurchaseDate ?? '-' }}</td><td class="fw-semibold text-dark">{{ $user->ProductName ?? '-' }}</td><td>{{ $user->ProductPrice ?? '-' }}</td><td>{{ $user->Quantity ?? '-' }}</td><td>{{ $user->TotalPrice ?? '-' }}</td><td>{{ $user->PaymentMethod ?? '-' }}</td><td>{{ $user->PaymentStatus ?? '-' }}</td><td class="admin-table-long">{{ $user->ShippingAddress ?? '-' }}</td><td><span class="status-badge {{ ($user->OrderStatus ?? '') === 'completed' ? 'badge-approved' : (($user->OrderStatus ?? '') === 'cancelled' ? 'badge-rejected' : 'badge-pending') }}">{{ ucfirst($user->OrderStatus ?? 'processing') }}</span></td><td>{{ $user->DeliveryDate ?? '-' }}</td></tr>@empty<tr><td colspan="12" class="text-center text-muted py-4">No product users found.</td></tr>@endforelse</tbody>
  </table></div></div><div class="card-footer admin-card-footer d-flex justify-content-end">{{ $product_users->links() }}</div></div>
</div></section></div>
@endsection
