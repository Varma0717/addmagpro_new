<nav class="admin-topbar" id="adminTopbar">
    <div class="topbar-left">
        <button class="sidebar-toggle-btn" onclick="toggleSidebar()" title="Toggle Sidebar">
            <i class="ri-menu-line"></i>
        </button>
        <span class="page-title d-none d-md-block">AddMagPro Admin</span>
    </div>
    <div class="topbar-right">
        <a href="{{ route('welcome_page') }}" class="topbar-icon-btn" target="_blank" title="View Website">
            <i class="ri-external-link-line"></i>
        </a>
        <div class="topbar-user-dropdown dropdown">
            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div style="width:36px;height:36px;border-radius:50%;background:var(--theme-color);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1rem;">
                    A
                </div>
                <div class="d-none d-md-block text-start">
                    <div class="user-name">Admin</div>
                    <div class="user-role">Administrator</div>
                </div>
                <i class="ri-arrow-down-s-line" style="font-size:.9rem;color:#888;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('admin_logout') }}">
                        <i class="ri-logout-box-line"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
