@extends('service_user_dashboard_layouts.master')
@section('mainsection')
          <div class="col-12 col-xl-9">
             
             <section class="">
                <div class="container">
                  
                    <div class="row">
                      <div class="col-12 col-lg-6 col-xl-5 col-xxl-4 mx-auto w-100">
                         <div class="card rounded-0">
                           <div class="card-body p-4">
                             <h4 class="mb-4 fw-bold text-center">ID Activation</h4>
                             
                             <form>
                                <div class="row g-4">
                                  <div class="col-12">
                                      <label for="memberid" class="form-label">Member ID</label>
                                      <input type="text" class="form-control rounded-0" id="memberid" name="memberid">
                                  </div> 
                                  <div class="col-12">
                                      <label for="verify-name" class="form-label">Verify Name</label>
                                      <input type="text" class="form-control rounded-0" id="verify-name" name="verify-name">
                                  </div>   
                                  <div class="col-12">
                                    <label for="activationmode" class="form-label">Activation Mode</label>
                                    <select name="activationmode" id="activationmode" class="form-control">
                                        <option value="">select</option>
                                        <option value="">service</option>
                                        <option value="">store</option>

                                    </select>
                                  </div>
                                  <div class="col-12">
                                    <button type="button" class="btn btn-dark rounded-0 btn-ecomm w-100">Activate</button>
                                  </div>
                                  
                                </div><!---end row-->
                             </form>
                           </div>
                         </div>
                      </div>
                    </div><!--end row-->
                   
                </div>
              </section>
            

             <!--end row-->


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