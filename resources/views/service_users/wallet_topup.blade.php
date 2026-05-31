@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Wallet Top-Up | AddMagPro')

@section('extra_css')
<style>
    .topup-container {
        max-width: 500px;
        margin: 40px auto;
    }

    .amount-preset {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .preset-btn {
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .preset-btn:hover {
        border-color: var(--theme-color);
        color: var(--theme-color);
    }

    .preset-btn.active {
        background: var(--theme-color);
        color: #fff;
        border-color: var(--theme-color);
    }

    .custom-input {
        width: 100%;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        margin-bottom: 16px;
        transition: border-color 0.3s;
    }

    .custom-input:focus {
        outline: none;
        border-color: var(--theme-color);
    }

    .info-box {
        background: #f0f4ff;
        border-left: 4px solid var(--theme-color);
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #555;
    }

    .topup-btn {
        width: 100%;
        padding: 14px;
        background: var(--theme-color);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: opacity 0.3s;
    }

    .topup-btn:hover:not(:disabled) {
        opacity: 0.9;
    }

    .topup-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .error-message {
        color: #d32f2f;
        font-size: 13px;
        margin-top: 8px;
        display: none;
    }

    .success-message {
        color: #388e3c;
        font-size: 13px;
        margin-top: 8px;
        display: none;
    }

    .loader {
        display: none;
        text-align: center;
        padding: 20px;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--theme-color);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endsection

@section('mainsection')
<section class="section-b-space">
    <div class="custom-container">
        <div class="topup-container">
            <div class="dash-card" style="border-radius: 12px; overflow: hidden;">
                <!-- Header -->
                <div class="p-4 text-white" style="background: linear-gradient(135deg, var(--theme-color), #7a2800);">
                    <h4 class="fw-bold mb-0">
                        <i class="ri-wallet-3-line me-2"></i> Add Money to Wallet
                    </h4>
                    <p class="mb-0 mt-2" style="font-size: 13px; opacity: 0.9;">
                        Fast & Secure payment via Razorpay
                    </p>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <!-- Info Box -->
                    <div class="info-box">
                        <i class="ri-information-line me-2"></i>
                        <strong>Limits:</strong> Minimum ₹{{ $min_topup }}, Maximum ₹{{ $max_topup }}
                    </div>

                    <!-- Preset Amounts -->
                    <p class="mb-2" style="font-weight: 600; color: #333;">Select Amount</p>
                    <div class="amount-preset">
                        <button type="button" class="preset-btn" data-amount="100">₹100</button>
                        <button type="button" class="preset-btn" data-amount="500">₹500</button>
                        <button type="button" class="preset-btn" data-amount="1000">₹1,000</button>
                        <button type="button" class="preset-btn" data-amount="5000">₹5,000</button>
                    </div>

                    <!-- Custom Amount -->
                    <p class="mb-2" style="font-weight: 600; color: #333;">Or Enter Custom Amount</p>
                    <input type="number" id="customAmount" class="custom-input" placeholder="Enter amount (₹)"
                        min="{{ $min_topup }}" max="{{ $max_topup }}">

                    <!-- Messages -->
                    <div class="error-message" id="errorMessage"></div>
                    <div class="success-message" id="successMessage"></div>

                    <!-- Loader -->
                    <div class="loader" id="loader">
                        <div class="spinner"></div>
                        <p class="mt-3" style="font-size: 14px; color: #666;">Processing...</p>
                    </div>

                    <!-- Topup Button -->
                    <button type="button" class="topup-btn" id="topupBtn">
                        <i class="ri-bank-card-line me-2"></i> Proceed to Payment
                    </button>

                    <!-- Back Link -->
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="{{ route('user_wallet') }}" style="color: var(--theme-color); text-decoration: none; font-size: 14px;">
                            <i class="ri-arrow-left-line"></i> Back to Wallet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    // Configuration
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const MIN_TOPUP = {
        {
            $min_topup
        }
    };
    const MAX_TOPUP = {
        {
            $max_topup
        }
    };

    // Helper functions
    const getAuthToken = () => localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token') || '';

    const clearMessages = () => {
        const errorEl = document.getElementById('errorMessage');
        const successEl = document.getElementById('successMessage');
        if (errorEl) errorEl.style.display = 'none';
        if (successEl) successEl.style.display = 'none';
    };

    const showError = (msg) => {
        clearMessages();
        const el = document.getElementById('errorMessage');
        if (el) {
            el.textContent = msg;
            el.style.display = 'block';
        }
    };

    const showSuccess = (msg) => {
        clearMessages();
        const el = document.getElementById('successMessage');
        if (el) {
            el.textContent = msg;
            el.style.display = 'block';
        }
    };

    const setLoading = (loading) => {
        const loader = document.getElementById('loader');
        const btn = document.getElementById('topupBtn');
        if (loader) loader.style.display = loading ? 'block' : 'none';
        if (btn) btn.disabled = loading;
    };

    // Main payment function - defined in global scope
    async function initiateTopup() {
        try {
            clearMessages();

            const input = document.getElementById('customAmount');
            const amount = input?.value || '';

            if (!amount) {
                showError('Please enter an amount');
                return;
            }

            const numAmount = parseFloat(amount);
            if (isNaN(numAmount) || numAmount < MIN_TOPUP) {
                showError(`Minimum top-up amount is ₹${MIN_TOPUP}`);
                return;
            }

            if (numAmount > MAX_TOPUP) {
                showError(`Maximum top-up amount is ₹${MAX_TOPUP}`);
                return;
            }

            const authToken = getAuthToken();
            if (!authToken) {
                showError('Authentication required. Please login again.');
                setTimeout(() => window.location.href = '/index', 2000);
                return;
            }

            setLoading(true);

            // Create payment order
            const response = await fetch('/api/v1/account/wallet/topup/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`,
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    amount: numAmount
                })
            });

            const data = await response.json();

            if (!response.ok) {
                setLoading(false);
                showError(data.message || 'Failed to create payment order');
                return;
            }

            // Open Razorpay
            const rzp = new Razorpay({
                key: data.data.keyId,
                amount: data.data.amount,
                currency: data.data.currency,
                order_id: data.data.orderId,
                name: 'AddMagPro',
                description: `Wallet Top-up ₹${numAmount}`,
                theme: {
                    color: getComputedStyle(document.documentElement).getPropertyValue('--theme-color').trim()
                },
                handler: (response) => verifyPayment(response, authToken, numAmount),
                modal: {
                    ondismiss: () => {
                        setLoading(false);
                        showError('Payment cancelled. Please try again.');
                    }
                }
            });

            rzp.open();
            setLoading(false);

        } catch (error) {
            setLoading(false);
            console.error('Error:', error);
            showError('An error occurred. Please try again.');
        }
    }

    // Verify payment
    async function verifyPayment(response, authToken, amount) {
        try {
            setLoading(true);

            const verifyResponse = await fetch('/api/v1/account/wallet/topup/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`,
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    amount: amount
                })
            });

            const data = await verifyResponse.json();

            if (!verifyResponse.ok) {
                setLoading(false);
                showError(data.message || 'Payment verification failed');
                return;
            }

            showSuccess('✓ Payment successful! Amount added to your wallet.');
            setTimeout(() => window.location.href = '{{ route("user_wallet") }}', 2000);

        } catch (error) {
            setLoading(false);
            console.error('Verification error:', error);
            showError('Payment verification failed. Please contact support.');
        }
    }

    // Initialize event listeners on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        // Preset button listeners
        document.querySelectorAll('.preset-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const input = document.getElementById('customAmount');
                if (input) input.value = this.dataset.amount;
                clearMessages();
            });
        });

        // Custom amount input listener
        const customInput = document.getElementById('customAmount');
        if (customInput) {
            customInput.addEventListener('input', function() {
                document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
                clearMessages();
            });
        }

        // Proceed button listener - function is now globally available
        const proceedBtn = document.getElementById('topupBtn');
        if (proceedBtn) {
            proceedBtn.addEventListener('click', initiateTopup);
        }
    });
</script>
@endsection