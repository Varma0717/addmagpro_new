@extends('service_user_dashboard_layouts.master')
@section('page_title', 'Order Summary | AddMagPro')

@section('extra_css')
<style>
.order-card { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.07); padding:1.5rem; }
.order-card h6 { font-weight:700; color:var(--title-color); padding-bottom:.5rem; border-bottom:2px solid var(--theme-color); margin-bottom:1.2rem; }
.price-row { display:flex; justify-content:space-between; padding:.5rem 0; }
.price-row:not(:last-child) { border-bottom:1px solid #f0f0f0; }
.pay-btn { background:var(--theme-color); color:#fff; width:100%; padding:1rem; border:none; border-radius:8px; font-weight:700; font-size:1.1rem; cursor:pointer; }
.pay-btn:hover { background:#e68a00; }
</style>
@endsection

@section('mainsection')
<section class="breadscrumb-section pt-0">
    <div class="custom-container">
        <div class="breadcrumb-head">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('welcome_page') }}">Home</a></li>
                    <li class="breadcrumb-item active">Order Summary</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="section-b-space">
    <div class="custom-container">
        <h4 class="fw-bold mb-4">Order Summary</h4>
        <form action="{{ route('ordered_cofirmation_status') }}" method="POST" id="payment-form">
            @csrf
            <input type="hidden" id="unique_id" name="unique_id" value="{{ $unique_id }}">
            <input type="hidden" id="vendor_id" name="vendor_id" value="{{ $products_vendor_id }}">
            <input type="hidden" id="total_amount" name="total_amount" value="{{ $totalAmount }}">
            <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id">

            <div class="row g-4">
                {{-- Ordered Products List --}}
                <div class="col-lg-8">
                    <div class="order-card mb-4">
                        <h6><i class="ri-shopping-bag-line me-2"></i>Ordered Products</h6>
                        @isset($ordered_products)
                        @foreach($ordered_products as $product)
                        <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">{{ $product->product_name }}</h6>
                                <small class="text-muted">Qty: {{ $product->quantity }}</small>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-0 fw-bold" style="color:var(--theme-color);">&#8377;{{ number_format($product->purchase_price * $product->quantity, 2) }}</h6>
                            </div>
                        </div>
                        @endforeach
                        @endisset
                    </div>
                </div>

                {{-- Price Breakdown --}}
                <div class="col-lg-4">
                    <div class="order-card">
                        <h6><i class="ri-price-tag-3-line me-2"></i>Price Details</h6>
                        <div class="price-row">
                            <span>Bag Total</span>
                            <span class="fw-bold">&#8377;{{ $totalPurchasePrice }}</span>
                        </div>
                        <div class="price-row">
                            <span>Handling Charges</span>
                            <span id="deliveryCharges">&#8377;{{ $deliveryCharges }}</span>
                        </div>
                        <div class="price-row">
                            <label>
                                <input type="checkbox" id="wallet_amount" name="wallet_amount" value="{{ $wallet_money }}" class="me-1">
                                Use Wallet Balance
                            </label>
                            <span id="walletAmount" style="color:green;">-&#8377;{{ $wallet_money }}</span>
                        </div>
                        <div class="price-row" style="font-size:1.1rem;font-weight:700;">
                            <span>Total Amount</span>
                            <span id="totalAmount" style="color:var(--theme-color);">&#8377;{{ $totalAmount }}</span>
                        </div>
                        <button type="button" class="pay-btn mt-3" id="razorpay-button">
                            <i class="ri-secure-payment-line me-2"></i>Pay &#8377;<span id="pay-amount">{{ $totalAmount }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('extra_js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var walletCheckbox = document.getElementById('wallet_amount');
    var totalAmountEl = document.getElementById('totalAmount');
    var payAmountEl = document.getElementById('pay-amount');
    var walletAmt = parseFloat(walletCheckbox.value) || 0;
    var initialTotal = parseFloat('{{ $totalAmount }}');

    function updateTotal() {
        var newTotal = walletCheckbox.checked ? Math.max(1, initialTotal - walletAmt) : initialTotal;
        totalAmountEl.innerText = '₹' + newTotal.toFixed(2);
        payAmountEl.innerText = newTotal.toFixed(2);
    }
    walletCheckbox.addEventListener('change', updateTotal);
    updateTotal();
});
</script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('razorpay-button').onclick = function(e) {
    e.preventDefault();
    var totalAmount = parseFloat(document.getElementById('pay-amount').innerText) * 100;
    var options = {
        "key": "{{ config('services.razorpay.key') }}",
        "amount": totalAmount,
        "currency": "INR",
        "name": "AddMagPro",
        "description": "Payment for Order",
        "image": "{{ asset('assets/user_assets/images/logo.png') }}",
        "handler": function(response) {
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('payment-form').submit();
        },
        "prefill": {
            "name": "AddMagPro",
            "email": "addmagpro@gmail.com",
            "contact": "7702381784"
        },
        "theme": { "color": "#ff9900" }
    };
    var rzp = new Razorpay(options);
    rzp.open();
};
</script>
@endsection
