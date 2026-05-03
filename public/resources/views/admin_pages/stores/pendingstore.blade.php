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
                    <h4>Pending Stores</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md">
                          <tr>
                            <th>#</th>
                            <th>Store Name</th>
                            <th>Store Type</th>
                            <th>Address</th>
                            <!-- <th>City</th>
                            <th>Country</th>
                            <th>Postal/ZIP Code</th> -->
                            <th>Phone Number</th>
                            <th>Email</th>
                            <!-- <th>Opening Hours</th> -->
                            <!-- <th>Website</th> -->
                            <th>Store Manager</th>
                            <th>Store Description</th>
                            <!-- <th>Store Rating</th> -->
                            <th>Status</th>
                            <th>Update Status</th>
                        </tr>
                        @foreach($approved_stores as $index=>$approved_store)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$approved_store->business_name}}</td>
                          <td>{{$approved_store->business_type}}</td>
                          <td>{{$approved_store->business_address}}</td>
                          <!-- <td>{{$approved_store->City}}</td>
                          <td>{{$approved_store->Country}}</td>
                          <td>{{$approved_store->PostalCode}}</td> -->
                          <td>{{$approved_store->vendor_phone}}</td>
                          <td>{{$approved_store->vendor_email}}</td>
                          <!-- <td>{{$approved_store->OpeningHours}}</td> -->
                          <!-- <td>{{$approved_store->Website}}</td> -->
                          <td>{{$approved_store->vendor_name}}</td>
                          <td>{{$approved_store->vendor_name}}</td>
                          <td>
                              @if($approved_store->status=='Approved')
                                <div class="badge badge-success">Accepted</div>
                              @elseif($approved_store->status=='Pending')
                                <div class="badge badge-primary">Pending</div>
                              @elseif($approved_store->status=='Rejected')
                                <div class="badge badge-danger">Rejected</div>
                              @endif
                          </td>
                          <td><a href="{{route('update_status',['vendor_id'=>$approved_store->vendor_id])}}" class="badge badge-danger">Update Status</a></td>
                          <!-- <td><div class="badge badge-danger"><a href="update_status/{{$approved_store->vendor_id}}">Update Status</a></div></td> -->
                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    @include('admin_pages.partials.pagination', ['paginator' => $approved_stores])
                  </div>

                </div>
              </div>
              
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