<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">V</div>
        <span class="brand-name">Vendor Panel</span>
    </div>
    <div class="sidebar-scroll">
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('vendor_dashboard') }}" class="nav-link {{ request()->routeIs('vendor_dashboard') ? 'active' : '' }}">
                    <i class="ri-dashboard-line nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vendor_banner') }}" class="nav-link {{ request()->routeIs('vendor_banner') ? 'active' : '' }}">
                    <i class="ri-image-line nav-icon"></i>
                    <span class="nav-text">Vendor Banner</span>
                </a>
            </li>

            <div class="sidebar-label">Order Management</div>
            <li class="nav-item">
                <a href="{{ route('vendor_order_list') }}" class="nav-link {{ request()->routeIs('vendor_order_list') ? 'active' : '' }}">
                    <i class="ri-shopping-bag-3-line nav-icon"></i>
                    <span class="nav-text">All Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#categorySubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('vendor_new_category','vendor_category_list') ? 'true' : 'false' }}">
                    <i class="ri-list-check-2 nav-icon"></i>
                    <span class="nav-text">Category</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('vendor_new_category','vendor_category_list') ? 'show' : '' }}" id="categorySubmenu">
                    <li><a href="{{ route('vendor_new_category') }}" class="nav-link {{ request()->routeIs('vendor_new_category') ? 'active' : '' }}">Add New</a></li>
                    <li><a href="{{ route('vendor_category_list') }}" class="nav-link {{ request()->routeIs('vendor_category_list') ? 'active' : '' }}">Category List</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#brandSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('vendor_new_brand','vendor_brand_list') ? 'true' : 'false' }}">
                    <i class="ri-price-tag-3-line nav-icon"></i>
                    <span class="nav-text">Brand</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('vendor_new_brand','vendor_brand_list') ? 'show' : '' }}" id="brandSubmenu">
                    <li><a href="{{ route('vendor_new_brand') }}" class="nav-link {{ request()->routeIs('vendor_new_brand') ? 'active' : '' }}">Add New</a></li>
                    <li><a href="{{ route('vendor_brand_list') }}" class="nav-link {{ request()->routeIs('vendor_brand_list') ? 'active' : '' }}">Brand List</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#productsSubmenu" class="nav-link" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('new_product','products_list_vendors') ? 'true' : 'false' }}">
                    <i class="ri-box-3-line nav-icon"></i>
                    <span class="nav-text">Products</span>
                    <i class="ri-arrow-right-s-line submenu-arrow ms-auto"></i>
                </a>
                <ul class="sidebar-submenu collapse {{ request()->routeIs('new_product','products_list_vendors') ? 'show' : '' }}" id="productsSubmenu">
                    <li><a href="{{ route('new_product') }}" class="nav-link {{ request()->routeIs('new_product') ? 'active' : '' }}">Add New Product</a></li>
                    <li><a href="{{ route('products_list_vendors') }}" class="nav-link {{ request()->routeIs('products_list_vendors') ? 'active' : '' }}">Products List</a></li>
                </ul>
            </li>

            <div class="sidebar-label">Account</div>
            <li class="nav-item">
                <a href="{{ route('vendor_profile') }}" class="nav-link {{ request()->routeIs('vendor_profile') ? 'active' : '' }}">
                    <i class="ri-user-line nav-icon"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vendor_settings') }}" class="nav-link {{ request()->routeIs('vendor_settings') ? 'active' : '' }}">
                    <i class="ri-settings-3-line nav-icon"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('vendor_logout') }}" class="nav-link" style="color:#ff4d4f;">
                    <i class="ri-logout-box-line nav-icon"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
