<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
    data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
    data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
    data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
    <!--begin::Menu-->
    <div class="menu menu-rounded dark menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
        id="kt_app_header_menu" data-kt-menu="true">
        <!--begin:Menu item-->


        <div
            class="menu-item menu-here-bg me-0 me-lg-2 menu-hover-bg menu-hover-bg-warning {{ request()->routeIs('dashboard') ? 'here show ' : '' }}">
            <a href="{{ route('dashboard') }}"
                class="menu-link px-4 {{ request()->routeIs('dashboard') ? 'active ' : '' }}">

                <span class="menu-title">Dashboards</span>
            </a>
        </div>
        <!--end:Menu item-->
        @canany(['dealer-list'])
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
                class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                <!--begin:Menu link-->
                <span class="menu-link py-3">
                    <span class="menu-title">Apps</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">

                    @can('dealer-list')
                        <div class="menu-item ">
                            <!--begin:Menu link-->
                            <a class="menu-link py-3" href="">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-bank fs-2"></i>
                                </span>
                                <span class="menu-title">Dealer</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                    @endcan

                </div>
                <!--end:Menu sub-->
            </div>
            <!--end:Menu item-->
        @endcanany
        <!--begin:Menu item-->
        @canany(['user-list', 'role-list', 'province-list', 'regency-list', 'district-list', 'village-list'])
            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
                class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                <!--begin:Menu link-->
                <span
                    class="menu-link py-3 {{ request()->routeIs(
                        'users.index',
                        'roles.index',
                        'data-wilayah-provinsi.index',
                        'data-wilayah-kabupaten.index',
                        'data-wilayah-kecamatan.index',
                        'data-wilayah-desa.index',
                    )
                        ? 'active '
                        : '' }}">
                    <span class="menu-title">Resources</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                    @can('user-list')
                        <!--begin:Menu item-->
                        <div class="menu-item {{ request()->routeIs('users.index') ? 'here show ' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link py-3" href="{{ route('users.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-profile-user fs-2"></i>
                                </span>
                                <span class="menu-title">User Management</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                    @can('role-list')
                        <!--begin:Menu item-->
                        <div class="menu-item {{ request()->routeIs('roles.index') ? 'here show ' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link py-3" href="{{ route('roles.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-security-user fs-2"></i>
                                </span>
                                <span class="menu-title">Role Management</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                    @canany(['province-list', 'regency-list', 'district-list', 'village-list'])
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start"
                            class="menu-item menu-lg-down-accordion">
                            <!--begin:Menu link-->
                            <span
                                class="menu-link py-3 {{ request()->routeIs(
                                    'data-wilayah-provinsi.index',
                                    'data-wilayah-kabupaten.index',
                                    'data-wilayah-kecamatan.index',
                                    'data-wilayah-desa.index',
                                )
                                    ? 'active '
                                    : '' }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-pointers fs-2"></i>
                                </span>
                                <span class="menu-title">Region</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div
                                class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">

                                <!--begin:Menu item-->
                                @can('province-list')
                                    <div
                                        class="menu-item {{ request()->routeIs('data-wilayah-provinsi.index') ? 'here show ' : '' }}">
                                        <!--begin:Menu link-->
                                        <a class="menu-link py-3" href="{{ route('data-wilayah-provinsi.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Province</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                @endcan
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                @can('regency-list')
                                    <div
                                        class="menu-item {{ request()->routeIs('data-wilayah-kabupaten.index') ? 'here show ' : '' }}">
                                        <!--begin:Menu link-->
                                        <a class="menu-link py-3" href="{{ route('data-wilayah-kabupaten.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Regency</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                @endcan
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                @can('district-list')
                                    <div
                                        class="menu-item {{ request()->routeIs('data-wilayah-kecamatan.index') ? 'here show ' : '' }}">
                                        <!--begin:Menu link-->
                                        <a class="menu-link py-3" href="{{ route('data-wilayah-kecamatan.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">District</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                @endcan
                                <!--end:Menu item-->
                                <!--begin:Menu item-->
                                @can('village-list')
                                    <div class="menu-item {{ request()->routeIs('data-wilayah-desa.index') ? 'here show ' : '' }}">
                                        <!--begin:Menu link-->
                                        <a class="menu-link py-3" href="{{ route('data-wilayah-desa.index') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Village</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                @endcan
                                <!--end:Menu item-->
                            </div>
                            <!--end:Menu sub-->
                        </div>
                    @endcanany
                    <!--end:Menu item-->




                </div>
                <!--end:Menu sub-->
            </div>
        @endcanany
        <!--end:Menu item-->
        @canany(['logactivity-list', 'changelog-list'])
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start"
                class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                <!--begin:Menu link-->
                <span
                    class="menu-link py-3 {{ request()->routeIs('changelog.index', 'log-activity.index') ? 'active ' : '' }}">
                    <span class="menu-title">Help</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
                <!--end:Menu link-->
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                    @can('changelog-list')
                        <!--begin:Menu item-->
                        <div class="menu-item {{ request()->routeIs('changelog.index') ? 'here show ' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link py-3" href="{{ route('changelog.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-code fs-2"></i>
                                </span>
                                <span class="menu-title">Changelog</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                    @can('logactivity-list')
                        <!--begin:Menu item-->
                        <div class="menu-item {{ request()->routeIs('log-activity.index') ? 'here show ' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link py-3" href="{{ route('log-activity.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-message-programming fs-2"></i>
                                </span>
                                <span class="menu-title">Log Activity</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                </div>
                <!--end:Menu sub-->
            </div>
            <!--end:Menu item-->
        @endcanany
    </div>
    <!--end::Menu-->
</div>
