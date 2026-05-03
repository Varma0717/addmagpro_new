<div class="pcoded-main-container">
              <div class="pcoded-wrapper">
                  <nav class="pcoded-navbar">
                      <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                      <div class="pcoded-inner-navbar main-menu">
                          <div class="">
                              <div class="main-menu-header">
                                  <img class="img-80 img-radius" src="{{asset(session('profile_image'))}}" alt="User-Profile-Image">
                                  <div class="user-details">
                                      <span id="more-details">{{session('vendor_name')}}<i class="fa fa-caret-down"></i></span>
                                  </div>
                              </div>
        
                              <div class="main-menu-content">
                                  <ul>
                                      <li class="more-details">
                                          <a href="{{route('vendor_profile')}}"><i class="ti-user"></i>View Profile</a>
                                          <a href="{{route('vendor_settings')}}"><i class="ti-settings"></i>Settings</a>
                                          <a href="{{route('vendor_logout')}}"><i class="ti-layout-sidebar-left"></i>Logout</a>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                          
                          <div class="pcoded-navigation-label" data-i18n="nav.category.navigation"></div>
                          <ul class="pcoded-item pcoded-left-item">
                              <li class="active">
                                  <a href="{{route('vendor_dashboard')}}" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                      <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                      <span class="pcoded-mcaret"></span>
                                  </a>
                              </li>
                              
                          </ul>

                          <ul class="pcoded-item pcoded-left-item">
                              <li>
                                  <a href="{{route('vendor_banner')}}" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                      <span class="pcoded-mtext" data-i18n="nav.form-components.main">Vendor Banner</span>
                                      <span class="pcoded-mcaret"></span>
                                  </a>
                              </li>                    
                          </ul>

                          <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Order Management</div>

                          <ul class="pcoded-item pcoded-left-item">
                            <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Orders</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class=" ">
                                        <a href="{{route('vendor_order_list')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">All</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                   
                                </ul>
                            </li>
                        


                            <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layers"></i></span>
                                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Category</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class=" ">
                                        <a href="{{route('vendor_new_category')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Add New</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="{{route('vendor_category_list')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">List</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                   
                                </ul>
                            </li>


                            <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">Brand</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class=" ">
                                        <a href="{{route('vendor_new_brand')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Add New</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="{{route('vendor_brand_list')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">List</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                   
                                </ul>
                            </li>
                        
                             


                            <li class="pcoded-hasmenu">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                                    <span class="pcoded-mtext"  data-i18n="nav.basic-components.main">In House Products</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class=" ">
                                        <a href="{{route('new_product')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Add New Product</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <!-- <li class=" ">
                                        <a href="#" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Bulk Import</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li> -->
                                    <li class=" ">
                                        <a href="{{route('products_list_vendors')}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert"> Products List</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                   
                                </ul>
                            </li>
                        </ul>
        
                          <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Help &amp; Support</div>
                          <ul class="pcoded-item pcoded-left-item">
                              <li>
                                  <a href="#" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                      <span class="pcoded-mtext" data-i18n="nav.form-components.main">Messages</span>
                                      <span class="pcoded-mcaret"></span>
                                  </a>
                              </li>
                              <li>
                                  <a href="#" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                      <span class="pcoded-mtext" data-i18n="nav.form-components.main">Support Ticket</span>
                                      <span class="pcoded-mcaret"></span>
                                  </a>
                              </li>
                              
        
                          </ul>
        
                          <div class="pcoded-navigation-label" data-i18n="nav.category.other">Other</div>
                          <ul class="pcoded-item pcoded-left-item">
                              <li class="pcoded-hasmenu ">
                                  <a href="{{route('vendor_settings')}}" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-direction-alt"></i><b></b></span>
                                      <span class="pcoded-mtext" data-i18n="nav.menu-levels.main">Settings</span>
                                      <span class="pcoded-mcaret"></span>
                                  </a>
                                  
                              </li>
                          </ul>
                      </div>
                  </nav>