<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <!-- <a href="index.html"> <img alt="image" src="{{asset('assets/img/logo.png')}}" class="header-logo" /> <span -->
            <a href="index.html"> <img alt="image" src="{{asset('assets/vendor_assets/images/logo.png')}}" class="header-logo" /> <span
                class="logo-name"></span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <!-- <li class="menu-header">Main</li> -->
            <li class="dropdown active">
              <a href="{{route('home')}}" class="nav-link"><i data-feather="bar-chart-2"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
              <a href="{{route('backtwoback_settle')}}" class="nav-link"><i data-feather="bar-chart-2"></i><span>Back 2 Back Settlement</span></a>
            </li>
            <li class="dropdown">
              <a href="{{route('pool_amount_settle')}}" class="nav-link"><i data-feather="bar-chart-2"></i><span>Pool Amount Settlement</span></a>
            </li>
            <li class="dropdown">
              <a href="{{route('admin_id_activation')}}" class="nav-link"><i data-feather="bar-chart-2"></i><span>ID Activation</span></a>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="map-pin"></i><span>Products Ordered</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('delivered_products')}}">Delivered Products</a></li>
                <li><a class="nav-link" href="{{route('shipping_products')}}">Shipping Products</a></li>
                <li><a class="nav-link" href="{{route('packaging_products')}}">Packaging Products</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="map-pin"></i><span>Banners</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('add_banner')}}">Add Banner</a></li>
                <li><a class="nav-link" href="{{route('banner_list')}}">Banner List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="map-pin"></i><span>Gallery</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('add_gallery')}}">Add Gallery</a></li>
                <li><a class="nav-link" href="{{route('gallery_list')}}">Gallery List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="map-pin"></i><span>Gadget Gallery</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('add_gadget_gallery')}}">Add Gallery</a></li>
                <li><a class="nav-link" href="{{route('gadget_gallery_list')}}">Gallery List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="map-pin"></i><span>Speciality Store</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('add_store_image')}}">Add Store Images</a></li>
                <li><a class="nav-link" href="{{route('store_images_list')}}">Store Images List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="map-pin"></i><span>Ads Banner</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('add_ads_banner')}}">Add Ads Banner</a></li>
                <li><a class="nav-link" href="{{route('ads_banner')}}">Ads Banner List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="map-pin"></i><span>Event Banner</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('add_events_banner')}}">Add events Banner</a></li>
                <li><a class="nav-link" href="{{route('events_banner')}}">Events Banner List</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="map-pin"></i><span>Home Page Headings</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('home_heading_name')}}">Add Heading Name</a></li>
                <li><a class="nav-link" href="{{route('home_heading_list')}}">Heading List</a></li>
              </ul>
            </li>
           
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="users"></i><span>Users</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('cashbackusers')}}">Visitors</a></li>
                <li><a class="nav-link" href="{{route('active_users')}}">Active Users</a></li>
                <!-- <li><a class="nav-link" href="{{route('productusers')}}">Product & Service Users</a></li> -->
                <li><a class="nav-link" href="{{route('serviceusers')}}">Service Users</a></li>
                <!-- <li><a class="nav-link" href="calendar.html">Calendar</a></li> -->
              </ul>
            </li>

            <li class="menu-header">UI Elements</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="arrow-up"></i><span>Withdrawal Request</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('pending_withdrawal')}}">Pending Requests</a></li>
                <li><a class="nav-link" href="{{route('accepted_withdrawal')}}">Accepted Requests</a></li>
                <li><a class="nav-link" href="{{route('rejected_withdrawal')}}">Rejected Requests</a></li>
                
              </ul>
            </li>


            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="shopping-bag"></i><span>Vendors</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('approvedstores')}}">Approved Product Vendors</a></li>
                <!-- <li><a class="nav-link" href="{{route('rejectedstores')}}">Rejected Vendors</a></li> -->
                <li><a class="nav-link" href="{{route('pendingstores')}}">Pending Product Vendors</a></li>
                <li><a class="nav-link" href="{{route('discount_vendors')}}">Discount Vendors</a></li>
               
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="shopping-bag"></i><span>Services</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('add_service')}}">Add Service</a></li>
                <li><a class="nav-link" href="{{route('service_list')}}">Service List</a></li>
               
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="shopping-bag"></i><span>Classifieds</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('add_classified')}}">Add Classifieds</a></li>
                <li><a class="nav-link" href="{{route('classified_list')}}">Classifieds List</a></li>
               
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="shopping-bag"></i><span>Stores</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('add_store')}}">Add Store</a></li>
                <li><a class="nav-link" href="{{route('store_list')}}">Store List</a></li>
               
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="map-pin"></i><span>Franchise</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('allfranchise')}}">All Franchises</a></li>
                <li><a class="nav-link" href="{{route('activefranchise')}}">Active Franchise</a></li>
                <li><a class="nav-link" href="{{route('inactivefranchise')}}">Inactive Franchise</a></li>
              </ul>
            </li>
            <li><a class="nav-link" href="{{route('home')}}"><i data-feather="mail"></i><span>Contact Us</span></a></li>
            <li><a class="nav-link" href="{{route('home')}}"><i data-feather="settings"></i><span>Admin Settings</span></a></li>
            <li><a class="nav-link" href="{{route('home')}}"><i data-feather="help-circle"></i><span>Support</span></a></li>
            <li><a class="nav-link" href="{{route('home')}}"><i data-feather="key"></i><span>Change Password</span></a></li>
            <li><a class="nav-link" href="{{route('admin_logout')}}"><i data-feather="log-out"></i><span>Logout</span></a></li>
            
        </aside>
      </div>