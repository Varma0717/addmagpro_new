@extends('service_user_dashboard_layouts.master')
@section('page_title', 'My Wallet | AddMagPro')
@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">My Wallet</h4>
        <div class="p-4 mb-4 text-white text-center rounded" style="background:linear-gradient(135deg,var(--theme-color),#7a2800);">
            <p class="mb-0">Total Wallet Balance</p>
            <h1 class="fw-bold my-2">₹<span id="balance">0</span></h1>
            <a href="{{ route('user_wallet') }}" class="btn mt-2" style="background:#fff;color:var(--theme-color);font-weight:700;">
                View Wallet Details
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <a href="/wallet/topup" class="btn w-100" style="background:var(--theme-color);color:#fff;font-weight:700;padding:0.75rem;">
                    <i class="ri-add-line"></i> Add Money to Wallet
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('withdraw_amount') }}" class="btn w-100 btn-outline-warning" style="font-weight:700;padding:0.75rem;color:var(--theme-color);border-color:var(--theme-color);">
                    <i class="ri-money-withdraw-line"></i> Withdraw Money
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);border-top:4px solid var(--theme-color);">
                    <p class="text-muted mb-1">Total Received</p>
                    <h4 class="fw-bold mb-0">₹<span id="total-received">0</span></h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);border-top:4px solid #1976d2;">
                    <p class="text-muted mb-1">Total Spent</p>
                    <h4 class="fw-bold mb-0">₹<span id="total-spent">0</span></h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);border-top:4px solid #388e3c;">
                    <p class="text-muted mb-1">Pending Withdrawals</p>
                    <h4 class="fw-bold mb-0">₹<span id="pending-withdrawal">0</span></h4>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="mt-4 p-4 rounded" style="background:#fff;box-shadow:0 2px 12px rgba(0,0,0,.07);">
            <h5 class="fw-bold mb-3">Recent Transactions</h5>
            <div id="transactions-list" class="space-y-3">
                <p class="text-muted">Loading transactions...</p>
            </div>
        </div>
    </div>
</section>

<script>
    const token = localStorage.getItem('auth_token');

    async function loadWalletData() {
        try {
            const response = await fetch('/api/v1/wallet', {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            const data = await response.json();

            if (data.success) {
                const wallet = data.data;
                document.getElementById('balance').textContent = Math.round(wallet.balance || 0);
                document.getElementById('total-received').textContent = '₹' + Math.round(wallet.total_received || 0);
                document.getElementById('total-spent').textContent = '₹' + Math.round(wallet.total_spent || 0);

                // Load transactions
                const txResponse = await fetch('/api/v1/wallet/transactions', {
                    headers: {
                        'Authorization': 'Bearer ' + token
                    }
                });
                const txData = await txResponse.json();
                if (txData.success) {
                    const txs = txData.data || [];
                    const html = txs.length === 0 ?
                        '<p class="text-muted">No transactions yet</p>' :
                        txs.map(tx => `
                            <div class="d-flex justify-content-between align-items-center pb-3 border-bottom">
                                <div>
                                    <p class="fw-semibold text-dark mb-1">${tx.type}</p>
                                    <p class="text-muted small">${new Date(tx.created_at).toLocaleDateString()}</p>
                                </div>
                                <p class="fw-bold ${tx.type.includes('Credit') ? 'text-success' : 'text-danger'} mb-0">
                                    ${tx.type.includes('Credit') ? '+' : '-'}₹${Math.abs(tx.amount).toFixed(2)}
                                </p>
                            </div>
                        `).join('');
                    document.getElementById('transactions-list').innerHTML = html;
                }
            }
        } catch (e) {
            console.error('Error:', e);
        }
    }

    function openTransferModal() {
        const recipient = prompt('Enter recipient email:');
        if (!recipient) return;

        const amount = prompt('Enter amount to send:');
        if (!amount || amount <= 0) return;

        fetch('/api/v1/wallet/send-money', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                recipient_email: recipient,
                amount: parseFloat(amount)
            })
        }).then(r => r.json()).then(data => {
            alert(data.message);
            loadWalletData();
        });
    }

    loadWalletData();
</script>
@endsection