@extends('layouts.master')
@section('page_title', 'Wallet | Admin Operations')
@section('mainsection')
<div class="admin-page">
    <section class="admin-section">
        <div class="admin-section-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="admin-page-title">Wallet Command Center</h2>
                    <p class="admin-page-subtitle">Amazon-style wallet monitoring for balances, withdrawal queue and customer wallet health.</p>
                </div><a class="btn btn-theme" href="{{ route('admin_ops') }}">Back to Hub</a>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">User Wallet Balance</div>
                            <div class="stat-value">₹{{ number_format($summary['walletBalance'], 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Credit Volume</div>
                            <div class="stat-value">₹{{ number_format($summary['creditVolume'], 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-label">Debit Volume</div>
                            <div class="stat-value">₹{{ number_format($summary['debitVolume'], 2) }}</div>
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
            </div>

            <div class="row g-3 mb-4">
                <div class="col-lg-5">
                    <div class="card admin-card h-100">
                        <div class="card-header admin-card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Top Wallet Customers</h4>
                            <span class="text-muted small">Highest balances</span>
                        </div>
                        <div class="card-body admin-card-body">
                            @forelse($topWalletUsers as $user)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <div class="fw-semibold">{{ $user->name ?: 'User #'.$user->id }}</div>
                                    <div class="text-muted small">{{ $user->phone ?: $user->email }}</div>
                                </div>
                                <div class="fw-bold text-success">₹{{ number_format((float) $user->wallet_balance, 2) }}</div>
                            </div>
                            @empty
                            <div class="text-muted">No wallet balances found.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card admin-card h-100">
                        <div class="card-header admin-card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Pending Withdrawal Queue</h4>
                            <span class="text-muted small">Process fastest first</span>
                        </div>
                        <div class="card-body admin-card-body p-0">
                            <div class="table-responsive admin-table-wrap">
                                <table class="table admin-table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Requested</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pendingWithdrawals as $txn)
                                        <tr>
                                            <td>{{ $txn->id }}</td>
                                            <td>{{ optional($txn->user)->name ?? 'User #'.$txn->user_id }}<br><small class="text-muted">{{ optional($txn->user)->phone ?? optional($txn->user)->email }}</small></td>
                                            <td class="fw-bold">₹{{ number_format((float) $txn->amount, 2) }}</td>
                                            <td>{{ optional($txn->created_at)->format('d M Y h:i A') }}</td>
                                            <td><span class="status-badge badge-pending">Pending</span></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">No pending withdrawals.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card admin-card">
                <div class="card-header admin-card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Wallet Ledger</h4>
                    <span class="text-muted small">{{ $summary['totalTransactions'] }} transactions • {{ $summary['completedWithdrawals'] }} completed withdrawals</span>
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