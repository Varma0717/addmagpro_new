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
                    <h4>ID Activation For Products</h4>
                  </div>
                  <div class="card-body">
                  <form action="{{route('activate_id_in_products')}}" method="POST">
                    @csrf
                  
                    <div class="form-group">
                      <label>Phone Number (US Format)</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                          </div>
                        </div>
                        <input type="number" class="form-control phone-number" id="user_mobile" name="user_mobile" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary daterange-btn icon-left btn-icon"><i
                          class="fas fa-calendar"></i>Activate ID
                      </button>
                    </div>
                  </form>
                  </div>
                  <div class="card-footer text-right">
                  
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Service Users</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md">
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Mobile Number</th>
                            <th>Pan Card</th>
                            <th>Address</th>
                            <th>Service Type</th>
                            <th>Business Image</th>
                            <th>Service Status</th>
                            <th>Update Status</th>
                        </tr>
                        @foreach($services_business_listing_data as $index=>$service_users)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$service_users->member_name}}</td>
                          <td>{{$service_users->member_phone}}</td>
                          <td>{{$service_users->pan_number}}</td>
                          <td>{{$service_users->address}}</td>
                          <td>{{$service_users->service_name}}</td>
                          <td><img src="{{$service_users->business_image}}" alt="" width="60px" height="60px"></td>
                          <!-- <td>{{$service_users->status}}</td> -->
                          <td>
                            @if($service_users->status=='0')
                              <div class="badge badge-danger">Not Approved</div>
                            @elseif($service_users->status=='1')
                              <div class="badge badge-primary">Approved</div>
                            @endif
                          </td>
                          <td>
                              <a href="{{ route('id_activation_update', ['id' => $service_users->service_user_id]) }}" class="badge badge-primary">Update</a>
                          </td>

                        </tr>
                        @endforeach
                        @foreach($stores_business_listing_data as $index=>$service_users)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$service_users->member_name}}</td>
                          <td>{{$service_users->member_phone}}</td>
                          <td>{{$service_users->pan_number}}</td>
                          <td>{{$service_users->address}}</td>
                          <td>{{$service_users->StoreName}}</td>
                          <td><img src="{{$service_users->business_image}}" alt="" width="60px" height="60px"></td>
                          <!-- <td>{{$service_users->status}}</td> -->
                          <td>
                            @if($service_users->status=='0')
                              <div class="badge badge-danger">Not Approved</div>
                            @elseif($service_users->status=='1')
                              <div class="badge badge-primary">Approved</div>
                            @endif
                          </td>
                          <td>
                              <a href="{{ route('id_activation_update', ['id' => $service_users->service_user_id]) }}" class="badge badge-primary">Update</a>
                          </td>

                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    @include('admin_pages.partials.pagination', ['paginator' => $services_business_listing_data])
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