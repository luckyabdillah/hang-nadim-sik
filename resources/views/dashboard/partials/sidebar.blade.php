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
        @if ($isExternal)
            <!-- Dashboard -->
            <li class="menu-item {{ Request::is('dashboard/my') ? 'active' : '' }}">
                <a href="/dashboard/my" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Permohonan</span>
            </li>
            <li class="menu-item {{ Request::is('dashboard/my/work-permit-letters*') ? 'active' : '' }}">
                <a href="/dashboard/my/work-permit-letters" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-collection"></i>
                    <div data-i18n="SIK">SIK</div>
                </a>
            </li>
        @else
            <!-- Dashboard -->
            <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="/dashboard" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            @if (in_array('dashboard_copies_view', $userPermissions) || in_array('dashboard_work-types_view', $userPermissions) || in_array('dashboard_work-locations_view', $userPermissions) || in_array('dashboard_letter-fundamentals_view', $userPermissions))
                <li class="menu-item {{ Request::is('dashboard/copies*') || Request::is('dashboard/work-types*') || Request::is('dashboard/work-locations*') || Request::is('dashboard/letter-fundamentals*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-hive"></i>
                        <div data-i18n="Master Data">Master Data</div>
                    </a>
                    <ul class="menu-sub">
                        @if (in_array('dashboard_copies_view', $userPermissions))
                            <li class="menu-item {{ Request::is('dashboard/copies*') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.copies.index') }}" class="menu-link">
                                    <div data-i18n="Tembusan">Tembusan</div>
                                </a>
                            </li>
                        @endif
                        @if (in_array('dashboard_work-types_view', $userPermissions))
                            <li class="menu-item {{ Request::is('dashboard/work-types*') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.work-types.index') }}" class="menu-link">
                                    <div data-i18n="Tipe Pekerjaan">Tipe Pekerjaan</div>
                                </a>
                            </li>
                        @endif
                        @if (in_array('dashboard_work-locations_view', $userPermissions))
                            <li class="menu-item {{ Request::is('dashboard/work-locations*') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.work-locations.index') }}" class="menu-link">
                                    <div data-i18n="Lokasi Pekerjaan">Lokasi Pekerjaan</div>
                                </a>
                            </li>
                        @endif
                        @if (in_array('dashboard_letter-fundamentals_view', $userPermissions))
                            <li class="menu-item {{ Request::is('dashboard/letter-fundamentals*') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.letter-fundamentals.index') }}" class="menu-link">
                                    <div data-i18n="Lokasi Pekerjaan">Dasar Surat</div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (in_array('access_application', $userPermissions))
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Permohonan</span>
                </li>
                @if (in_array('dashboard_work-permit-letters_view', $userPermissions))
                    <li class="menu-item {{ Request::is('dashboard/work-permit-letters*') ? 'active' : '' }}">
                        <a href="/dashboard/work-permit-letters" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-collection"></i>
                            <div data-i18n="SIK">SIK</div>
                        </a>
                    </li>
                @endif
                @if (in_array('dashboard_approvals_view', $userPermissions))
                    <li class="menu-item {{ Request::is('dashboard/approvals*') ? 'active' : '' }}">
                        <a href="/dashboard/approvals" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-comment-check"></i>
                            <div data-i18n="Persetujuan">Persetujuan</div>
                        </a>
                    </li>
                @endif
            @endif
            @if (in_array('access_management', $userPermissions))
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Manajemen</span>
                </li>
                @if (in_array('dashboard_vendors_view', $userPermissions))
                    <li class="menu-item {{ Request::is('dashboard/vendors*') ? 'active' : '' }}">
                        <a href="/dashboard/vendors" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-store"></i>
                            <div data-i18n="Vendor">Vendor</div>
                        </a>
                    </li>
                @endif
                @if (in_array('dashboard_permissions_view', $userPermissions) || in_array('dashboard_roles_view', $userPermissions) || in_array('dashboard_users_view', $userPermissions))
                    <li class="menu-item {{ Request::is('dashboard/user-management*') ? 'active open' : '' }}">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-briefcase"></i>
                            <div data-i18n="Manajemen User">Manajemen User</div>
                        </a>
                        <ul class="menu-sub">
                            @if (in_array('dashboard_permissions_view', $userPermissions))
                                <li class="menu-item {{ Request::is('dashboard/user-management/permissions*') ? 'active' : '' }}">
                                    <a href="/dashboard/user-management/permissions" class="menu-link">
                                        <div data-i18n="Izin Akses">Izin Akses</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('dashboard_roles_view', $userPermissions))
                                <li class="menu-item {{ Request::is('dashboard/user-management/roles*') ? 'active' : '' }}">
                                    <a href="/dashboard/user-management/roles" class="menu-link">
                                        <div data-i18n="Role">Role</div>
                                    </a>
                                </li>
                            @endif
                            @if (in_array('dashboard_users_view', $userPermissions))
                                <li class="menu-item {{ Request::is('dashboard/user-management/users*') ? 'active' : '' }}">
                                    <a href="/dashboard/user-management/users" class="menu-link">
                                        <div data-i18n="Pengguna">Pengguna</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (in_array('dashboard_approvers_view', $userPermissions))
                    <li class="menu-item {{ Request::is('dashboard/approvers*') ? 'active' : '' }}">
                        <a href="/dashboard/approvers" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-check-shield"></i>
                            <div data-i18n="Approver">Approver</div>
                        </a>
                    </li>
                @endif
            @endif
        @endif
    </ul>
</aside>