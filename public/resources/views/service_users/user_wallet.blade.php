@extends('service_user_dashboard_layouts.master')
@section('mainsection')
          <div class="col-12 col-xl-9">
             <!--<div class="rounded-0 bg-light p-2" style="border: 1px black solid;" >-->
             <!--    <div class="card-body">-->
             <!--      <div class="d-flex flex-wrap flex-row align-items-center gap-3">-->
             <!--        <div class="profile-pic">-->
             <!--           <img src="assets/images/avatars/01.jpg" width="140" alt="">-->
             <!--        </div>  -->
             <!--        <div class="profile-email flex-grow-1">-->
             <!--          <p class="mb-0 fw-bold text-content">michel@example.com</p>-->
             <!--        </div>-->
             <!--        <div class="edit-button align-self-start">-->
             <!--          <a href="{{route('welcome_page')}}" class="btn btn-outline-dark btn-ecomm"><i class="bi bi-pencil-fill me-2"></i>Edit Profile</a>-->
             <!--        </div>-->
             <!--      </div>-->
             <!--    </div>-->
             <!--</div>-->

             <div class="row row-cols-2 row-cols-lg-4 g-4">
               <div class="col">
                 <a href="">
                  <div class="card rounded-0">
                    <div class="card-body p-5">
                        <div class="text-center">
                           <div class="fs-2 mb-3 text-content"><i class="bi bi-person"></i></div>
                           <h6 class="mb-0">Cashback Wallet</h6>
                           <p>Amount : <span>{{$user_back_two_back_amount}}</span></p>
                        </div>
                    </div>
                  </div>
                 </a>
               </div>
               <div class="col">
                <a href="">
                <div class="card rounded-0">
                  <div class="card-body p-5">
                      <div class="text-center">
                         <div class="fs-2 mb-3 text-content"><i class="bi bi-people"></i></div>
                         <h6 class="mb-0">Referral</h6>
                         <p>Amount : <span>{{$user_commission_amount}}</span></p>
                      </div>
                  </div>
                </div>
               </a>
               </div>
               <div class="col">
                <a href="">
                <div class="card rounded-0">
                  <div class="card-body p-5">
                      <div class="text-center">
                         <div class="fs-2 mb-3 text-content"><i class="bi bi-cash-coin"></i></div>
                         <h6 class="mb-0">Top-Up Wallet</h6>
                         <p>Amount : <span>0</span></p>
                      </div>
                  </div>
                </div>
               </a>
               </div>
               <div class="col">
                <a href="">
                <div class="card rounded-0">
                  <div class="card-body p-5">
                      <div class="text-center">
                         <div class="fs-2 mb-3 text-content"><i class="bi bi-award"></i></div>
                         <h6 class="mb-0">Pool Wallet</h6>
                         <p>Amount : <Span>{{$user_pool_commission_amount}}</Span></p>
                      </div>
                  </div>
                </div>
               </a>
               </div>
              
               
               
               

             </div><!--end row-->


          </div>
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
  </script>
  
  
 </div>
  <!--end page content-->

@endsection()