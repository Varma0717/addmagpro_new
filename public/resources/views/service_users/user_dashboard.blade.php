@extends('service_user_dashboard_layouts.master')
@section('mainsection')


<div class="col-12 col-xl-9">
    <div class="rounded-0 bg-light p-2" style="border: 1px black solid;">
        <div class="card-body">
            <div class="d-flex flex-wrap flex-row align-items-center gap-3">
                <div class="profile-pic">
                    <img src="assets/images/avatars/01.jpg" width="140" alt="">
                </div>  
                <div class="profile-email flex-grow-1">
                    <h5>Member Referral Link: 
                        <span id="memberReferralLink">addmagpro.com/service_user_registration/{{$user_details[0]->member_phone}}</span>
                        <button onclick="copyToClipboard('#memberReferralLink')">Copy</button>
                    </h5>
                    <h5>Vendor Referral Link: 
                        <span id="vendorReferralLink">addmagpro.com/vendor_register/{{$user_details[0]->member_phone}}</span>
                        <button onclick="copyToClipboard('#vendorReferralLink')">Copy</button>
                    </h5>
                </div>

                <div class="edit-button align-self-start">
                    <!-- <a href="account-edit-profile.html" class="btn btn-outline-dark btn-ecomm"><i class="bi bi-pencil-fill me-2"></i>Edit Profile</a> -->
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-lg-3 g-4 pt-4">
        <div class="col">
            <a href="{{route('my_commission')}}">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="fs-2 mb-3 text-content"><i class="bi bi-person"></i></div>
                            <h6 class="mb-0">My Commission</h6>
                            @if($user_commission->total_balance===null)
                                <p>0</p>
                            @else
                                <p>{{ $user_commission->total_balance }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col">
            <a>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="fs-2 mb-3 text-content"><i class="bi bi-cash"></i></div>
                            <h6 class="mb-0">Back2Back Value</h6>
                            <p>{{$back_two_back_balance_value}}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="fs-2 mb-3 text-content"><i class="bi bi-cash"></i></div>
                            <h6 class="mb-0">Back2Back Income</h6>
                            @if($backtwoback_income->isEmpty())
                                <p>0</p>
                            @else
                                <p>{{ $backtwoback_income[0]->balance }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="fs-2 mb-3 text-content"><i class="bi bi-cash-stack"></i></div>
                            <h6 class="mb-0">Discount Cashback</h6>
                            <p>0</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="fs-2 mb-3 text-content"><i class="bi bi-people"></i></div>
                            <h6 class="mb0">Deposite Wallet</h6>
                            <p>0</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="fs-2 mb-3 text-content"><i class="bi bi-wallet"></i></div>
                            <h6 class="mb-0">Cummulative</h6>
                            <p>{{$cummulative_value}}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{route('withdraw_amount')}}">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="fs-2 mb-3 text-content"><i class="bi bi-wallet"></i></div>
                            <h6 class="mb-0">Withdraw</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div><!--end row-->
</div><!--end row-->
</div>
</section>
<!--start product details-->

<script>
    // Get all cards
    const cards = document.querySelectorAll('.card');
    
    // Get the height of the tallest card
    let maxHeight = 0;
    cards.forEach(card => {
        const height = card.offsetHeight;
        if (height > maxHeight) {
            maxHeight = height;
        }
    });
    
    // Set the height of all cards to match the tallest card
    cards.forEach(card => {
        card.style.height = `${maxHeight}px`;
    });

    function copyToClipboard(element) {
        var textToCopy = "Hi! I’m sharing with you an exclusive invite to ADD MAG Pro . Com (E-commerce & local search engine) \n1. Get 100% Cashback on every ₹3000 above shopping 🛍 from e-commerce. \n2. List your business in addmagpro at just ₹1050/- per year. \n3. ⁠Refer & Earn upto 20% on every purchase of your friend for lifetime. \n" + document.querySelector(element).textContent + "\n Your journey to savings & earnings begins!";
        var tempInput = document.createElement('input');
        tempInput.value = textToCopy;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        alert('Copied to clipboard');
    }
</script>

</div>
<!--end page content-->

@endsection()
