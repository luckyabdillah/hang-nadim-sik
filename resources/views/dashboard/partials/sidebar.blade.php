<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/dashboard" class="app-brand-link p-0 m-0 mx-auto">
            <img src="{{ asset('assets/img/logo/secondary.png') }}" alt="" class="img-fluid" width="160">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a> 
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner pt-2 pb-5">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('dashboard/users*') ? 'active' : '' }}">
            <a href="/dashboard/users" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('dashboard/vendors*') ? 'active' : '' }}">
            <a href="/dashboard/vendors" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div data-i18n="Vendors">Vendors</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('dashboard/work-types*') ? 'active' : '' }}">
            <a href="/dashboard/work-types" class="menu-link">
                <i class="menu-icon tf-icons bx bx-briefcase"></i>
                <div data-i18n="Work Types">Work Types</div>
            </a>
        </li>
    </ul>
</aside>