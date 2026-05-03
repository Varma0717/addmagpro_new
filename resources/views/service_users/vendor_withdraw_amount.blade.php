@extends('service_user_dashboard_layouts.master')
@section('mainsection')

<div class="col-12 col-xl-9">
             
  <section class="">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-6 col-xl-5 col-xxl-4 mx-auto w-100">
          <div class="card rounded-0">
            <div class="card-body p-4">
              <h4 class="mb-4 fw-bold text-center">Vendor Amount Withdraw</h4>
              
              <form id="withdrawForm" action="{{route('vendor_withdrawal_request')}}" method="POST">
                @csrf
                <div class="row g-4">
                  <div class="col-12">
                    <label for="memberid" class="form-label">Available Amount</label>
                    <input type="text" class="form-control rounded-0" id="memberid" name="memberid" value="{{$withdraw_amount}}" readonly>
                  </div> 
                  <div class="col-12">
                    <label for="withdraw_amount" class="form-label">Withdraw Amount</label>
                    <input type="text" class="form-control rounded-0" id="withdraw_amount" name="withdraw_amount">
                  </div> 
                  <div class="col-12">
                    <button type="submit" class="btn btn-dark rounded-0 btn-ecomm w-100">Withdraw</button>
                  </div>
                </div><!---end row-->
              </form>
            </div>
          </div>
        </div>
      </div><!--end row-->
    </div>
  </section>

  <script>
    document.getElementById('withdrawForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent form from submitting

      const availableAmount = parseFloat(document.getElementById('memberid').value);
      const withdrawAmount = parseFloat(document.getElementById('withdraw_amount').value);

      if (isNaN(withdrawAmount) || withdrawAmount <= 0) {
        alert('Please enter a valid withdrawal amount.');
        return;
      }

      if (withdrawAmount > availableAmount) {
        alert('Withdrawal amount must be less than the available amount.');
        return;
      }

      // If validation passes, you can submit the form or handle the withdrawal request
      this.submit();
    });

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
  </script>

</div>
<!--end page content-->

@endsection
