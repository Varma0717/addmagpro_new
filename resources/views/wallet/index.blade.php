@extends('app_layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Wallet Balance Card -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg text-white p-8">
                <p class="text-blue-100 mb-2">Wallet Balance</p>
                <h2 class="text-4xl font-bold mb-8">₹<span id="balance">0</span></h2>

                <div class="space-y-2">
                    <a href="/wallet/topup" class="block bg-white text-blue-600 px-4 py-2 rounded-lg text-center font-semibold hover:bg-gray-100">
                        Add Money
                    </a>
                    <button onclick="openTransferModal()" class="w-full bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-800">
                        Send Money
                    </button>
                </div>
            </div>
        </div>

        <!-- Wallet Details -->
        <div class="lg:col-span-2">
            <div class="space-y-6">
                <!-- Statistics -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Statistics</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <p class="text-gray-600 text-sm">Total Received</p>
                            <p class="text-2xl font-bold text-gray-900" id="total-received">₹0</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600 text-sm">Total Spent</p>
                            <p class="text-2xl font-bold text-gray-900" id="total-spent">₹0</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Transactions</h3>
                    <div id="transactions-list" class="space-y-3">
                        <p class="text-gray-500">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                const txData = txResponse.json();
                if (txData.success) {
                    const txs = txData.data || [];
                    const html = txs.length === 0 ?
                        '<p class="text-gray-500">No transactions yet</p>' :
                        txs.map(tx => `
                            <div class="flex justify-between items-center pb-3 border-b">
                                <div>
                                    <p class="font-semibold text-gray-900">${tx.type}</p>
                                    <p class="text-sm text-gray-600">${new Date(tx.created_at).toLocaleDateString()}</p>
                                </div>
                                <p class="font-bold ${tx.type.includes('Credit') ? 'text-green-600' : 'text-red-600'}">
                                    ${tx.type.includes('Credit') ? '+' : '-'}₹${Math.abs(tx.amount)}
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