<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">A</div>
        <span class="brand-name">AddMagPro</span>
    </div>
    <div class="sidebar-scroll">
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="ri-dashboard-line nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <div class="sidebar-label">Settlements</div>
            <li class="nav-item">
                <a href="{{ route('backtwoback_settle') }}" class="nav-link {{ request()->routeIs('backtwoback_settle') ? 'active' : '' }}">
                    <i class="ri-swap-line nav-icon"></i>
                    <span class="nav-text">Back 2 Back</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pool_amount_settle') }}" class="nav-link {{ request()->routeIs('pool_amount_settle') ? 'active' : '' }}">
                    <i class="ri-coin-line nav-icon"></i>
                    <span class="nav-text">Pool Amount</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin_id_activation') }}" class="nav-link {{ request()->routeIs('admin_id_activation') ? 'active' : '' }}">
                    <i class="ri-fingerprint-line nav-icon"></i>
                    <span class="nav-text">ID Activation</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pin_system') }}" class="nav-link {{ request()->routeIs('pin_system') ? 'active' : '' }}">
                    <i class="ri-coupon-line nav-icon"></i>
                    <span class="nav-text">PIN System</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('product_wallet_convertion') }}" class="nav-link {{ request()->routeIs('product_wallet_convertion') ? 'active' : '' }}">
                    <i class="ri-wallet-3-line nav-icon"></i>
                    <span class="nav-text">Product Wallet</span>
                </a>
            </li>

            <div class="sidebar-label">Orders</div>
            <li class="nav-item">
                <a href="#ordersSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('delivered_products','shipping_products','packaging_products') ? 'true' : 'false' }}">
                    <i class="ri-shopping-bag-3-line nav-icon"></i>
                    <span class="nav-text">Products Ordered</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('delivered_products','shipping_products','packaging_products') ? 'show' : '' }}" id="ordersSubmenu">
                    <li><a href="{{ route('delivered_products') }}" class="nav-link {{ request()->routeIs('delivered_products') ? 'active' : '' }}">Delivered</a></li>
                    <li><a href="{{ route('shipping_products') }}" class="nav-link {{ request()->routeIs('shipping_products') ? 'active' : '' }}">Shipping</a></li>
                    <li><a href="{{ route('packaging_products') }}" class="nav-link {{ request()->routeIs('packaging_products') ? 'active' : '' }}">Packaging</a></li>
                </ul>
            </li>

            <div class="sidebar-label">Content</div>
            <li class="nav-item">
                <a href="#bannersSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('add_banner','banner_list') ? 'true' : 'false' }}">
                    <i class="ri-image-line nav-icon"></i>
                    <span class="nav-text">Banners</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('add_banner','banner_list') ? 'show' : '' }}" id="bannersSubmenu">
                    <li><a href="{{ route('add_banner') }}" class="nav-link {{ request()->routeIs('add_banner') ? 'active' : '' }}">Add Banner</a></li>
                    <li><a href="{{ route('banner_list') }}" class="nav-link {{ request()->routeIs('banner_list') ? 'active' : '' }}">Banner List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#gallerySubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('add_gallery','gallery_list') ? 'true' : 'false' }}">
                    <i class="ri-gallery-line nav-icon"></i>
                    <span class="nav-text">Gallery</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('add_gallery','gallery_list') ? 'show' : '' }}" id="gallerySubmenu">
                    <li><a href="{{ route('add_gallery') }}" class="nav-link {{ request()->routeIs('add_gallery') ? 'active' : '' }}">Add Gallery</a></li>
                    <li><a href="{{ route('gallery_list') }}" class="nav-link {{ request()->routeIs('gallery_list') ? 'active' : '' }}">Gallery List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#gadgetSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('add_gadget_gallery','gadget_gallery_list') ? 'true' : 'false' }}">
                    <i class="ri-smartphone-line nav-icon"></i>
                    <span class="nav-text">Gadget Gallery</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('add_gadget_gallery','gadget_gallery_list') ? 'show' : '' }}" id="gadgetSubmenu">
                    <li><a href="{{ route('add_gadget_gallery') }}" class="nav-link {{ request()->routeIs('add_gadget_gallery') ? 'active' : '' }}">Add Gallery</a></li>
                    <li><a href="{{ route('gadget_gallery_list') }}" class="nav-link {{ request()->routeIs('gadget_gallery_list') ? 'active' : '' }}">Gallery List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#storeImgSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('add_store_image','store_images_list') ? 'true' : 'false' }}">
                    <i class="ri-store-2-line nav-icon"></i>
                    <span class="nav-text">Speciality Store</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('add_store_image','store_images_list') ? 'show' : '' }}" id="storeImgSubmenu">
                    <li><a href="{{ route('add_store_image') }}" class="nav-link {{ request()->routeIs('add_store_image') ? 'active' : '' }}">Add Images</a></li>
                    <li><a href="{{ route('store_images_list') }}" class="nav-link {{ request()->routeIs('store_images_list') ? 'active' : '' }}">Image List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#adsBannerSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('add_ads_banner','ads_banner') ? 'true' : 'false' }}">
                    <i class="ri-advertisement-line nav-icon"></i>
                    <span class="nav-text">Ads Banner</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('add_ads_banner','ads_banner') ? 'show' : '' }}" id="adsBannerSubmenu">
                    <li><a href="{{ route('add_ads_banner') }}" class="nav-link {{ request()->routeIs('add_ads_banner') ? 'active' : '' }}">Add Ads Banner</a></li>
                    <li><a href="{{ route('ads_banner') }}" class="nav-link {{ request()->routeIs('ads_banner') ? 'active' : '' }}">Banner List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#eventBannerSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('add_events_banner','events_banner') ? 'true' : 'false' }}">
                    <i class="ri-calendar-event-line nav-icon"></i>
                    <span class="nav-text">Event Banner</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('add_events_banner','events_banner') ? 'show' : '' }}" id="eventBannerSubmenu">
                    <li><a href="{{ route('add_events_banner') }}" class="nav-link {{ request()->routeIs('add_events_banner') ? 'active' : '' }}">Add Event Banner</a></li>
                    <li><a href="{{ route('events_banner') }}" class="nav-link {{ request()->routeIs('events_banner') ? 'active' : '' }}">Banner List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#headingSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('home_heading_name','home_heading_list') ? 'true' : 'false' }}">
                    <i class="ri-heading nav-icon"></i>
                    <span class="nav-text">Home Headings</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('home_heading_name','home_heading_list') ? 'show' : '' }}" id="headingSubmenu">
                    <li><a href="{{ route('home_heading_name') }}" class="nav-link {{ request()->routeIs('home_heading_name') ? 'active' : '' }}">Add Heading</a></li>
                    <li><a href="{{ route('home_heading_list') }}" class="nav-link {{ request()->routeIs('home_heading_list') ? 'active' : '' }}">Heading List</a></li>
                </ul>
            </li>

            <div class="sidebar-label">Users</div>
            <li class="nav-item">
                <a href="#usersSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('cashbackusers','active_users','serviceusers') ? 'true' : 'false' }}">
                    <i class="ri-group-line nav-icon"></i>
                    <span class="nav-text">Users</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('cashbackusers','active_users','serviceusers') ? 'show' : '' }}" id="usersSubmenu">
                    <li><a href="{{ route('cashbackusers') }}" class="nav-link {{ request()->routeIs('cashbackusers') ? 'active' : '' }}">Visitors</a></li>
                    <li><a href="{{ route('active_users') }}" class="nav-link {{ request()->routeIs('active_users') ? 'active' : '' }}">Active Users</a></li>
                    <li><a href="{{ route('serviceusers') }}" class="nav-link {{ request()->routeIs('serviceusers') ? 'active' : '' }}">Service Users</a></li>
                </ul>
            </li>

            <div class="sidebar-label">Finance</div>
            <li class="nav-item">
                <a href="#withdrawSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('pending_withdrawal','accepted_withdrawal','rejected_withdrawal') ? 'true' : 'false' }}">
                    <i class="ri-money-dollar-box-line nav-icon"></i>
                    <span class="nav-text">Withdrawal</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('pending_withdrawal','accepted_withdrawal','rejected_withdrawal') ? 'show' : '' }}" id="withdrawSubmenu">
                    <li><a href="{{ route('pending_withdrawal') }}" class="nav-link {{ request()->routeIs('pending_withdrawal') ? 'active' : '' }}">Pending</a></li>
                    <li><a href="{{ route('accepted_withdrawal') }}" class="nav-link {{ request()->routeIs('accepted_withdrawal') ? 'active' : '' }}">Accepted</a></li>
                    <li><a href="{{ route('rejected_withdrawal') }}" class="nav-link {{ request()->routeIs('rejected_withdrawal') ? 'active' : '' }}">Rejected</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('vendor_pending_withdrawal') }}" class="nav-link {{ request()->routeIs('vendor_pending_withdrawal') ? 'active' : '' }}">
                    <i class="ri-bank-line nav-icon"></i>
                    <span class="nav-text">Vendor Withdrawal</span>
                </a>
            </li>

            <div class="sidebar-label">Marketplace</div>
            <li class="nav-item">
                <a href="#vendorsSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('approvedstores','pendingstores','discount_vendors') ? 'true' : 'false' }}">
                    <i class="ri-store-line nav-icon"></i>
                    <span class="nav-text">Vendors</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('approvedstores','pendingstores','discount_vendors') ? 'show' : '' }}" id="vendorsSubmenu">
                    <li><a href="{{ route('approvedstores') }}" class="nav-link {{ request()->routeIs('approvedstores') ? 'active' : '' }}">Approved Vendors</a></li>
                    <li><a href="{{ route('pendingstores') }}" class="nav-link {{ request()->routeIs('pendingstores') ? 'active' : '' }}">Pending Vendors</a></li>
                    <li><a href="{{ route('discount_vendors') }}" class="nav-link {{ request()->routeIs('discount_vendors') ? 'active' : '' }}">Discount Vendors</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#servicesSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('add_service','service_list') ? 'true' : 'false' }}">
                    <i class="ri-settings-3-line nav-icon"></i>
                    <span class="nav-text">Services</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('add_service','service_list') ? 'show' : '' }}" id="servicesSubmenu">
                    <li><a href="{{ route('add_service') }}" class="nav-link {{ request()->routeIs('add_service') ? 'active' : '' }}">Add Service</a></li>
                    <li><a href="{{ route('service_list') }}" class="nav-link {{ request()->routeIs('service_list') ? 'active' : '' }}">Service List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#classifiedsSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('add_classified','classified_list') ? 'true' : 'false' }}">
                    <i class="ri-list-check-2 nav-icon"></i>
                    <span class="nav-text">Classifieds</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('add_classified','classified_list') ? 'show' : '' }}" id="classifiedsSubmenu">
                    <li><a href="{{ route('add_classified') }}" class="nav-link {{ request()->routeIs('add_classified') ? 'active' : '' }}">Add Classified</a></li>
                    <li><a href="{{ route('classified_list') }}" class="nav-link {{ request()->routeIs('classified_list') ? 'active' : '' }}">Classifieds List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#storesSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('add_store','store_list') ? 'true' : 'false' }}">
                    <i class="ri-building-2-line nav-icon"></i>
                    <span class="nav-text">Stores</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('add_store','store_list') ? 'show' : '' }}" id="storesSubmenu">
                    <li><a href="{{ route('add_store') }}" class="nav-link {{ request()->routeIs('add_store') ? 'active' : '' }}">Add Store</a></li>
                    <li><a href="{{ route('store_list') }}" class="nav-link {{ request()->routeIs('store_list') ? 'active' : '' }}">Store List</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#franchiseSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('allfranchise','activefranchise','inactivefranchise') ? 'true' : 'false' }}">
                    <i class="ri-map-pin-line nav-icon"></i>
                    <span class="nav-text">Franchise</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('allfranchise','activefranchise','inactivefranchise') ? 'show' : '' }}" id="franchiseSubmenu">
                    <li><a href="{{ route('allfranchise') }}" class="nav-link {{ request()->routeIs('allfranchise') ? 'active' : '' }}">All Franchises</a></li>
                    <li><a href="{{ route('activefranchise') }}" class="nav-link {{ request()->routeIs('activefranchise') ? 'active' : '' }}">Active</a></li>
                    <li><a href="{{ route('inactivefranchise') }}" class="nav-link {{ request()->routeIs('inactivefranchise') ? 'active' : '' }}">Inactive</a></li>
                </ul>
            </li>

            <div class="sidebar-label">Admin</div>
            <li class="nav-item">
                <a href="{{ route('admin_logout') }}" class="nav-link" style="color:#ff4d4f;">
                    <i class="ri-logout-box-line nav-icon"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
