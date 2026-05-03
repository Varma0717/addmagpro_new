@extends('layouts.master')
@section('mainsection')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <!-- add content here -->
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Pending KYC</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>KYC Status</th>
                            <th>Approved Date</th>
                        </tr>
                        @foreach($pending_kyc as $index=>$pending_kyc_item)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$pending_kyc_item->full_name}}</td>
                          <td>
                            @if($pending_kyc_item->kyc_status=='Approved')
                              <div class="badge badge-success">Accepted</div>
                            @elseif($pending_kyc_item->kyc_status=='Pending')
                              <div class="badge badge-primary">Pending</div>
                            @elseif($pending_kyc_item->kyc_status=='Rejected')
                              <div class="badge badge-danger">Rejected</div>
                            @endif
                          </td>
                          <td>{{$pending_kyc_item->	approved_date}}</td>
                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    @include('admin_pages.partials.pagination', ['paginator' => $pending_kyc])
                  </div>

                </div>
              </div>
              <!-- <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Full Width</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Created At</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>Irwansyah Saputra</td>
                          <td>2017-01-09</td>
                          <td>
                            <div class="badge badge-success">Active</div>
                          </td>
                          <td><a href="#" class="btn btn-primary">Detail</a></td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Hasan Basri</td>
                          <td>2017-01-09</td>
                          <td>
                            <div class="badge badge-success">Active</div>
                          </td>
                          <td><a href="#" class="btn btn-primary">Detail</a></td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Kusnadi</td>
                          <td>2017-01-11</td>
                          <td>
                            <div class="badge badge-danger">Not Active</div>
                          </td>
                          <td><a href="#" class="btn btn-primary">Detail</a></td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>Rizal Fakhri</td>
                          <td>2017-01-11</td>
                          <td>
                            <div class="badge badge-success">Active</div>
                          </td>
                          <td><a href="#" class="btn btn-primary">Detail</a></td>
                        </tr>
                        <tr>
                          <td>5</td>
                          <td>Isnap Kiswandi</td>
                          <td>2017-01-17</td>
                          <td>
                            <div class="badge badge-success">Active</div>
                          </td>
                          <td><a href="#" class="btn btn-primary">Detail</a></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block">
                      <ul class="pagination mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1 <span
                              class="sr-only">(current)</span></a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
        </section>
        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection()