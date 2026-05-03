@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php @extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($active_franchise as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">
                  {{ @extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php @extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($active_franchise as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p = $active_franchise; @endphp
                        @forelse(@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($active_franchise as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p->links() }}
                </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p = $active_franchise; @endphp
                        @forelse(@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($active_franchise as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">
                  {{ @extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php @extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($active_franchise as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p = $active_franchise; @endphp
                        @forelse(@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($active_franchise as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p->links() }}
                </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                <div class="card-footer admin-card-footer d-flex justify-content-end">
                  {{ @extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php @extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($active_franchise as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p = $active_franchise; @endphp
                        @forelse(@extends('layouts.master')
@section('mainsection')
      
      <div class="admin-page">
        <section class="admin-section">
          <div class="admin-section-body">

      {{-- Page Header --}}
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h2 class="mb-0 fw-bold" style="font-size:1.4rem;">Active Franchises</h2>
        </div>
      </div>
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card admin-card">
                  <div class="card-header admin-card-header">
                    <h4>Active Franchises</h4>
                  </div>
                  <div class="card-body admin-card-body p-0">
                    <div class="table-responsive">
                      <table class="table admin-table align-middle mb-0">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Franchise_Name</th>
                          <th>Franchise_Owner</th>
                          <th>Location</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th>Franchise_start_date</th>
                          <th>Status</th>
                          <th>Revenue</th>
                          <th>Expenses</th>
                          <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($active_franchise as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p as $index=>$active_franchise)
                        <tr>
                        <td>{{$index+1}}</td>
                          <td>{{$active_franchise->franchise_name}}</td>
                          <td>{{$active_franchise->franchise_owner}}</td>
                          <td>{{$active_franchise->franchise_location}}</td>
                          <td>{{$active_franchise->franchise_phone}}</td>
                          <td>{{$active_franchise->franchise_email}}</td>
                          <td>{{$active_franchise->franchise_type}}</td>
                          <td>{{$active_franchise->franchise_start_date}}</td>
                          <td>
                            <div class="status-badge badge-approved">Active</div>
                          </td>
                          <td>{{$active_franchise->franchise_revenue}}</td>
                          <td>{{$active_franchise->franchise_expenses}}</td>
                          <td>{{$active_franchise->franchise_profit}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="12" class="text-center text-muted py-4">No records found.</td></tr>
                      @endforelse
                      </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer admin-card-footer d-flex justify-content-end">
                    <nav>
                      <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#"><i class="ri-arrow-left-s-line"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="ri-arrow-right-s-line"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection_p->links() }}
                </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection