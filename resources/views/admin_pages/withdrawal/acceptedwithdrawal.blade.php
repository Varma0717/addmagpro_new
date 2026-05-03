@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Accepted Withdrawal</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Accepted Withdrawal</h4>
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
                            <th>Approved Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($approved_withdrawals as $index=> $accepted_withdrawal)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$accepted_withdrawal->user_name}}</td>
                          <td>{{$accepted_withdrawal->Amount}}</td>
                          <td>{{$accepted_withdrawal->bank_name}}</td>
                          <td>{{$accepted_withdrawal->account_number}}</td>
                          <td>{{$accepted_withdrawal->ifsc}}</td>
                          <td>{{$accepted_withdrawal->CompletionDate}}</td>
                          <td>
                              @if($accepted_withdrawal->Status=='pending')
                                <div class="status-badge badge-pending">Pending</div>
                              @elseif($accepted_withdrawal->Status=='approved')
                                <div class="status-badge badge-approved">Accepted</div>
                              @elseif($accepted_withdrawal->Status=='rejected')
                                <div class="status-badge badge-rejected">Rejected</div>
                              @endif
                          </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">
                  {{ $approved_withdrawals->links() }}
                </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection