@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Pending Withdrawal</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Pending Withdrawal</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Withdrawal Amount</th>
                            <th>Bank Name</th>
                            <th>Account No</th>
                            <th>IFSC</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($pending_withdrawals as $index=> $accepted_withdrawal)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$accepted_withdrawal->user_name}}</td>
                          <td>{{$accepted_withdrawal->Amount}}</td>
                          <td>{{$accepted_withdrawal->bank_name}}</td>
                          <td>{{$accepted_withdrawal->account_number}}</td>
                          <td>{{$accepted_withdrawal->ifsc}}</td>
                          <td>{{$accepted_withdrawal->RequestDate}}</td>
                          <td>
                              @if($accepted_withdrawal->Status=='pending')
                                <div class="status-badge badge-pending">Pending</div>
                              @elseif($accepted_withdrawal->Status=='approved')
                                <div class="status-badge badge-approved">Accepted</div>
                              @elseif($accepted_withdrawal->Status=='rejected')
                                <div class="status-badge badge-rejected">Rejected</div>
                              @endif
                          </td>
                          <td>
                            <a href="{{route('update_withdrawal_request',['user_id'=>$accepted_withdrawal->RequestID])}}" class="status-badge badge-rejected">Update</a>
                          </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">
                  {{ $pending_withdrawals->links() }}
                </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection