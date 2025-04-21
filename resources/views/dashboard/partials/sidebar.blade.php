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
        <li class="menu-item {{ Request::is('dashboard/work-locations*') ? 'active' : '' }}">
            <a href="/dashboard/work-locations" class="menu-link">
                <i class="menu-icon tf-icons bx bx-map-pin"></i>
                <div data-i18n="Work Locations">Work Locations</div>
            </a>
        </li>
    </ul>
</aside>