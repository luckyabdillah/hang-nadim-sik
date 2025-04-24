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
        <li class="menu-item {{ Request::is('dashboard/copies*') || Request::is('dashboard/work-types*') || Request::is('dashboard/work-locations*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-hive"></i>
                <div data-i18n="Master Data">Master Data</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('dashboard/copies*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.copies.index') }}" class="menu-link">
                        <div data-i18n="Tembusan">Tembusan</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('dashboard/work-types*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.work-types.index') }}" class="menu-link">
                        <div data-i18n="Tipe Pekerjaan">Tipe Pekerjaan</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('dashboard/work-locations*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.work-locations.index') }}" class="menu-link">
                        <div data-i18n="Lokasi Pekerjaan">Lokasi Pekerjaan</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Permohonan</span>
        </li>
        <li class="menu-item {{ Request::is('dashboard/work-permit-letters*') ? 'active' : '' }}">
            <a href="/dashboard/work-permit-letters" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="SIK">SIK</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('dashboard/approvals*') ? 'active' : '' }}">
            <a href="/dashboard/approvals" class="menu-link">
                <i class="menu-icon tf-icons bx bx-comment-check"></i>
                <div data-i18n="Persetujuan">Persetujuan</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('dashboard/vendors*') ? 'active' : '' }}">
            <a href="/dashboard/vendors" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div data-i18n="Vendor">Vendor</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('dashboard/registration*') ? 'active' : '' }}">
            <a href="/dashboard/registration" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-i18n="Registrasi">Registrasi</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Manajemen</span>
        </li>
        <li class="menu-item {{ Request::is('dashboard/users*') || Request::is('dashboard/approvers*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Pengguna">Pengguna</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('dashboard/approvers*') ? 'active' : '' }}">
                    <a href="/dashboard/approvers" class="menu-link">
                        <div data-i18n="Approver">Approver</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('dashboard/applicants*') ? 'active' : '' }}">
                    <a href="/dashboard/applicants" class="menu-link">
                        <div data-i18n="Pemohon / Applicant">Pemohon / Applicant</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('dashboard/users*') ? 'active' : '' }}">
                    <a href="/dashboard/users" class="menu-link">
                        <div data-i18n="Lainnya">Lainnya</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>