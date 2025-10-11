<div class="app-navbar flex-shrink-0">
    <!--begin::Notifications-->
    <div class="app-navbar-item">
        <!--begin::Menu- wrapper-->
        <div class="btn btn-icon btn-icon-gray-600 btn-active-color-primary"
            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom">
            <i class="ki-outline ki-notification-on fs-1"></i>
        </div>
        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true"
            id="kt_menu_notifications">
            <!--begin::Heading-->
            <div class="d-flex flex-column bgi-no-repeat rounded-top"
                style="background-image:url('{{ asset('assets/media/misc/menu-header-bg.jpg') }}')">
                <!--begin::Title-->
                <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
                    <span class="fs-8 opacity-75 ps-3">24 reports</span>
                </h3>
                <!--end::Title-->
                <!--begin::Tabs-->
                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                    {{-- <li class="nav-item">
                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                            href="#kt_topbar_notifications_1">Alerts</a>
                    </li> --}}

                    <li class="nav-item">
                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab"
                            href="#kt_topbar_notifications_3">Logs</a>
                    </li>
                </ul>
                <!--end::Tabs-->
            </div>
            <!--end::Heading-->
            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab panel-->
                <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
                    <!--begin::Items-->
                    <div class="scroll-y mh-325px my-5 px-8">
                        <!--begin::Item-->
                        <div class="d-flex flex-stack py-4">
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-35px me-4">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="ki-outline ki-abstract-28 fs-2 text-primary"></i>
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Title-->
                                <div class="mb-0 me-2">
                                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project
                                        Alice</a>
                                    <div class="text-gray-500 fs-7">Phase 1 development</div>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Label-->
                            <span class="badge badge-light fs-8">1 hr</span>
                            <!--end::Label-->
                        </div>
                        <!--end::Item-->

                    </div>
                    <!--end::Items-->
                    <!--begin::View more-->
                    <div class="py-3 text-center border-top">
                        <a href="pages/user-profile/activity.html"
                            class="btn btn-color-gray-600 btn-active-color-primary">View All
                            <i class="ki-outline ki-arrow-right fs-5"></i></a>
                    </div>
                    <!--end::View more-->
                </div>
                <!--end::Tab panel-->

                <!--begin::Tab panel-->
                <div class="tab-pane fade show active" id="kt_topbar_notifications_3" role="tabpanel">
                    <!--begin::Items-->
                    <div class="scroll-y mh-325px my-5 px-8">

                        @forelse($userActivities as $activity)
                            <!--begin::Item-->
                            <div class="d-flex flex-stack py-4">
                                <!--begin::Section-->
                                <div class="d-flex align-items-center me-2">


                                    <!--end::Code-->
                                    <!--begin::Title-->
                                    <a class="text-gray-800 fs-8 text-hover-primary fw-semibold">
                                        {{ $activity->description }}
                                    </a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Label-->
                                <span class="badge badge-secondary fs-9">
                                    {{ $activity->created_at->diffForHumans() }}
                                </span>
                                <!--end::Label-->
                            </div>
                            <!--end::Item-->
                        @empty
                            <div class="text-center text-gray-500 py-10">
                                Tidak ada aktivitas terbaru.
                            </div>
                        @endforelse

                    </div>
                    <!--end::Items-->

                    <!--begin::View more-->
                    <div class="py-3 text-center border-top">
                        <a href="{{ route('users-log.index') }}"
                            class="btn btn-color-gray-600 btn-active-color-primary">
                            Lihat Semua
                            <i class="ki-outline ki-arrow-right fs-5"></i>
                        </a>
                    </div>
                    <!--end::View more-->
                </div>

                <!--end::Tab panel-->
            </div>
            <!--end::Tab content-->
        </div>
        <!--end::Menu-->
        <!--end::Menu wrapper-->
    </div>
    <!--end::Notifications-->


    <!--begin::User menu-->
    <div class="app-navbar-item ms-3 ms-lg-9" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <!--begin:Info-->
            <div class="text-end d-none d-sm-flex flex-column justify-content-center me-3">
                <span class="text-gray-500 fs-8 fw-bold">Hello</span>
                <a href="{{ route('profile.index') }}"
                    class="text-gray-800 text-hover-primary fs-7 fw-bold d-block">{{ ucwords(strtolower(Auth::user()->name)) }}</a>
            </div>
            <!--end:Info-->
            <!--begin::User-->

            <div class="cursor-pointer symbol symbol-circle symbol-35px symbol-md-40px">
                {{-- @if (Auth::user()->avatar)
                    <img class="" src="{{ asset('uploads/user/avatar/' . Auth::user()->avatar) }}"
                        alt="{{ Auth::user()->name }}" />
                @else
                    <div class="symbol-label fs-3 bg-light-primary text-primary">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif --}}

                @if (Auth::user()->avatar)
                    @if (Auth::user()->provider == 'google')
                        <!-- Jika provider adalah Google, tampilkan avatar dari URL Google -->
                        <img class="" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" />
                    @else
                        <!-- Jika provider bukan Google (misalnya aplikasi Laravel), tampilkan avatar lokal -->
                        <img class="" src="{{ asset('uploads/user/avatar/' . Auth::user()->avatar) }}"
                            alt="{{ Auth::user()->name }}" />
                    @endif
                @else
                    <!-- Jika tidak ada avatar, tampilkan inisial nama pengguna -->
                    <div class="symbol-label fs-3 bg-light-primary text-primary">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <div
                    class="position-absolute translate-middle bottom-0 mb-1 start-100 ms-n1 bg-success rounded-circle h-8px w-8px">
                </div>
            </div>

            <!--end::User-->
        </div>
        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">


                        @if (Auth::user()->avatar)
                            @if (Auth::user()->provider == 'google')
                                <!-- Jika provider adalah Google, tampilkan avatar dari URL Google -->
                                <img class="" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" />
                            @else
                                <!-- Jika provider bukan Google (misalnya aplikasi Laravel), tampilkan avatar lokal -->
                                <img class="" src="{{ asset('uploads/user/avatar/' . Auth::user()->avatar) }}"
                                    alt="{{ Auth::user()->name }}" />
                            @endif
                        @else
                            <!-- Jika tidak ada avatar, tampilkan inisial nama pengguna -->
                            <div class="symbol-label fs-3 bg-light-primary text-primary">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-6">
                            {{ ucwords(strtolower(Auth::user()->name)) }}

                        </div>
                        <a href="#"
                            class="fw-semibold text-muted text-hover-primary fs-9">{{ ucwords(strtolower(Auth::user()->email)) }}</a>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->
            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="{{ route('profile.index') }}" class="menu-link px-5">My Profile</a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="{{ route('setting_app.edit') }}" class="menu-link px-5">
                    Setting App
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->
            <!--begin::Menu item-->
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title position-relative">Mode
                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                            <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                            <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                        </span></span>
                </a>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-outline ki-night-day fs-2"></i>
                            </span>
                            <span class="menu-title">Light</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-outline ki-moon fs-2"></i>
                            </span>
                            <span class="menu-title">Dark</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-outline ki-screen fs-2"></i>
                            </span>
                            <span class="menu-title">System</span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Menu item-->


            <!--begin::Menu item-->
            <!--begin::Menu item-->
            <!--begin::Menu item-->
            <!--begin::Menu item-->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div class="menu-item px-5">
                <a href="#" onclick="event.preventDefault(); showLogoutConfirmation();"
                    class="menu-link px-5">Sign Out</a>
            </div>







            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->
        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
</div>

@push('stylesheets')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@push('scripts')
    <script type="text/javascript">
        function showLogoutConfirmation() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out!",
                icon: 'warning',
                showCancelButton: true,
                //confirmButtonColor: '#3085d6',
                //cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log me out!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: "btn btn-sm btn-primary",
                    cancelButton: "btn btn-sm btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
@endpush
