<nav class="admin-topbar" id="adminTopbar">
    <div class="topbar-left">
        <button class="sidebar-toggle-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
            <i class="ri-menu-line"></i>
        </button>
        <span class="page-title d-none d-md-block">Vendor Panel</span>
    </div>
    <div class="topbar-right">
        <a href="{{ route('welcome_page') }}" class="topbar-icon-btn" target="_blank" title="View Store">
            <i class="ri-external-link-line"></i>
        </a>
        <div class="topbar-user-dropdown dropdown">
            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if(session('profile_image'))
                <img src="{{ asset(session('profile_image')) }}" alt="Vendor" class="user-avatar">
                @else
                <div style="width:36px;height:36px;border-radius:50%;background:var(--theme-color);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">
                    {{ strtoupper(substr(session('vendor_name','V'), 0, 1)) }}
                </div>
                @endif
                <div class="d-none d-md-block text-start">
                    <div class="user-name">{{ session('vendor_name', 'Vendor') }}</div>
                    <div class="user-role">Vendor</div>
                </div>
                <i class="ri-arrow-down-s-line" style="font-size:.9rem;color:#888;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('vendor_profile') }}">
                        <i class="ri-user-line"></i> View Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('vendor_settings') }}">
                        <i class="ri-settings-3-line"></i> Settings
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('vendor_logout') }}">
                        <i class="ri-logout-box-line"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
