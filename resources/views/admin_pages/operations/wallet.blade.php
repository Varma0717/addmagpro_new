@extends('layouts.master')
@section('page_title', 'Wallet | Admin Operations')
@section('mainsection')
<div class="admin-page">
    <section class="admin-section">
        <div class="admin-section-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="admin-page-title">Wallet Administration</h2>
                    <p class="admin-page-subtitle">Monitor wallet health and process withdrawal requests used by mobile + web APIs.</p>
                </div><a class="btn btn-theme" href="{{ route('admin_ops') }}">Back to Hub</a>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">User Wallet Balance</div>
                            <div class="stat-value">{{ number_format($summary['walletBalance'], 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Total Transactions</div>
                            <div class="stat-value">{{ $summary['totalTransactions'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Pending Withdrawals</div>
                            <div class="stat-value">{{ $summary['pendingWithdrawals'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Completed Withdrawals</div>
                            <div class="stat-value">{{ $summary['completedWithdrawals'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card admin-card">
                <div class="card-header admin-card-header">
                    <h4>Wallet Transactions</h4>
                </div>
                <div class="card-body admin-card-body p-0">
                    <div class="table-responsive admin-table-wrap">
                        <table class="table admin-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Txn Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Reference</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $txn)
                                <tr>
                                    <td>{{ $txn->id }}</td>
                                    <td>{{ optional($txn->user)->name ?? 'User #'.$txn->user_id }}<br><small class="text-muted">{{ optional($txn->user)->phone ?? optional($txn->user)->email }}</small></td>
                                    <td>{{ $txn->type }}</td>
                                    <td>{{ $txn->transaction_type }}</td>
                                    <td>{{ number_format((float)$txn->amount, 2) }}</td>
                                    <td><span class="status-badge {{ $txn->status === 'completed' ? 'badge-approved' : ($txn->status === 'failed' ? 'badge-rejected' : 'badge-pending') }}">{{ ucfirst($txn->status) }}</span></td>
                                    <td>{{ $txn->reference_id }}</td>
                                    <td class="admin-table-long">{{ $txn->description }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin_ops_wallet_status', ['id' => $txn->id]) }}" class="d-flex gap-2">@csrf
                                            <select class="form-select form-select-sm" name="status">
                                                <option value="pending" {{ $txn->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="completed" {{ $txn->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="failed" {{ $txn->status === 'failed' ? 'selected' : '' }}>Failed</option>
                                            </select>
                                            <button class="btn btn-theme btn-sm" type="submit">Save</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">No wallet transactions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">{{ $transactions->links() }}</div>
            </div>
        </div>
    </section>
</div>
@endsection