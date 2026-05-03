@extends('service_user_dashboard_layouts.master')
@section('mainsection')
          <div class="col-12 col-xl-9">
             
             <div class="switch-buttons col-12 p-3 " style="border: 1px black solid;">
              <div class="row">
                <div class="edit-button  d-flex justify-content-center col-6">
                    <a  class="btn btn-outline-dark btn-ecomm " id="referralteam-button">Referal Team</a>
                  </div>
                  <div class="edit-button d-flex justify-content-center col-6">
                    <a  class="btn btn-outline-dark btn-ecomm" id="totalteam-button">Total Team</a>
                  </div>
              </div>

             </div>
             <div class="col-12" id="refferal-team">
                     <div class="container">
                        <div class="table-wrapper">
                          <table class="table stripped">
                            <tr>
                                <th><h5>S.No</h5></th>
                                <th><h5>Name</h5></th>
                                <th><h5>Mobile</h5></th>
                                <th><h5>Location</h5></th>
                                <th><h5>Date</h5></th>
                            </tr>
                            @foreach($referred_users_by_login_person as $index=> $referred_user)
                            <tr>
                                <td>{{$index+1}} </td>
                                <td>{{$referred_user['member_name']}} </td>
                                <td>{{$referred_user['member_phone']}} </td>
                                <td>{{$referred_user['location']}} </td>
                                <td>
                                    <?php 
                                        $timestamp = strtotime($referred_user['created_at']);
                                        $formatted_date = date('j F Y', $timestamp);
                                        echo $formatted_date;
                                    ?>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        </div>
                     </div>
             </div>
<!-- total team table starts -->
             <div class="col-12" id="total-team">
                <div class="container">
                  <div class="table-wrapper">
                    <table class="table stripped">
                      <tr>
                        <th><h5>S.No</h5></th>
                        <th><h5>Name</h5></th>
                        <th><h5>Mobile</h5></th>
                        <th><h5>Location</h5></th>
                        <th><h5>Date</h5></th>
                      </tr>
                      @foreach($chain_users as $index=> $referred_user)
                            <tr>
                                <td>{{$index+1}} </td>
                                <td>{{$referred_user['member_name']}} </td>
                                <td>{{$referred_user['member_phone']}} </td>
                                <td>{{$referred_user['location']}} </td>
                                <td>
                                    <?php 
                                        $timestamp = strtotime($referred_user['created_at']);
                                        $formatted_date = date('j F Y', $timestamp);
                                        echo $formatted_date;
                                    ?>
                                </td>
                            </tr>
                            @endforeach
                  </table>
                  </div>
                   <!-- total team table ends -->
                </div>
        </div>

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