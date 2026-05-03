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
             <!--          <a href="account-edit-profile.html" class="btn btn-outline-dark btn-ecomm"><i class="bi bi-pencil-fill me-2"></i>Edit Profile</a>-->
             <!--        </div>-->
             <!--      </div>-->
             <!--    </div>-->
             <!--</div>-->

             <div class="row row-cols-2 row-cols-lg-3 g-4 pt-4">
               <div class="col">
                 <a>
                  <div class="card rounded-0">
                    <div class="card-body ">
                        <div class="text-center">
                           <div class="fs-2 text-content"><i class="bi bi-person"></i></div>
                           <h6 class="mb-0">Team Referal</h6>
                           <p>{{$user_commission['total_balance']}}</p>
                        </div>
                    </div>
                  </div>
                 </a>
               </div>
              
               <div class="col">
                <a>
                <div class="card rounded-0">
                  <div class="card-body ">
                      <div class="text-center">
                         <div class="fs-2  text-content"><i class="bi bi-cash-coin"></i></div>
                         <h6 class="mb-0">Purchase Income</h6>
                         <p>0</p>
                      </div>
                  </div>
                </div>
               </a>
               </div>
               <div class="col">
                <a >
                <div class="card rounded-0">
                  <div class="card-body">
                      <div class="text-center">
                         <div class="fs-2  text-content"><i class="bi bi-award"></i></div>
                         <h6 class="mb-0">Pool Commission</h6>
                         <p>0</p>
                      </div>
                  </div>
                </div>
               </a>
               </div>
               <div class="col">
                <a >
                <div class="card rounded-0">
                  <div class="card-body ">
                      <div class="text-center">
                         <div class="fs-2  text-content"><i class="bi bi-bank2"></i></div>
                         <h6 class="mb-0">Vendor</h6>
                         <p>0</p>
                      </div>
                  </div>
                </div>
               </a>
               </div>
              
               <div class="col">
                <a>
                <div class="card rounded-0">
                  <div class="card-body ">
                      <div class="text-center">
                         <div class="fs-2  text-content"><i class="bi bi-cash-stack"></i></div>
                         <h6 class="mb-0">Reward Income</h6>
                         <p>0</p>
                      </div>
                  </div>
                </div>
               </a>
               </div>
               
               <div class="col">
                <a>
                <div class="card rounded-0">
                  <div class="card-body ">
                      <div class="text-center">
                         <div class="fs-2  text-content"><i class="bi bi-wallet"></i></div>
                         <h6 class="mb-0">Leadership Productivity Bonus Wallet </h6>
                         <p>0</p>
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